@extends('layouts.app')

@section('title', 'Edit Inventory - NexStack')
@section('page-title', 'INVENTORY')

@section('content')
<div class="form-container">
    <div class="card">
        <div class="card-header">
            <h5>Edit Inventory</h5>
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
                    <label for="quantity_in" class="form-label">Quantity In</label>
                    <input type="number" class="form-control" id="quantity_in" name="quantity_in" value="{{ old('quantity_in', $inventory->quantity_in) }}" min="0">
                </div>
                <div class="mb-3">
                    <label for="quantity_out" class="form-label">Quantity Out</label>
                    <input type="number" class="form-control" id="quantity_out" name="quantity_out" value="{{ old('quantity_out', $inventory->quantity_out) }}" min="0">
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $inventory->date) }}" required>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $inventory->notes) }}</textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('inventory.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

