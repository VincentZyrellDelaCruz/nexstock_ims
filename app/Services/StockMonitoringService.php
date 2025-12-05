<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Alert;
use App\Models\RestockConfirmation;
use App\Models\Pending;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockMonitoringService
{
    /**
     * Check for low stock products and create alerts
     */
    public function checkLowStock($threshold = 10)
    {
        $lowStockItems = Inventory::where('quantity', '>', 0)
            ->where('quantity', '<=', $threshold)
            ->where('status', '!=', 'low_stock')
            ->with('product')
            ->get();

        foreach ($lowStockItems as $item) {
            // Update status
            $item->update(['status' => 'low_stock']);

            // Create alert for admins
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Alert::firstOrCreate(
                    [
                        'type' => 'low_stock',
                        'related_type' => 'inventory',
                        'related_id' => $item->id,
                        'user_id' => $admin->id,
                        'status' => 'unread',
                    ],
                    [
                        'title' => 'Low Stock Alert',
                        'message' => "Product {$item->product->name} is running low. Current quantity: {$item->quantity}",
                        'severity' => 'medium',
                    ]
                );
            }

            // Auto-create restock confirmation request
            $this->createRestockRequest($item);
        }

        return $lowStockItems;
    }

    /**
     * Check for out of stock products
     */
    public function checkOutOfStock()
    {
        $outOfStockItems = Inventory::where('quantity', '<=', 0)
            ->where('status', '!=', 'out_of_stock')
            ->with('product')
            ->get();

        foreach ($outOfStockItems as $item) {
            $item->update(['status' => 'out_of_stock']);

            // Create critical alert
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Alert::firstOrCreate(
                    [
                        'type' => 'out_of_stock',
                        'related_type' => 'inventory',
                        'related_id' => $item->id,
                        'user_id' => $admin->id,
                        'status' => 'unread',
                    ],
                    [
                        'title' => 'Out of Stock Alert',
                        'message' => "Product {$item->product->name} is out of stock!",
                        'severity' => 'critical',
                    ]
                );
            }
        }

        return $outOfStockItems;
    }

    /**
     * Create automatic restock request when low stock detected
     */
    protected function createRestockRequest($inventoryItem)
    {
        // Check if there's already a pending restock request
        $existingRequest = RestockConfirmation::where('product_id', $inventoryItem->product_id)
            ->where('warehouse_id', $inventoryItem->warehouse_id)
            ->where('status', 'pending')
            ->first();

        if (!$existingRequest) {
            $restockRequest = RestockConfirmation::create([
                'product_id' => $inventoryItem->product_id,
                'warehouse_id' => $inventoryItem->warehouse_id,
                'requested_quantity' => 50, // Default restock quantity
                'reason' => 'Automatic low stock alert',
                'requested_by' => Auth::id() ?? 1, // System or first admin
                'status' => 'pending',
            ]);

            // Create pending notification
            Pending::create([
                'type' => 'restock',
                'reference_id' => $restockRequest->id,
                'created_by' => Auth::id() ?? 1,
                'status' => 'pending',
                'message' => "Restock request for {$inventoryItem->product->name}",
            ]);
        }
    }

    /**
     * Get real-time stock status for all products
     */
    public function getRealTimeStockStatus()
    {
        return Inventory::with(['product', 'warehouse'])
            ->select('*', DB::raw('
                CASE 
                    WHEN quantity <= 0 THEN "out_of_stock"
                    WHEN quantity <= 10 THEN "low_stock"
                    ELSE "in_stock"
                END as stock_status
            '))
            ->get()
            ->map(function ($item) {
                $item->stock_status = $item->quantity <= 0 ? 'out_of_stock' : ($item->quantity <= 10 ? 'low_stock' : 'in_stock');
                return $item;
            });
    }
}

