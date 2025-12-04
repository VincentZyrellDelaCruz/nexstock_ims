<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $totalProducts = Product::count();
            $totalRevenue = Transaction::where('type', 'out')
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->sum(DB::raw('transactions.quantity * products.price'));
            $newOrders = Transaction::where('type', 'out')
                ->whereDate('created_at', today())
                ->count();
            $pendingOrders = Transaction::where('status', 'pending')->count();
            $lowStockProducts = Inventory::where('status', 'low_stock')->count();
            $outOfStockProducts = Inventory::where('status', 'out_of_stock')->count();
            $topProducts = Inventory::with('product')->orderBy('quantity', 'desc')->take(5)->get();
            $recentOrders = Transaction::with('product')->latest()->take(5)->get();

            return view('dashboard', compact(
                'totalProducts',
                'totalRevenue',
                'newOrders',
                'pendingOrders',
                'topProducts',
                'recentOrders',
                'lowStockProducts',
                'outOfStockProducts'
            ));
        }
        return redirect('/login');
    }
}

