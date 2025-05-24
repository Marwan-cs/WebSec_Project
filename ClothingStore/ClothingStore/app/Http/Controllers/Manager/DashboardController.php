<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get sales data for the past 7 days
        $salesData = $this->getSalesData(7);
        
        // Get order status distribution
        $orderStatusData = $this->getOrderStatusData();
        
        // Get top selling products
        $topProducts = $this->getTopSellingProducts(5);
        
        // Get low stock products
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
        
        return view('manager.dashboard', compact(
            'salesData', 
            'orderStatusData', 
            'topProducts', 
            'lowStockProducts'
        ));
    }
    
    private function getSalesData($days = 7)
    {
        $startDate = Carbon::now()->subDays($days)->startOfDay();
        
        $salesData = Order::where('created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total_amount'),
                DB::raw('COUNT(*) as order_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // If no data, create sample data for the last $days
        if ($salesData->isEmpty()) {
            $sampleData = [];
            $today = Carbon::now();
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = $today->copy()->subDays($i);
                $sampleData[] = [
                    'date' => $date->format('Y-m-d'),
                    'total_amount' => 0,
                    'order_count' => 0
                ];
            }
            $salesData = collect($sampleData);
        }
        
        return $salesData;
    }
    
    private function getOrderStatusData()
    {
        $statusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count()
        ];
        
        return $statusCounts;
    }
    
    private function getTopSellingProducts($limit = 5)
    {
        // This query assumes you have OrderItem model with product_id and quantity
        // If your database structure is different, adjust accordingly
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->take($limit)
            ->get();
    }
    
    public function getSalesDataForPeriod(Request $request)
    {
        $days = $request->days ?? 30;
        $salesData = $this->getSalesData($days);
        
        // Format the dates for better display
        $salesData = $salesData->map(function($item) {
            $item->date = Carbon::parse($item->date)->format('M d');
            return $item;
        });
        
        // Log the data for debugging
        Log::info('Dashboard sales data', ['data' => $salesData]);
        
        return response()->json(['data' => $salesData]);
    }
} 