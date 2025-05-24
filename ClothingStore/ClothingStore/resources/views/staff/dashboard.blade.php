@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Staff Dashboard</h2>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Quick Stats -->
                        <div class="col-md-4 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Orders</h5>
                                    <h2 class="card-text">{{ \App\Models\Order::where('status', 'pending')->count() }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Completed Orders</h5>
                                    <h2 class="card-text">{{ \App\Models\Order::where('status', 'completed')->count() }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Customers</h5>
                                    <h2 class="card-text">{{ \App\Models\User::whereHas('roles', function($q) { $q->whereIn('slug', ['customer']); })->count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h3>Quick Actions</h3>
                            <div class="list-group">
                                <a href="{{ route('staff.orders.index') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-shopping-cart"></i> Manage Orders
                                </a>
                                <a href="{{ route('staff.customers.index') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-users"></i> View Customers
                                </a>
                                <a href="{{ route('staff.inventory') }}" class="list-group-item list-group-item-action">
                                    <i class="fas fa-boxes"></i> Check Inventory
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h3>Recent Orders</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Customer</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(\App\Models\Order::with('user')->latest()->take(5)->get() as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('staff.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .list-group-item {
        transition: background-color 0.2s;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush 