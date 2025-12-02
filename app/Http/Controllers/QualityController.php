<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Defect;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class QualityController extends Controller
{
    public function index()
    {
        $defects = Defect::with('product')->get();
        return view('quality.index', compact('defects'));
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->role === 'staff') {
            $products = Product::all();
            return view('quality.create', compact('products'));
        }
        return redirect('/dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

        Defect::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'status' => $request->quantity > 10 ? 'in_stock' : ($request->quantity > 0 ? 'low_stock' : 'out_of_stock'),
        ]);
        return redirect()->route('quality.index')->with('success', 'defect item added successfully!');
    }

    public function update(Request $request, Defect $defect)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0'
        ]);

        $defect->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'status' => $request->quantity > 10 ? 'in_stock' : ($request->quantity > 0 ? 'low_stock' : 'out_of_stock'),
        ]);

        return redirect()->route('quality.index')->with('success', 'defect item updated successfully!');
    }

    /* public function destroy(Defect $defect)
    {
        $defect->delete();
        return redirect()->route('defect.index')->with('success', 'Inventory item deleted successfully!');
    } */
}

