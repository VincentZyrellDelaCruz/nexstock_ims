@extends('layouts.app')

@section('title', 'Defect Report Details')
@section('page-title', 'DEFECT REPORT DETAILS')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Defect Report #{{ $defect->id }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Product:</strong> {{ $defect->product->name ?? 'N/A' }}</p>
        <p><strong>Quantity Affected:</strong> {{ $defect->quantity_affected }}</p>
        <p><strong>Description:</strong> {{ $defect->description }}</p>
        <p><strong>Reported By:</strong> {{ $defect->reporter->name ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($defect->status) }}</p>
        <p><strong>Created At:</strong> {{ $defect->created_at->format('M d, Y H:i') }}</p>

        @if($defect->proof_image)
    <p><strong>Proof Image:</strong></p>
    <img src="{{ asset('storage/' . $defect->proof_image) }}" alt="Proof Image" class="img-fluid mb-3">
@endif

<div class="mt-3">
    <a href="{{ route('defects.index') }}" class="btn btn-secondary d-block">Back to List</a>
</div>

</div>
@endsection
