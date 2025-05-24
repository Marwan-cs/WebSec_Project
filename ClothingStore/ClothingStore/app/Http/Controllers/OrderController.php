<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderConfirmation;
use App\Mail\OrderStatusUpdate;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function staffIndex()
    {
        $this->authorize('viewAny', Order::class);
        $orders = Order::with('user')->latest()->paginate(10);
        return view('staff.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        // Send status update email
        Mail::to($order->user->email)->send(new OrderStatusUpdate($order, $oldStatus, $validated['status']));

        // If order is shipped (status changed to processing), send shipping notification
        if ($oldStatus === 'pending' && $validated['status'] === 'processing') {
            Mail::to($order->user->email)->send(new OrderShipped($order));
        }

        return redirect()->route('staff.orders.index')
            ->with('success', 'Order status updated successfully.');
    }

    public function salesReport(Request $request)
    {
        $this->authorize('viewAny', Order::class);
        
        // Date filtering
        $query = Order::with('user', 'items.product');
        
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();
        
        // Generate monthly sales data for chart
        try {
            $monthlySalesCollection = DB::table('orders')
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total_amount) as total'))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
                
            // Convert to array with proper formatting
            $monthlySales = [];
            foreach ($monthlySalesCollection as $item) {
                try {
                    $date = Carbon::createFromFormat('Y-m', $item->month);
                    $monthlySales[] = [
                        'month' => $date->format('M Y'),
                        'total' => (float)$item->total
                    ];
                } catch (\Exception $e) {
                    $monthlySales[] = [
                        'month' => $item->month,
                        'total' => (float)$item->total
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::error("Error generating monthly sales data: " . $e->getMessage());
            $monthlySales = [];
        }

        // If no monthly data, create sample data
        if (empty($monthlySales)) {
            $today = Carbon::now();
            for ($i = 6; $i >= 0; $i--) {
                $date = $today->copy()->subMonths($i);
                $monthlySales[] = [
                    'month' => $date->format('M Y'),
                    'total' => 0
                ];
            }
        }
        
        // Generate customer sales data for chart
        try {
            $customerSalesCollection = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select('users.name', DB::raw('SUM(orders.total_amount) as total'))
                ->groupBy('users.id', 'users.name')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();
                
            // Convert to array with proper formatting
            $customerSales = [];
            foreach ($customerSalesCollection as $item) {
                $customerSales[] = [
                    'name' => $item->name,
                    'total' => (float)$item->total
                ];
            }
        } catch (\Exception $e) {
            Log::error("Error generating customer sales data: " . $e->getMessage());
            $customerSales = [];
        }

        // If no customer data, use the existing orders to create sample data
        if (empty($customerSales) && $sales->isNotEmpty()) {
            $customerMap = [];
            foreach ($sales as $order) {
                $userName = $order->user->name ?? 'Unknown Customer';
                if (!isset($customerMap[$userName])) {
                    $customerMap[$userName] = 0;
                }
                $customerMap[$userName] += $order->total_amount;
            }
            
            // Convert to array format
            foreach ($customerMap as $name => $total) {
                $customerSales[] = [
                    'name' => $name, 
                    'total' => (float)$total
                ];
            }
            
            // Sort by total amount
            usort($customerSales, function($a, $b) {
                return $b['total'] <=> $a['total'];
            });
            
            // Limit to 10
            $customerSales = array_slice($customerSales, 0, 10);
        }
        
        // Order status distribution for pie chart
        $statusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count()
        ];
        
        // Debug information to check data structure
        Log::info('Monthly sales data', ['data' => $monthlySales]);
        Log::info('Customer sales data', ['data' => $customerSales]);
        Log::info('Status counts data', ['data' => $statusCounts]);

        return view('manager.reports.sales', compact('sales', 'monthlySales', 'customerSales', 'statusCounts'));
    }
    
    public function salesReportPdf()
    {
        $this->authorize('viewAny', Order::class);
        
        $sales = Order::with('user', 'items.product')
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Add data for charts in PDF
        $monthlySalesCollection = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        // Convert to array with proper formatting
        $monthlySales = [];
        foreach ($monthlySalesCollection as $item) {
            try {
                $date = Carbon::createFromFormat('Y-m', $item->month);
                $monthlySales[] = [
                    'month' => $date->format('M Y'),
                    'total' => (float)$item->total
                ];
            } catch (\Exception $e) {
                $monthlySales[] = [
                    'month' => $item->month,
                    'total' => (float)$item->total
                ];
            }
        }
            
        // Customer sales data for chart
        $customerSalesCollection = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('SUM(orders.total_amount) as total'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
            
        // Convert to array with proper formatting
        $customerSales = [];
        foreach ($customerSalesCollection as $item) {
            $customerSales[] = [
                'name' => $item->name,
                'total' => (float)$item->total
            ];
        }
            
        $statusCounts = [
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count()
        ];
            
        return view('pdfs.sales_report', compact('sales', 'monthlySales', 'customerSales', 'statusCounts'));
    }
} 