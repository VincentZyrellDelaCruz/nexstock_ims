@extends('layouts.app')

@section('title', 'Reports - NexStack')
@section('page-title', 'REPORTS')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Sales Report</h5>
            </div>
            <div class="card-body">
                <p>View detailed sales reports and analytics.</p>
                <a href="{{ route('reports.sales') }}" class="btn btn-success">View Sales Report</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Inventory Report</h5>
            </div>
            <div class="card-body">
                <p>View current inventory status and levels.</p>
                <a href="{{ route('reports.inventory') }}" class="btn btn-success">View Inventory Report</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Supplier Report</h5>
            </div>
            <div class="card-body">
                <p>View supplier information and statistics.</p>
                <a href="{{ route('reports.supplier') }}" class="btn btn-success">View Supplier Report</a>
            </div>
        </div>
    </div>
</div>
@endsection

