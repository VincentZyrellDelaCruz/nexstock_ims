@extends('layouts.app')

@section('title', 'Products - NexStack')
@section('page-title', 'PRODUCTS')

@section('content')
@if (Auth::user()->role === 'admin')
    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add Product
        </a>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Products List</h5>
        @include('components._table_search', ['placeholder' => 'Search products...'])
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Status</th>
                    @if (Auth::check() && Auth::user()->role === 'admin') <th>Actions</th> @endif
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'N/A' }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>₱{{ number_format($product->price, 2) }}</td>
                    <td><span class="badge bg-{{ $product->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($product->status) }}</span></td>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <td>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No products found. @if (Auth::user()->role === 'admin') <a href="{{ route('products.create') }}">Add one now</a> @endif </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

