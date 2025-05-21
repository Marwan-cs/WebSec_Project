@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Manager Dashboard</h2>
                </div>

                <div class="card-body">
                    <!-- Welcome Message with Current Time -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h4>Welcome, {{ auth()->user()->name }}!</h4>
                                <p>{{ now()->format('l, F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Stats Cards -->
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body d-flex">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title">Products</h5>
                                        <h2 class="card-text">{{ \App\Models\Product::count() }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-box fa-3x"></i>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 text-end">
                                    <a href="{{ route('products.index') }}" class="text-white">View Details <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body d-flex">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title">Total Orders</h5>
                                        <h2 class="card-text">{{ \App\Models\Order::count() }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-shopping-cart fa-3x"></i>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 text-end">
                                    <a href="{{ route('reports.sales') }}" class="text-white">View Details <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-4">
                            <div class="card bg-info text-white">
                                <div class="card-body d-flex">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title">Staff Members</h5>
                                        <h2 class="card-text">{{ \App\Models\User::whereHas('roles', function($q) { $q->whereIn('slug', ['staff']); })->count() }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-users fa-3x"></i>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 text-end">
                                    <a href="{{ route('staff.index') }}" class="text-white">View Details <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body d-flex">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title">Low Stock Items</h5>
                                        <h2 class="card-text">{{ \App\Models\Product::where('stock', '<', 10)->count() }}</h2>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="fas fa-exclamation-triangle fa-3x"></i>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 text-end">
                                    <a href="{{ route('reports.inventory') }}" class="text-white">View Details <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sales Overview Chart -->
                    <div class="row mt-4 mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <span>Sales Overview</span>
                                    <div>
                                        <select class="form-select form-select-sm" id="salesPeriodSelect">
                                            <option value="7">Last 7 Days</option>
                                            <option value="30" selected>Last 30 Days</option>
                                            <option value="90">Last 3 Months</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="salesChart" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">Stock Status</div>
                                <div class="card-body">
                                    <canvas id="stockChart" height="260"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h3>Quick Actions</h3>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('products.index') }}" class="card text-decoration-none">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-box fa-3x text-primary"></i>
                                            </div>
                                            <h5 class="card-title">Manage Products</h5>
                                            <p class="card-text text-muted">Add, edit, delete products and manage inventory</p>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('staff.index') }}" class="card text-decoration-none">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-users fa-3x text-info"></i>
                                            </div>
                                            <h5 class="card-title">Manage Staff</h5>
                                            <p class="card-text text-muted">Add new staff members and manage permissions</p>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('reports.sales') }}" class="card text-decoration-none">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-chart-line fa-3x text-success"></i>
                                            </div>
                                            <h5 class="card-title">Sales Reports</h5>
                                            <p class="card-text text-muted">View detailed sales data and analytics</p>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('reports.inventory') }}" class="card text-decoration-none">
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <i class="fas fa-warehouse fa-3x text-warning"></i>
                                            </div>
                                            <h5 class="card-title">Inventory Reports</h5>
                                            <p class="card-text text-muted">Monitor stock levels and product statistics</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Recent Orders</h5>
                                    <a href="{{ route('reports.sales') }}" class="btn btn-sm btn-primary">View All</a>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
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
                                                        <a href="#" class="btn btn-sm btn-primary">View</a>
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
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
        border-radius: 10px;
        overflow: hidden;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .list-group-item {
        transition: background-color 0.2s;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .bg-primary, .bg-success, .bg-info, .bg-warning {
        position: relative;
        overflow: hidden;
    }
    .bg-primary::before, .bg-success::before, .bg-info::before, .bg-warning::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
        z-index: 1;
    }
    .card-body {
        position: relative;
        z-index: 2;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales data
    const ctx = document.getElementById('salesChart').getContext('2d');
    
    // Real data from the controller
    const salesData = {
        labels: @json($salesData->pluck('date')),
        datasets: [{
            label: 'Sales Amount ($)',
            data: @json($salesData->pluck('total_amount')),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2,
            tension: 0.4
        }, {
            label: 'Number of Orders',
            data: @json($salesData->pluck('order_count')),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            tension: 0.4,
            yAxisID: 'y1'
        }]
    };
    
    new Chart(ctx, {
        type: 'line',
        data: salesData,
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Sales Amount ($)'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Number of Orders'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            }
        }
    });
    
    // Stock status chart
    const stockCtx = document.getElementById('stockChart').getContext('2d');
    
    // Real data from the controller
    const stockData = {
        labels: ['Normal Stock', 'Low Stock', 'Out of Stock'],
        datasets: [{
            data: [{{ \App\Models\Product::where('stock', '>=', 10)->count() }}, 
                   {{ \App\Models\Product::where('stock', '<', 10)->where('stock', '>', 0)->count() }}, 
                   {{ \App\Models\Product::where('stock', '<=', 0)->count() }}],
            backgroundColor: [
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 205, 86, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 205, 86, 1)',
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    };
    
    new Chart(stockCtx, {
        type: 'doughnut',
        data: stockData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
    
    // Sales period select handler
    document.getElementById('salesPeriodSelect').addEventListener('change', function() {
        const days = this.value;
        
        // Fetch new data based on the selected period
        fetch(`/manager/dashboard/sales-data?days=${days}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update chart with new data
            const salesChart = Chart.getChart(ctx);
            
            if (salesChart) {
                salesChart.data.labels = data.data.map(item => item.date);
                salesChart.data.datasets[0].data = data.data.map(item => item.total_amount);
                salesChart.data.datasets[1].data = data.data.map(item => item.order_count);
                salesChart.update();
            }
        })
        .catch(error => {
            console.error('Error fetching sales data:', error);
        });
    });
});
</script>
@endpush 