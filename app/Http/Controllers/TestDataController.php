<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestDataController extends Controller
{
    public function index()
    {
        // Get table counts
        $userCount = DB::table('users')->count();
        $productCount = DB::table('products')->count();
        $orderCount = DB::table('orders')->count();
        $orderItemCount = DB::table('order_items')->count();
        
        // Check if DATE_FORMAT works in your MySQL version
        try {
            $testDate = DB::select("SELECT DATE_FORMAT(NOW(), '%Y-%m') as formatted_date");
            $dateFormatWorks = !empty($testDate);
        } catch (\Exception $e) {
            $dateFormatWorks = false;
        }
        
        // Get sample data that would be used for charts
        $monthlySales = $this->getMonthlySalesData();
        $customerSales = $this->getCustomerSalesData();
        $statusCounts = $this->getStatusData();
        
        return response()->json([
            'database_info' => [
                'users' => $userCount,
                'products' => $productCount,
                'orders' => $orderCount,
                'order_items' => $orderItemCount,
                'date_format_works' => $dateFormatWorks
            ],
            'chart_data' => [
                'monthly_sales' => $monthlySales,
                'customer_sales' => $customerSales,
                'status_counts' => $statusCounts
            ]
        ]);
    }
    
    public function generateData()
    {
        // Check if we already have data
        if (Order::count() > 0) {
            return response()->json(['message' => 'Data already exists, skipping generation']);
        }
        
        // Create users if needed
        if (User::count() < 5) {
            for ($i = 1; $i <= 5; $i++) {
                User::create([
                    'name' => "Test User {$i}",
                    'email' => "test{$i}@example.com",
                    'password' => bcrypt('password'),
                    'email_verified_at' => now()
                ]);
            }
        }
        
        // Create products if needed
        if (Product::count() < 5) {
            $products = [
                ['name' => 'Smartphone', 'price' => 999.99, 'stock' => 50],
                ['name' => 'Laptop', 'price' => 1299.99, 'stock' => 25],
                ['name' => 'Headphones', 'price' => 199.99, 'stock' => 100],
                ['name' => 'Tablet', 'price' => 499.99, 'stock' => 30],
                ['name' => 'Smartwatch', 'price' => 299.99, 'stock' => 45]
            ];
            
            foreach ($products as $product) {
                Product::create([
                    'name' => $product['name'],
                    'description' => "This is a {$product['name']}",
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'image' => 'products/default.jpg'
                ]);
            }
        }
        
        // Get IDs for reference
        $userIds = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();
        
        // Create orders with different statuses and dates
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        
        for ($i = 1; $i <= 20; $i++) {
            // Create orders spread across the last 6 months
            $date = Carbon::now()->subDays(rand(1, 180))->format('Y-m-d H:i:s');
            $status = $statuses[array_rand($statuses)];
            $userId = $userIds[array_rand($userIds)];
            
            // Random total between $50 and $5000
            $total = rand(5000, 500000) / 100;
            
            $order = Order::create([
                'user_id' => $userId,
                'status' => $status,
                'total_amount' => $total,
                'created_at' => $date,
                'updated_at' => $date
            ]);
            
            // Add order items
            $itemCount = rand(1, 3);
            $itemTotal = 0;
            
            for ($j = 0; $j < $itemCount; $j++) {
                $productId = $productIds[array_rand($productIds)];
                $product = Product::find($productId);
                
                $quantity = rand(1, 5);
                $price = $product->price;
                
                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => $date,
                    'updated_at' => $date
                ]);
                
                $itemTotal += $price * $quantity;
            }
            
            // Update order with correct total from items
            $order->update([
                'total_amount' => $itemTotal
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Test data generated successfully',
            'counts' => [
                'users' => User::count(),
                'products' => Product::count(),
                'orders' => Order::count(),
                'order_items' => DB::table('order_items')->count()
            ]
        ]);
    }
    
    private function getMonthlySalesData()
    {
        try {
            $data = DB::table('orders')
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
                            'total' => (float)$item->total,
                            'error' => $e->getMessage()
                        ];
                    }
                })
                ->toArray();
            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    private function getCustomerSalesData()
    {
        try {
            $data = DB::table('orders')
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
                })
                ->toArray();
            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    private function getStatusData()
    {
        try {
            $data = [
                'pending' => Order::where('status', 'pending')->count(),
                'processing' => Order::where('status', 'processing')->count(),
                'completed' => Order::where('status', 'completed')->count(),
                'cancelled' => Order::where('status', 'cancelled')->count()
            ];
            return $data;
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
} 