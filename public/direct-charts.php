<?php
// Load the Laravel application
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

try {
    // Generate monthly sales data - manual approach
    $monthly = [];
    $sixMonthsAgo = Carbon::now()->subMonths(6)->startOfMonth();
    $ordersForChart = Order::where('created_at', '>=', $sixMonthsAgo)
        ->get();
    
    // Group by month and calculate totals
    $ordersByMonth = [];
    foreach ($ordersForChart as $order) {
        $monthKey = $order->created_at->format('Y-m');
        $monthDisplay = $order->created_at->format('M Y');
        
        if (!isset($ordersByMonth[$monthKey])) {
            $ordersByMonth[$monthKey] = [
                'month' => $monthDisplay,
                'total' => 0
            ];
        }
        
        $ordersByMonth[$monthKey]['total'] += $order->total_amount;
    }
    
    // Sort by month
    ksort($ordersByMonth);
    
    // Convert to indexed array
    $monthly = array_values($ordersByMonth);
    
    // Generate customer sales data - manual approach
    $customers = [];
    $userTotals = [];
    
    foreach ($ordersForChart as $order) {
        $userId = $order->user_id;
        $userName = $order->user->name ?? 'Unknown User';
        
        if (!isset($userTotals[$userId])) {
            $userTotals[$userId] = [
                'name' => $userName,
                'total' => 0
            ];
        }
        
        $userTotals[$userId]['total'] += $order->total_amount;
    }
    
    // Sort by total sales (descending)
    usort($userTotals, function($a, $b) {
        return $b['total'] <=> $a['total'];
    });
    
    // Get top 10 customers
    $customers = array_slice(array_values($userTotals), 0, 10);
    
    // Get order status counts
    $statusCounts = [
        'pending' => Order::where('status', 'pending')->count(),
        'processing' => Order::where('status', 'processing')->count(),
        'completed' => Order::where('status', 'completed')->count(),
        'cancelled' => Order::where('status', 'cancelled')->count()
    ];
    
    // If no data, create sample data
    if (empty($monthly)) {
        $monthly = [
            ['month' => 'Jan 2023', 'total' => 12500],
            ['month' => 'Feb 2023', 'total' => 17800],
            ['month' => 'Mar 2023', 'total' => 14200],
            ['month' => 'Apr 2023', 'total' => 22000],
            ['month' => 'May 2023', 'total' => 25000]
        ];
    }
    
    if (empty($customers)) {
        $customers = [
            ['name' => 'Customer User', 'total' => 45050],
            ['name' => 'John Doe', 'total' => 23500],
            ['name' => 'Jane Smith', 'total' => 18700],
            ['name' => 'Robert Johnson', 'total' => 12400],
            ['name' => 'Lisa Brown', 'total' => 8900]
        ];
    }
    
    // Convert data to JSON for JavaScript
    $monthlyDataJson = json_encode($monthly);
    $customerDataJson = json_encode($customers);
    $statusDataJson = json_encode($statusCounts);
    
    // Output HTML with embedded charts
    header('Content-Type: text/html');
} catch (Exception $e) {
    $error = $e->getMessage();
    $trace = $e->getTraceAsString();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Chart Test</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Direct Chart Test</h1>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Monthly Sales Trend</h5>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Top Customers by Sales</h5>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="customerSalesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Order Status Distribution</h5>
                    </div>
                    <div class="card-body">
                        <div style="position: relative; height: 300px; width: 100%;">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hard-coded sample data
        const monthlyData = [
            {month: 'Jan 2023', total: 1200},
            {month: 'Feb 2023', total: 1800},
            {month: 'Mar 2023', total: 2400},
            {month: 'Apr 2023', total: 2000},
            {month: 'May 2023', total: 2600},
            {month: 'Jun 2023', total: 3200}
        ];
        
        const customerData = [
            {name: 'John Doe', total: 3200},
            {name: 'Jane Smith', total: 2800},
            {name: 'Bob Johnson', total: 2200},
            {name: 'Alice Brown', total: 1800},
            {name: 'Charlie Wilson', total: 1500}
        ];
        
        const statusData = {
            'pending': 15,
            'processing': 8,
            'completed': 45,
            'cancelled': 5
        };
        
        console.log('Monthly data:', monthlyData);
        console.log('Customer data:', customerData);
        console.log('Status data:', statusData);
        
        // Monthly Sales Chart
        const monthlySalesCtx = document.getElementById('salesChart').getContext('2d');
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
        const customerSalesCtx = document.getElementById('customerSalesChart').getContext('2d');
        const customerColors = [
            'rgba(255, 99, 132, 0.7)',
            'rgba(54, 162, 235, 0.7)',
            'rgba(255, 206, 86, 0.7)',
            'rgba(75, 192, 192, 0.7)',
            'rgba(153, 102, 255, 0.7)'
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
        const statusCtx = document.getElementById('statusChart').getContext('2d');
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
    });
    </script>
</body>
</html> 