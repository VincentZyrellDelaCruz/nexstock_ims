<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defect;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class QualityController extends Controller
{
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
            $path = $request->file('proof_image')->store(
                'defects',
                'public'
            );

            $defect->update(['proof_image' => $path]);
        }

        return redirect()->route('defects.index')
            ->with('success', 'Defect report submitted successfully!');
    }

    public function show(Defect $defect)
    {
        $defect->load(['product', 'reporter']);
        return view('quality.show', compact('defect'));
    }
}
