<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('warehouses.create');
        }

        return redirect()->route('warehouses.index');
    }

    public function store(Request $request)
    {
        if (!(Auth::check() && Auth::user()->role === 'admin')) {
            return redirect()->route('warehouses.index');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Warehouse::create($request->only(['name', 'location', 'status']));

        return redirect()->route('warehouses.index')->with('success', 'Warehouse created successfully!');
    }

    public function edit(Warehouse $warehouse)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('warehouses.edit', compact('warehouse'));
        }

        return redirect()->route('warehouses.index');
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        if (!(Auth::check() && Auth::user()->role === 'admin')) {
            return redirect()->route('warehouses.index');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $warehouse->update($request->only(['name', 'location', 'status']));

        return redirect()->route('warehouses.index')->with('success', 'Warehouse updated successfully!');
    }

    public function destroy(Warehouse $warehouse)
    {
        if (!(Auth::check() && Auth::user()->role === 'admin')) {
            return redirect()->route('warehouses.index');
        }

        $warehouse->delete();

        return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted successfully!');
    }
}


