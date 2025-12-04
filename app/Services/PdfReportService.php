<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class PdfReportService
{
    /**
     * Generate PDF for inventory report
     */
    public function generateInventoryReport($filters = [])
    {
        $query = Inventory::with(['product.category', 'warehouse']);

        // Apply filters
        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['warehouse_id']) && $filters['warehouse_id']) {
            $query->where('warehouse_id', $filters['warehouse_id']);
        }

        if (isset($filters['low_stock']) && $filters['low_stock']) {
            $query->where('quantity', '<=', 10)->where('quantity', '>', 0);
        }

        $inventory = $query->orderBy('product_id')->get();

        $data = [
            'inventory' => $inventory,
            'filters' => $filters,
            'generated_at' => now(),
            'total_items' => $inventory->count(),
            'total_quantity' => $inventory->sum('quantity'),
        ];

        $pdf = Pdf::loadView('reports.inventory-pdf', $data);
        
        return $pdf;
    }

    /**
     * Download inventory report as PDF
     */
    public function downloadInventoryReport($filters = [])
    {
        $pdf = $this->generateInventoryReport($filters);
        $filename = 'inventory-report-' . now()->format('Y-m-d-His') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Stream inventory report PDF
     */
    public function streamInventoryReport($filters = [])
    {
        $pdf = $this->generateInventoryReport($filters);
        
        return $pdf->stream('inventory-report.pdf');
    }
}

