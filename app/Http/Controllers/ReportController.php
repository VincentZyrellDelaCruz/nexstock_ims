<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Inventory;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function sales()
    {
        $transactions = Transaction::where('type', 'out')
            ->with('product')
            ->get();
        return view('reports.sales', compact('transactions'));
    }

    public function inventory()
    {
        $inventory = Inventory::with('product.category')->get();
        return view('reports.inventory', compact('inventory'));
    }

    public function supplier()
    {
        $suppliers = Supplier::all();
        return view('reports.supplier', compact('suppliers'));
    }
}

