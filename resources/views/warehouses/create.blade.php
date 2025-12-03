@extends('layouts.app')

@section('title', 'Add Warehouse - NexStack')
@section('page-title', 'ADD WAREHOUSE')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Create Warehouse</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('warehouses.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Warehouse Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection


