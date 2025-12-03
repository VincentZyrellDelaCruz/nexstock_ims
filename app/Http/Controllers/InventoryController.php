<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Warehouse;

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
        ]);

        // Get the first (and only) warehouse
        $warehouse = Warehouse::first();
        $warehouseId = $warehouse ? $warehouse->id : null;

        Inventory::create([
            'product_id' => $request->product_id,
            'warehouse_id' => $warehouseId,
            'quantity' => $request->quantity,
            'status' => $request->quantity > 10 ? 'in_stock' : ($request->quantity > 0 ? 'low_stock' : 'out_of_stock'),
        ]);
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
            'quantity' => 'required|integer|min:0'
        ]);

        // Get the first (and only) warehouse
        $warehouse = Warehouse::first();
        $warehouseId = $warehouse ? $warehouse->id : null;

        $inventory->update([
            'product_id' => $request->product_id,
            'warehouse_id' => $warehouseId,
            'quantity' => $request->quantity,
            'status' => $request->quantity > 10 ? 'in_stock' : ($request->quantity > 0 ? 'low_stock' : 'out_of_stock'),
        ]);
        
        return redirect()->route('inventory.index')->with('success', 'Inventory item updated successfully!');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Inventory item deleted successfully!');
    }
}

