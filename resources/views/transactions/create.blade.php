@extends('layouts.app')

@section('title', 'Add Transaction - NexStack')
@section('page-title', 'TRANSACTIONS')

@section('content')
<div class="form-container">
    <div class="card">
        <div class="card-header">
            <h5>Add Transaction</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="product_id" class="form-label">Product</label>
                    <select class="form-select" id="product_id" name="product_id" required>
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Transaction Type</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="">Select type</option>
                        <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>In</option>
                        <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Out</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('date') }}" required>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('transactions.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

