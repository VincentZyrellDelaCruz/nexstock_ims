<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defect;
use App\Models\Pending;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Services\EmailNotificationService;

class QualityController extends Controller
{
    protected $emailService;

    public function __construct(EmailNotificationService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index(Request $request)
    {
        $query = Defect::with(['product', 'reporter']);

        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;

            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        $defects = $query->get();

        return view('quality.index', compact('defects'));
    }

    public function create()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['staff', 'admin'])) {
            $products = Product::all();
            return view('quality.create', compact('products'));
        }
        return redirect('/dashboard')->with('error', 'You are not authorized to create a defect report.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_affected' => 'required|integer|min:0',
            'description' => 'required|string|max:255',
            'proof_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'reported_by' => 'required|exists:users,id'
        ]);

        $defect = Defect::create([
            'product_id' => $request->product_id,
            'quantity_affected' => $request->quantity_affected,
            'description' => $request->description,
            'reported_by' => $request->reported_by,
            'status' => 'pending'
        ]);

        if ($request->hasFile('proof_image')) {
            // Create defects folder if it doesn't exist
            $folder = 'defects/' . date('Y/m');
            $path = $request->file('proof_image')->store($folder, 'public');
            $defect->update(['proof_image' => $path]);
        }

        // Create pending notification
        Pending::create([
            'type' => 'defect',
            'reference_id' => $defect->id,
            'created_by' => Auth::id(),
            'status' => 'pending',
            'message' => "New defect report for {$defect->product->name}",
        ]);

        return redirect()->route('defects.index')
            ->with('success', 'Defect report submitted successfully!');
    }

    public function show(Defect $defect)
    {
        $defect->load(['product', 'reporter', 'reviewer', 'supplier']);
        return view('quality.show', compact('defect'));
    }

    public function approve(Request $request, Defect $defect)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'action_taken' => 'nullable|string',
        ]);

        $defect->update([
            'status' => 'approved',
            'supplier_id' => $request->supplier_id,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'action_taken' => $request->action_taken,
        ]);

        // Update pending status
        $pending = Pending::where('type', 'defect')
            ->where('reference_id', $defect->id)
            ->first();
        if ($pending) {
            $pending->update(['status' => 'reviewed']);
        }

        // Send email to supplier for replacement
        $this->emailService->sendDefectReplacementEmail($defect);

        return redirect()->route('defects.show', $defect)
            ->with('success', 'Defect approved and supplier notified for replacement!');
    }

    public function reject(Request $request, Defect $defect)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }

        $defect->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'action_taken' => $request->action_taken ?? 'Rejected',
        ]);

        $pending = Pending::where('type', 'defect')
            ->where('reference_id', $defect->id)
            ->first();
        if ($pending) {
            $pending->update([
                'status' => 'resolved',
                'resolved_at' => now(),
            ]);
        }

        return redirect()->route('defects.index')
            ->with('success', 'Defect report rejected');
    }
}
