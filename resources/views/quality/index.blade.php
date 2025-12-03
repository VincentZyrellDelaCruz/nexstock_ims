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

        @include('quality.tablesearch', ['placeholder' => 'Search products...'])
    </div>

    <div class="card-body">
        <table class="table table-hover">

            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Product Name</th>
                    <th>Quantity Affected</th>
                    <th>Reported By</th>
                    <th>Status</th>
                    <th>Report Date</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $statusColors = [
                        'pending' => 'secondary',
                        'approved' => 'success',
                        'rejected' => 'danger'
                    ];
                @endphp

                @forelse($defects as $defect)
                <tr onclick="window.location='{{ route('defects.show', $defect->id) }}'" style="cursor:pointer;">
                    <td>{{ $defect->id }}</td>
                    <td>{{ $defect->product->name ?? 'N/A' }}</td>
                    <td>{{ $defect->quantity_affected }}</td>
                    <td>{{ $defect->reporter->name ?? 'N/A' }}</td>
                    <td>
                        <span class="badge bg-{{ $statusColors[$defect->status] ?? 'secondary' }}">
                            {{ ucfirst($defect->status) }}
                        </span>
                    </td>

                    <td>{{ $defect->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No submission found.</td>

                    <td colspan="7" class="text-center">No submission found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

