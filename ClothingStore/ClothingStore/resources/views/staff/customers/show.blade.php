@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Customer Details') }}</span>
                    <a href="{{ route('staff.customers.index') }}" class="btn btn-secondary btn-sm">
                        {{ __('Back to Customers') }}
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{ __('Personal Information') }}</h4>
                            <table class="table">
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Email') }}</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Phone') }}</th>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Member Since') }}</th>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4>{{ __('Order Statistics') }}</h4>
                            <table class="table">
                                <tr>
                                    <th>{{ __('Total Orders') }}</th>
                                    <td>{{ $user->orders->count() }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Total Spent') }}</th>
                                    <td>${{ number_format($user->orders->sum('total_amount'), 2) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('Last Order') }}</th>
                                    <td>{{ $user->orders->max('created_at') ? $user->orders->max('created_at')->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4>{{ __('Recent Orders') }}</h4>
                        @if($user->orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Order ID') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Total') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->orders->take(5) as $order)
                                            <tr>
                                                <td>#{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
                                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('staff.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                        {{ __('View') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('staff.customers.orders', $user->id) }}" class="btn btn-primary">
                                    {{ __('View All Orders') }}
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                {{ __('No orders found for this customer.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 