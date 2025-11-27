@extends('layouts.app')

@section('title', 'Add Supplier - NexStack')
@section('page-title', 'SUPPLIERS')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Add Supplier</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="company_name" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ old('company_name') }}" required>
            </div>
            <div class="mb-3">
                <label for="contact_person" class="form-label">Contact Person</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" value="{{ old('contact_person') }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
@endsection

