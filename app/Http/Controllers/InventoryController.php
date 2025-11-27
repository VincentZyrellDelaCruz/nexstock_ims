<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with('product.category')->get();
        return view('inventory.index', compact('inventory'));
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $products = Product::all();
            return view('inventory.create', compact('products'));
        }
        return redirect('/dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string',
        ]);

        Inventory::create($request->all());
        return redirect()->route('inventory.index')->with('success', 'Inventory item added successfully!');
    }

    public function edit(Inventory $inventory)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $products = Product::all();
            return view('inventory.edit', compact('inventory', 'products'));
        }
        return redirect('/dashboard');
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|string',
        ]);

        $inventory->update($request->all());
        return redirect()->route('inventory.index')->with('success', 'Inventory item updated successfully!');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Inventory item deleted successfully!');
    }
}

