@extends('layouts.app')

@section('title', 'Supplier Report - NexStack')
@section('page-title', 'REPORTS')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Supplier Report</h5>
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
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No suppliers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<a href="{{ route('reports.index') }}" class="btn btn-success">Back to Reports</a>
@endsection

