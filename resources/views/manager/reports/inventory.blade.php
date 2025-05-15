@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Inventory Report') }}</div>
                <div class="card-body">
                    @if(isset($products) && count($products))
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('Stock') }}</th>
                                        <th>{{ __('Price') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">No inventory data available.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 