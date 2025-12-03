@extends('layouts.app')

@section('title', 'Warehouses - NexStack')
@section('page-title', 'WAREHOUSES')

@section('content')
@if (Auth::check() && Auth::user()->role === 'admin')
    <div class="mb-3">
        <a href="{{ route('warehouses.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add Warehouse
        </a>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Warehouse List</h5>
        @include('components._table_search', ['placeholder' => 'Search warehouses...'])
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Warehouse ID</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Status</th>
                    @if (Auth::check() && Auth::user()->role === 'admin') <th>Actions</th> @endif
                </tr>
            </thead>
            <tbody>
                @forelse($warehouses as $warehouse)
                <tr>
                    <td>{{ $warehouse->id }}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->location }}</td>
                    <td>
                        <span class="badge bg-{{ $warehouse->status === 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($warehouse->status) }}
                        </span>
                    </td>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <td>
                            <a href="{{ route('warehouses.edit', $warehouse->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('warehouses.destroy', $warehouse->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this warehouse?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        No warehouses found.
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('warehouses.create') }}"> Add one now</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection


