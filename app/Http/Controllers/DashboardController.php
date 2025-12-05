<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\Models\Inventory;
use App\Models\Pending;
use App\Services\StockMonitoringService;

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
            // Calculate low stock items based on quantity threshold
            $lowStockProducts = Inventory::where('quantity', '>', 0)
                ->where('quantity', '<=', 10)
                ->count();
            $outOfStockProducts = Inventory::where('quantity', '<=', 0)->count();
            
            // Get pending messages count (check if table exists first)
            $pendingCount = 0;
            if (Schema::hasTable('pendings')) {
                $pendingCount = Pending::where('status', 'pending')->count();
            }
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
                'outOfStockProducts',
                'pendingCount'
            ));
        }
        return redirect('/login');
    }
}

