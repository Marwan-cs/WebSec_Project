<?php
// Set headers to prevent caching
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-Type: application/json');

// Load the Laravel application
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

echo "<h1>Chart Data Debug</h1>";

try {
    // Get some basic database stats
    $stats = [
        'users' => \App\Models\User::count(),
        'products' => \App\Models\Product::count(),
        'orders' => \App\Models\Order::count(),
    ];
    
    // Try to get orders data directly
    $orders = Order::orderBy('created_at', 'desc')->limit(5)->get();
    $orderData = [];
    
    foreach ($orders as $order) {
        $orderData[] = [
            'id' => $order->id,
            'user' => $order->user->name ?? 'Unknown',
            'total' => $order->total_amount,
            'status' => $order->status,
            'date' => $order->created_at->format('Y-m-d H:i:s')
        ];
    }
    
    // Generate monthly sales data
    try {
        $monthlySales = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                try {
                    $date = Carbon::createFromFormat('Y-m', $item->month);
                    return [
                        'month' => $date->format('M Y'),
                        'total' => (float)$item->total
                    ];
                } catch (\Exception $e) {
                    return [
                        'month' => $item->month,
                        'total' => (float)$item->total
                    ];
                }
            })->toArray();
        
        echo "<h2>Monthly Sales Data:</h2>";
        echo "<pre>";
        print_r($monthlySales);
        echo "</pre>";
    } catch (\Exception $e) {
        echo "<h2>Error in Monthly Sales Data:</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
    
    // Generate customer sales data
    try {
        $customerSales = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('SUM(orders.total_amount) as total'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->map(function($item) {
                return [
                    'name' => $item->name,
                    'total' => (float)$item->total
                ];
            })->toArray();
        
        echo "<h2>Customer Sales Data:</h2>";
        echo "<pre>";
        print_r($customerSales);
        echo "</pre>";
    } catch (\Exception $e) {
        echo "<h2>Error in Customer Sales Data:</h2>";
        echo "<p>" . $e->getMessage() . "</p>";
    }
    
    // Get order status counts
    $statusCounts = [
        'pending' => Order::where('status', 'pending')->count(),
        'processing' => Order::where('status', 'processing')->count(),
        'completed' => Order::where('status', 'completed')->count(),
        'cancelled' => Order::where('status', 'cancelled')->count()
    ];
    
    echo "<h2>Status Counts Data:</h2>";
    echo "<pre>";
    print_r($statusCounts);
    echo "</pre>";
    
    // Output everything as JSON
    echo json_encode([
        'stats' => $stats,
        'recent_orders' => $orderData,
        'chart_data' => [
            'monthly_sales' => $monthlySales,
            'customer_sales' => $customerSales,
            'status_counts' => $statusCounts
        ]
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
} 