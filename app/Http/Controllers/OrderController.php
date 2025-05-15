<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Mail\OrderConfirmation;
use App\Mail\OrderStatusUpdate;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function salesReport()
    {
        $this->authorize('viewAny', Order::class);
        
        $orders = Order::selectRaw('
                DATE(created_at) as date,
                COUNT(*) as total_orders,
                SUM(total_amount) as total_sales
            ')
            ->where('status', 'completed')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('manager.reports.sales', compact('orders'));
    }
} 