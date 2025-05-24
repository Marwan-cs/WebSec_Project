@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Inventory Management') }}</span>
                    <a href="{{ route('staff.dashboard') }}" class="btn btn-secondary btn-sm">
                        {{ __('Back to Dashboard') }}
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Search and Filter -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form action="{{ route('staff.inventory') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" placeholder="{{ __('Search products...') }}" value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </form>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                    {{ __('Filter by Stock') }}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('staff.inventory', ['stock' => 'low']) }}">{{ __('Low Stock') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('staff.inventory', ['stock' => 'out']) }}">{{ __('Out of Stock') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('staff.inventory', ['stock' => 'in']) }}">{{ __('In Stock') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if(isset($products) && count($products) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('SKU') }}</th>
                                        <th>{{ __('Stock') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Last Updated') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->sku ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-{{ $product->stock <= 0 ? 'danger' : ($product->stock <= 5 ? 'warning' : 'success') }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $product->stock <= 0 ? 'danger' : ($product->stock <= 5 ? 'warning' : 'success') }}">
                                                    {{ $product->stock <= 0 ? __('Out of Stock') : ($product->stock <= 5 ? __('Low Stock') : __('In Stock')) }}
                                                </span>
                                            </td>
                                            <td>{{ $product->updated_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('No products found.') }}
                        </div>
                    @endif

                    <!-- Stock Summary -->
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Out of Stock') }}</h5>
                                    <h2 class="card-text">{{ \App\Models\Product::where('stock', 0)->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('Low Stock') }}</h5>
                                    <h2 class="card-text">{{ \App\Models\Product::whereBetween('stock', [1, 5])->count() }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">{{ __('In Stock') }}</h5>
                                    <h2 class="card-text">{{ \App\Models\Product::where('stock', '>', 5)->count() }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .badge {
        font-size: 0.9em;
        padding: 0.5em 0.8em;
    }
</style>
@endpush 