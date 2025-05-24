@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Manage Customers') }}</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(isset($customers) && count($customers) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Phone') }}</th>
                                        <th>{{ __('Total Orders') }}</th>
                                        <th>{{ __('Total Spent') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($customers as $customer)
                                        <tr>
                                            <td>#{{ $customer->id }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone ?? 'N/A' }}</td>
                                            <td>{{ $customer->orders_count ?? 0 }}</td>
                                            <td>${{ number_format($customer->total_spent ?? 0, 2) }}</td>
                                            <td>
                                                <a href="{{ route('staff.customers.show', $customer->id) }}" class="btn btn-sm btn-info">
                                                    {{ __('View Details') }}
                                                </a>
                                                <a href="{{ route('staff.customers.orders', $customer->id) }}" class="btn btn-sm btn-primary">
                                                    {{ __('View Orders') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $customers->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('No customers found.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 