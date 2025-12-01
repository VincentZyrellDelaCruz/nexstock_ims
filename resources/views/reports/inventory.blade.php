@extends('layouts.app')

@section('title', 'Inventory Report - NexStack')
@section('page-title', 'REPORTS')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Inventory Report</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventory as $item)
                <tr>
                    <td>{{ $item->product_id }}</td>
                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                    <td>{{ $item->product->category->name ?? 'N/A' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td><span class="badge bg-{{ $item->status == 'in_stock' ? 'success' : 'warning' }}">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No inventory items found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<a href="{{ route('reports.index') }}" class="btn btn-success">Back to Reports</a>
@endsection

