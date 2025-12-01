@extends('layouts.app')

@section('title', 'Transactions - NexStack')
@section('page-title', 'TRANSACTIONS')

@section('content')
<div class="mb-3">
    <a href="{{ route('transactions.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Add Transaction
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5>Transactions List</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->product->name ?? 'N/A' }}</td>
                    <td>{{ $transaction->quantity }}</td>
                    <td><span class="badge bg-{{ $transaction->type == 'in' ? 'success' : 'warning' }}">{{ strtoupper($transaction->type) }}</span></td>
                    <td>{{ $transaction->date }}</td>
                    <td><span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'secondary' }}">{{ ucfirst($transaction->status) }}</span></td>
                    <td>
                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-success btn-sm">View Details</a>
                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

