@extends('layouts.app')

@section('title', 'Suppliers - NexStack')
@section('page-title', 'SUPPLIERS')

@section('content')
@if (Auth::user()->role === 'admin')
    <div class="mb-3">
        <a href="{{ route('suppliers.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add Supplier
        </a>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5>Suppliers List</h5>
            @include('components._table_search', ['placeholder' => 'Search suppliers...'])
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Company Name</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Phone</th>
                    @if (Auth::check() && Auth::user()->role === 'admin') <th>Actions</th> @endif
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->id }}</td>
                    <td>{{ $supplier->company_name }}</td>
                    <td>{{ $supplier->contact_person }}</td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->phone }}</td>
                    @if (Auth::check() && Auth::user()->role === 'admin')
                        <td>
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-success btn-sm">Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No suppliers found. @if (Auth::user()->role === 'admin') <a href="{{ route('suppliers.create') }}">Add one now</a> @endif </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

