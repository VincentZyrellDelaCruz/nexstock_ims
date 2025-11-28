@extends('layouts.app')

@section('title', 'Inventory - NexStack')
@section('page-title', 'INVENTORY')

@section('content')
@if (Auth::check() && Auth::user()->role === 'admin')
    <div class="mb-3">
        <a href="{{ route('inventory.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add Inventory
        </a>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Inventory List</h5>
        @include('components._table_search', ['placeholder' => 'Search inventory...'])
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
                    <th>Actions</th>
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
                    <td>
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        No inventory items found.
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('inventory.create') }}"> Add one now</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

