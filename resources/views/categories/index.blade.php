@extends('layouts.app')

@section('title', 'Categories - NexStack')
@section('page-title', 'CATEGORY')

@section('content')
@if (Auth::user()->role === 'admin')
    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add Category
        </a>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Categories List</h5>
        @include('components._table_search', ['placeholder' => 'Search categories...'])
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description ?? 'N/A' }}</td>
                    @if (Auth::user()->role === 'admin')
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No categories found. @if (Auth::user()->role === 'admin') <a href="{{ route('categories.create') }}">Add one now</a> @endif </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

