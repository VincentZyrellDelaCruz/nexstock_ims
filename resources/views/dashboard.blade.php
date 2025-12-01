@extends('layouts.app')

@section('title', 'Dashboard - NexStack')
@section('page-title', 'DASHBOARD')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <p>Total Products</p>
            <h3>{{ $totalProducts ?? 0 }}</h3>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <p>Total Revenue</p>
            <h3>${{ number_format($totalRevenue ?? 0, 2) }}</h3>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <p>New Orders</p>
            <h3>{{ $newOrders ?? 0 }}</h3>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="kpi-card">
            <p>Pending Orders</p>
            <h3>{{ $pendingOrders ?? 0 }}</h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Top Selling Products</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts ?? [] as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td><span class="badge bg-success">{{ $product->status }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No products yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Recent Orders</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td>{{ $order->product->name ?? 'N/A' }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>{{ ucfirst($order->type) }}</td>
                            <td>{{ $order->date }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No recent orders</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

