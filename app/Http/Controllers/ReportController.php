<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Services\PdfReportService;

class ReportController extends Controller
{
    protected $pdfService;

    public function __construct(PdfReportService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

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

    public function inventory(Request $request)
    {
        $warehouses = Warehouse::all();
        $inventory = Inventory::with('product.category', 'warehouse');

        // Apply filters
        if ($request->has('status') && $request->status) {
            $inventory->where('status', $request->status);
        }

        if ($request->has('warehouse_id') && $request->warehouse_id) {
            $inventory->where('warehouse_id', $request->warehouse_id);
        }

        if ($request->has('low_stock') && $request->low_stock) {
            $inventory->where('quantity', '<=', 10)->where('quantity', '>', 0);
        }

        $inventory = $inventory->get();
        return view('reports.inventory', compact('inventory', 'warehouses'));
    }

    public function inventoryPdf(Request $request)
    {
        $filters = $request->only(['status', 'warehouse_id', 'low_stock']);
        return $this->pdfService->downloadInventoryReport($filters);
    }

    public function supplier()
    {
        $suppliers = Supplier::all();
        return view('reports.supplier', compact('suppliers'));
    }
}

