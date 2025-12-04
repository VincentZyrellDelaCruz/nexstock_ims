<?php

namespace App\Http\Controllers;

use App\Models\RestockConfirmation;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\Transaction;
use App\Models\Pending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\EmailNotificationService;

class RestockConfirmationController extends Controller
{
    protected $emailService;

    public function __construct(EmailNotificationService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $restockRequests = RestockConfirmation::with(['product', 'warehouse', 'requester', 'supplier'])
                ->orderBy('created_at', 'desc')
                ->get();
            return view('restock.index', compact('restockRequests'));
        }

        // Staff can only see their own requests
        $restockRequests = RestockConfirmation::where('requested_by', Auth::id())
            ->with(['product', 'warehouse', 'requester'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('restock.index', compact('restockRequests'));
    }

    public function create()
    {
        $products = Product::all();
        $warehouses = Warehouse::where('status', 'active')->get();
        return view('restock.create', compact('products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'requested_quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string',
        ]);

        $restockRequest = RestockConfirmation::create([
            'product_id' => $request->product_id,
            'warehouse_id' => $request->warehouse_id,
            'requested_quantity' => $request->requested_quantity,
            'reason' => $request->reason,
            'requested_by' => Auth::id(),
            'status' => 'pending',
        ]);

        // Load product for message
        $restockRequest->load('product');

        // Create pending notification
        Pending::create([
            'type' => 'restock',
            'reference_id' => $restockRequest->id,
            'created_by' => Auth::id(),
            'status' => 'pending',
            'message' => "Restock request for {$restockRequest->product->name}",
        ]);

        return redirect()->route('restock.index')
            ->with('success', 'Restock request submitted successfully!');
    }

    public function show(RestockConfirmation $restockConfirmation)
    {
        $restockConfirmation->load(['product', 'warehouse', 'requester', 'supplier', 'reviewer']);
        return view('restock.show', compact('restockConfirmation'));
    }

    public function approve(Request $request, RestockConfirmation $restockConfirmation)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }

        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'admin_notes' => 'nullable|string',
        ]);

        $restockConfirmation->update([
            'status' => 'approved',
            'supplier_id' => $request->supplier_id,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $request->admin_notes,
        ]);

        // Update pending status
        $pending = Pending::where('type', 'restock')
            ->where('reference_id', $restockConfirmation->id)
            ->first();
        if ($pending) {
            $pending->update(['status' => 'reviewed']);
        }

        // Send email to supplier
        $this->emailService->sendRestockConfirmationEmail($restockConfirmation);

        return redirect()->route('restock.show', $restockConfirmation)
            ->with('success', 'Restock request approved and supplier notified!');
    }

    public function complete(RestockConfirmation $restockConfirmation)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }

        // Create inventory entry or update existing
        $inventory = Inventory::firstOrNew([
            'product_id' => $restockConfirmation->product_id,
            'warehouse_id' => $restockConfirmation->warehouse_id,
        ]);

        $inventory->quantity = ($inventory->quantity ?? 0) + $restockConfirmation->requested_quantity;
        $inventory->status = $inventory->quantity > 10 ? 'in_stock' : ($inventory->quantity > 0 ? 'low_stock' : 'out_of_stock');
        $inventory->save();

        // Create transaction record
        Transaction::create([
            'product_id' => $restockConfirmation->product_id,
            'quantity' => $restockConfirmation->requested_quantity,
            'type' => 'in',
            'date' => now(),
            'status' => 'completed',
        ]);

        // Update restock confirmation status
        $restockConfirmation->update(['status' => 'completed']);

        // Update pending status
        $pending = Pending::where('type', 'restock')
            ->where('reference_id', $restockConfirmation->id)
            ->first();
        if ($pending) {
            $pending->update([
                'status' => 'resolved',
                'resolved_at' => now(),
            ]);
        }

        return redirect()->route('restock.show', $restockConfirmation)
            ->with('success', 'Restock completed and stock updated!');
    }

    public function reject(Request $request, RestockConfirmation $restockConfirmation)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }

        $restockConfirmation->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $request->admin_notes ?? 'Request rejected',
        ]);

        $pending = Pending::where('type', 'restock')
            ->where('reference_id', $restockConfirmation->id)
            ->first();
        if ($pending) {
            $pending->update([
                'status' => 'resolved',
                'resolved_at' => now(),
            ]);
        }

        return redirect()->route('restock.index')
            ->with('success', 'Restock request rejected');
    }
}

