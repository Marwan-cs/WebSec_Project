@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Inventory Report') }}</span>
                </div>
                <div class="card-body">
                    <!-- Summary Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Products</h5>
                                    <h2 class="card-text">{{ count($products) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Stock</h5>
                                    <h2 class="card-text">{{ $products->sum('stock') }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Low Stock Items</h5>
                                    <h2 class="card-text">{{ $products->where('stock', '<', 10)->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Out of Stock</h5>
                                    <h2 class="card-text">{{ $products->where('stock', '<=', 0)->count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">Filter Inventory</div>
                                <div class="card-body">
                                    <form action="{{ route('reports.inventory') }}" method="GET" class="row g-3">
                                        <div class="col-md-4">
                                            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                                        </div>
                                        <div class="col-md-3">
                                            <select name="category" class="form-select">
                                                <option value="">All Categories</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                                        {{ ucfirst($category) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="stock_status" class="form-select">
                                                <option value="">All Stock Levels</option>
                                                <option value="out" {{ request('stock_status') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                                                <option value="low" {{ request('stock_status') == 'low' ? 'selected' : '' }}>Low Stock</option>
                                                <option value="normal" {{ request('stock_status') == 'normal' ? 'selected' : '' }}>Normal Stock</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inventory Charts -->
                    <div class="row mb-4">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">Stock Level by Category</div>
                                <div class="card-body">
                                    <canvas id="categoryStockChart" height="280"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-header">Stock Status Distribution</div>
                                <div class="card-body">
                                    <canvas id="stockStatusChart" height="280"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Top Products Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Top 5 High-Value Products</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Stock Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products->sortByDesc(function($product) { return $product->price * $product->stock; })->take(5) as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>${{ number_format($product->price, 2) }}</td>
                                                    <td>${{ number_format($product->price * $product->stock, 2) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Products Needing Restock</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Current Stock</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products->where('stock', '<', 10)->take(5) as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>
                                                        @if($product->stock <= 0)
                                                            <span class="badge bg-danger">Out of Stock</span>
                                                        @elseif($product->stock < 5)
                                                            <span class="badge bg-warning">Critical</span>
                                                        @else
                                                            <span class="badge bg-info">Low</span>
                                                        @endif
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
                    
                    <!-- Inventory Table -->
                    @if(isset($products) && count($products))
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Stock') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Stock Value') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr class="{{ $product->stock < 5 ? 'table-danger' : ($product->stock < 10 ? 'table-warning' : '') }}">
                                            <td>{{ $product->name }}</td>
                                            <td>Electronics</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    @php 
                                                        $percentage = min(100, ($product->stock / 30) * 100); 
                                                        $barClass = $product->stock <= 0 ? 'bg-danger' : ($product->stock < 5 ? 'bg-warning' : ($product->stock < 10 ? 'bg-info' : 'bg-success'));
                                                    @endphp
                                                    <div class="progress-bar {{ $barClass }}" role="progressbar" 
                                                        style="width: {{ $percentage }}%;" 
                                                        aria-valuenow="{{ $product->stock }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="30">{{ $product->stock }}</div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>${{ number_format($product->price * $product->stock, 2) }}</td>
                                            <td>
                                                @if($product->stock <= 0)
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                @elseif($product->stock < 5)
                                                    <span class="badge bg-warning">Critical</span>
                                                @elseif($product->stock < 10)
                                                    <span class="badge bg-info">Low</span>
                                                @else
                                                    <span class="badge bg-success">In Stock</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No inventory data available.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stock by Category Chart
    const categoryCtx = document.getElementById('categoryStockChart').getContext('2d');
    const categoryData = @json($categoryData ?? []);
    
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                label: 'Total Stock',
                data: Object.values(categoryData).map(item => item.stock),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Total Value ($)',
                data: Object.values(categoryData).map(item => item.value),
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Stock Quantity'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Stock Value ($)'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Category'
                    }
                }
            }
        }
    });
    
    // Stock Status Chart
    const statusCtx = document.getElementById('stockStatusChart').getContext('2d');
    const stockStatus = @json($stockStatus ?? []);
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Out of Stock', 'Critical', 'Low', 'Normal'],
            datasets: [{
                data: [
                    stockStatus.outOfStock ?? 0,
                    stockStatus.critical ?? 0,
                    stockStatus.low ?? 0,
                    stockStatus.normal ?? 0
                ],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',  // red - out of stock
                    'rgba(255, 159, 64, 0.8)',  // orange - critical
                    'rgba(255, 205, 86, 0.8)',  // yellow - low
                    'rgba(75, 192, 192, 0.8)'   // green - normal
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
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
});
</script>
@endpush