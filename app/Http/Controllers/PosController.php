<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    /**
     * Display POS interface with available products
     */
    public function index()
    {
        $products = Product::with(['inventory', 'category'])
            ->where('status', 'active')
            ->get()
            ->map(function ($product) {
                // Get total quantity across all warehouses
                $totalQuantity = Inventory::where('product_id', $product->id)
                    ->sum('quantity');
                $product->available_quantity = $totalQuantity;
                return $product;
            });

        return view('pos.index', compact('products'));
    }

    /**
     * API endpoint to get product stock information
     */
    public function getStock($productId)
    {
        $product = Product::with(['inventory.warehouse'])->findOrFail($productId);
        
        $totalQuantity = Inventory::where('product_id', $productId)->sum('quantity');
        $inventories = Inventory::where('product_id', $productId)
            ->with('warehouse')
            ->get();

        return response()->json([
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
            ],
            'total_quantity' => $totalQuantity,
            'inventories' => $inventories,
            'available' => $totalQuantity > 0,
        ]);
    }

    /**
     * API endpoint to process sale and deplete stock
     */
    public function processSale(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'warehouse_id' => 'nullable|exists:warehouses,id',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::findOrFail($request->product_id);
            
            // Get available inventory
            $inventoryQuery = Inventory::where('product_id', $request->product_id)
                ->where('quantity', '>', 0);

            if ($request->warehouse_id) {
                $inventoryQuery->where('warehouse_id', $request->warehouse_id);
            }

            $inventory = $inventoryQuery->orderBy('quantity', 'desc')->first();

            if (!$inventory || $inventory->quantity < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available',
                    'available' => $inventory ? $inventory->quantity : 0,
                ], 400);
            }

            // Deplete stock
            $inventory->quantity -= $request->quantity;
            $inventory->status = $inventory->quantity > 10 ? 'in_stock' : ($inventory->quantity > 0 ? 'low_stock' : 'out_of_stock');
            $inventory->save();

            // Create transaction record
            $transaction = Transaction::create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'type' => 'out',
                'date' => now(),
                'status' => 'completed',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sale processed successfully',
                'transaction' => $transaction,
                'remaining_stock' => $inventory->quantity,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to process sale: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all products with stock for POS
     */
    public function getProducts()
    {
        $products = Product::with(['category'])
            ->where('status', 'active')
            ->get()
            ->map(function ($product) {
                $totalQuantity = Inventory::where('product_id', $product->id)->sum('quantity');
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'quantity' => $totalQuantity,
                    'available' => $totalQuantity > 0,
                    'category' => $product->category->name ?? 'Uncategorized',
                ];
            });

        return response()->json($products);
    }
}

