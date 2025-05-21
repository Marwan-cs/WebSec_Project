@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span class="h4 mb-0">{{ __('Sales Report') }}</span>
                </div>
                <div class="card-body">
                    <!-- Debug Information -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Debug Information</h5>
                                    <button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#debugInfo" aria-expanded="false" aria-controls="debugInfo">
                                        Show/Hide
                                    </button>
                                </div>
                                <div class="collapse" id="debugInfo">
                                    <div class="card-body">
                                        <h6>Monthly Sales Data:</h6>
                                        <pre>{{ json_encode($monthlySales ?? [], JSON_PRETTY_PRINT) }}</pre>
                                        
                                        <h6>Customer Sales Data:</h6>
                                        <pre>{{ json_encode($customerSales ?? [], JSON_PRETTY_PRINT) }}</pre>
                                        
                                        <h6>Status Counts Data:</h6>
                                        <pre>{{ json_encode($statusCounts ?? [], JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sales Analytics -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-primary text-white shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Total Sales</h5>
                                    <h2 class="card-text">${{ number_format($sales->sum('total_amount'), 2) }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Total Orders</h5>
                                    <h2 class="card-text">{{ $sales->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-info text-white shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Avg. Order Value</h5>
                                    <h2 class="card-text">${{ number_format($sales->count() > 0 ? $sales->sum('total_amount') / $sales->count() : 0, 2) }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Date Range Filter -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <form action="{{ route('reports.sales') }}" method="GET">
                                        <div class="row align-items-center">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="start_date">Start Date</label>
                                                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="end_date">End Date</label>
                                                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary me-2">Filter</button>
                                                <a href="{{ route('reports.sales') }}" class="btn btn-secondary">Reset</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sales Chart -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Monthly Sales Trend</h5>
                                </div>
                                <div class="card-body">
                                    <div id="monthlySalesContainer" style="position: relative; height: 300px; width: 100%;">
                                        <canvas id="salesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Top Customers by Sales</h5>
                                </div>
                                <div class="card-body">
                                    <div id="customerSalesContainer" style="position: relative; height: 300px; width: 100%;">
                                        <canvas id="customerSalesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0">Order Status Distribution</h5>
                                </div>
                                <div class="card-body">
                                    <div id="statusContainer" style="position: relative; height: 200px; width: 100%;">
                                        <canvas id="statusChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sales Data Table -->
                    @if(isset($sales) && count($sales))
                        <div class="card shadow-sm">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">Order Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>{{ __('Order ID') }}</th>
                                                <th>{{ __('Customer') }}</th>
                                                <th>{{ __('Total Amount') }}</th>
                                                <th>{{ __('Status') }}</th>
                                                <th>{{ __('Date') }}</th>
                                                <th>{{ __('Actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sales as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->user->name ?? 'N/A' }}</td>
                                                    <td>${{ number_format($order->total_amount, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : ($order->status === 'cancelled' ? 'danger' : 'info')) }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#orderDetail{{ $order->id }}">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">No sales data available.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Detail Modals -->
@foreach($sales as $order)
<div class="modal fade" id="orderDetail{{ $order->id }}" tabindex="-1" aria-labelledby="orderDetailLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="orderDetailLabel{{ $order->id }}">Order #{{ $order->id }} Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <p><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                        <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Order Information</h6>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    </div>
                </div>
                
                <h6 class="mt-4">Order Items</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($order->items && count($order->items))
                            @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'Unknown Product' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">No items available</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('head')
<!-- Make sure Chart.js is loaded in the head section -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure we have valid data by providing fallbacks
    let monthlyData = @json($monthlySales ?? []);
    let customerData = @json($customerSales ?? []);
    let statusData = @json($statusCounts ?? []);
    
    // If data is empty, provide sample data for demonstration
    if (!monthlyData || monthlyData.length === 0) {
        const today = new Date();
        monthlyData = [];
        for (let i = 6; i >= 0; i--) {
            const date = new Date(today);
            date.setMonth(today.getMonth() - i);
            monthlyData.push({
                month: date.toLocaleString('default', { month: 'short' }) + ' ' + date.getFullYear(),
                total: 0
            });
        }
    }
    
    if (!customerData || customerData.length === 0) {
        customerData = [
            {name: 'No Customer Data', total: 0}
        ];
    }
    
    if (!statusData || Object.keys(statusData).length === 0) {
        statusData = {
            'pending': 0,
            'processing': 0,
            'completed': 0,
            'cancelled': 0
        };
    }
    
    console.log('Monthly data:', monthlyData);
    console.log('Customer data:', customerData);
    console.log('Status data:', statusData);
    
    // Check if canvas elements exist
    const salesChartElement = document.getElementById('salesChart');
    const customerSalesChartElement = document.getElementById('customerSalesChart');
    const statusChartElement = document.getElementById('statusChart');
    
    if (!salesChartElement) {
        console.error('Sales chart canvas element not found!');
        return;
    }
    
    if (!customerSalesChartElement) {
        console.error('Customer sales chart canvas element not found!');
        return;
    }
    
    if (!statusChartElement) {
        console.error('Status chart canvas element not found!');
        return;
    }
    
    try {
        // Monthly Sales Chart
        const monthlySalesCtx = salesChartElement.getContext('2d');
        const gradient = monthlySalesCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(54, 162, 235, 0.6)');
        gradient.addColorStop(1, 'rgba(54, 162, 235, 0.1)');
        
        new Chart(monthlySalesCtx, {
            type: 'line',
            data: {
                labels: monthlyData.map(item => item.month),
                datasets: [{
                    label: 'Monthly Sales ($)',
                    data: monthlyData.map(item => item.total),
                    backgroundColor: gradient,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
        
        // Customer Sales Chart
        const customerSalesCtx = customerSalesChartElement.getContext('2d');
        const customerColors = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)',
            'rgba(255, 159, 64, 0.7)',
            'rgba(199, 199, 199, 0.7)',
            'rgba(83, 102, 255, 0.7)',
            'rgba(40, 159, 64, 0.7)',
            'rgba(210, 199, 199, 0.7)'
        ];
        
        new Chart(customerSalesCtx, {
            type: 'bar',
            data: {
                labels: customerData.map(item => item.name),
                datasets: [{
                    label: 'Total Sales ($)',
                    data: customerData.map(item => item.total),
                    backgroundColor: customerColors.slice(0, customerData.length),
                    borderColor: customerColors.slice(0, customerData.length).map(color => color.replace('0.7', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        });
        
        // Status Chart
        const statusCtx = statusChartElement.getContext('2d');
        const statusLabels = Object.keys(statusData).map(key => key.charAt(0).toUpperCase() + key.slice(1));
        const statusValues = Object.values(statusData);
        
        const statusColors = [
            'rgba(255, 205, 86, 0.8)', // pending - yellow
            'rgba(54, 162, 235, 0.8)', // processing - blue
            'rgba(75, 192, 192, 0.8)', // completed - green
            'rgba(255, 99, 132, 0.8)'  // cancelled - red
        ];
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: statusColors.slice(0, statusLabels.length),
                    borderColor: statusColors.slice(0, statusLabels.length).map(color => color.replace('0.8', '1')),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    } catch (error) {
        console.error('Error initializing charts:', error);
        document.getElementById('monthlySalesContainer').innerHTML = '<div class="alert alert-danger">Error initializing chart: ' + error.message + '</div>';
    }
});
</script>
@endpush