@extends('layouts.app')

@section('title', 'Sales Report - NexStack')
@section('page-title', 'REPORTS')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Sales Report</h5>
        <div class="mt-2">
            <input type="date" class="form-control d-inline-block" style="width: auto;" placeholder="From Date">
            <input type="date" class="form-control d-inline-block" style="width: auto;" placeholder="To Date">
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td><span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'secondary' }}">{{ ucfirst($transaction->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No sales transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<a href="{{ route('reports.index') }}" class="btn btn-success">Back to Reports</a>
@endsection

