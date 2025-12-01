@extends('layouts.app')

@section('title', 'Add Category - NexStack')
@section('page-title', 'CATEGORIES')

@section('content')
<div class="form-container">
    <div class="card">
        <div class="card-header">
            <h5>Add Category</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

