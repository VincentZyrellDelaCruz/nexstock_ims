@extends('layouts.app')

@section('title', 'Edit Inventory - NexStack')
@section('page-title', 'INVENTORY')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Inventory Item</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select class="form-select" id="product_id" name="product_id" required>
                    <option value="">Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $inventory->product_id) == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $inventory->quantity) }}" min="0" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('inventory.index') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
@endsection

