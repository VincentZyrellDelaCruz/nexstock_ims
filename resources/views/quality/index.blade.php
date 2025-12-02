@extends('layouts.app')

@section('title', 'Quality Control - NexStack')
@section('page-title', 'QUALITY CONTROL')

@section('content')
<div class="mb-3">
    <a href="{{ route('defects.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Create Defect Report
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5>Defect Submissions</h5>
        @include('components._table_search', ['placeholder' => 'Search products...'])
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Product Name</th>
                    <th>Quantity Affected</th>
                    <th>Reported By</th>
                    <th>Status</th>
                    <th>Report Date</th>
                    @if (Auth::check() && Auth::user()->role === 'admin') <th>Actions</th> @endif
                </tr>
            </thead>
            <tbody>
                @forelse($defects as $defect)
                <tr>
                    <td>{{ $defect->id }}</td>
                    <td>{{ $defect->product->name ?? 'N/A' }}</td>
                    <td>{{ $defect->quantity_affected }}</td>
                    <td>{{ $defect->reported_by }}</td>
                    <td><span class="badge bg-{{ $defect->status == 'pending' ? 'secondary' : 'success' }}">{{ ucfirst($defect->status) }}</span></td>
                    <td>{{ $defect->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No submission found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

