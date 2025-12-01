@extends('layouts.app')

@section('title', 'Transaction Details - NexStack')
@section('page-title', 'TRANSACTIONS')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Transaction Details</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Transaction ID:</th>
                <td>{{ $transaction->id }}</td>
            </tr>
            <tr>
                <th>Product:</th>
                <td>{{ $transaction->product->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Quantity:</th>
                <td>{{ $transaction->quantity }}</td>
            </tr>
            <tr>
                <th>Type:</th>
                <td><span class="badge bg-{{ $transaction->type == 'in' ? 'success' : 'warning' }}">{{ strtoupper($transaction->type) }}</span></td>
            </tr>
            <tr>
                <th>Date:</th>
                <td>{{ $transaction->date }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td><span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'secondary' }}">{{ ucfirst($transaction->status) }}</span></td>
            </tr>
        </table>
        <a href="{{ route('transactions.index') }}" class="btn btn-success">Back to Transactions</a>
    </div>
</div>
@endsection

