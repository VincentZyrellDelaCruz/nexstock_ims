@extends('layouts.app')

@section('title', 'Create Defect Report')
@section('page-title', 'CREATE DEFECT REPORT')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Submit Defect Report</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('defects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Product</label>
                <select name="product_id" class="form-select" required>
                    <option value="" disabled selected>Select product...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Quantity Affected</label>
                <input type="number" name="quantity_affected" class="form-control" min="0" required>
                @error('quantity_affected') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Proof Image (Optional)</label>
                <input type="file" name="proof_image" class="form-control" accept="image/*">
                @error('proof_image') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <input type="hidden" name="reported_by" value="{{ Auth::user()->id }}">

            <div class="d-flex justify-content-between">
                <a href="{{ route('defects.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Submit Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
