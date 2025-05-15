@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Sales Report') }}</div>
                <div class="card-body">
                    @if(isset($sales) && count($sales))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Order ID') }}</th>
                                        <th>{{ __('Customer') }}</th>
                                        <th>{{ __('Total Amount') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>{{ ucfirst($order->status) }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No sales data available.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 