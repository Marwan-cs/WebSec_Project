<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function staffCustomersIndex()
    {
        $this->authorize('viewAny', User::class);
        
        $customers = User::withCount('orders')
            ->withSum('orders as total_spent', 'total_amount')
            ->whereHas('roles', function($query) {
                $query->where('name', 'customer');
            })
            ->latest()
            ->paginate(10);

        return view('staff.customers.index', compact('customers'));
    }

    public function staffCustomerShow(User $user)
    {
        $this->authorize('view', $user);
        
        $user->load(['orders' => function($query) {
            $query->latest();
        }]);

        return view('staff.customers.show', compact('user'));
    }

    public function staffCustomerOrders(User $user)
    {
        $this->authorize('view', $user);
        
        $orders = $user->orders()
            ->with(['items.product'])
            ->latest()
            ->paginate(10);

        return view('staff.customers.orders', compact('user', 'orders'));
    }
} 