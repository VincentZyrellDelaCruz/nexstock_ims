@extends('layouts.app')

@section('title', 'Edit Supplier - NexStack')
@section('page-title', 'SUPPLIERS')

@section('content')
<div class="form-container">
    <div class="card">
        <div class="card-header">
            <h5>Edit Supplier</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Supplier Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $supplier->email) }}" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city', $supplier->city) }}">
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country', $supplier->country) }}">
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

