@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Checkout</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="shipping_address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('shipping_address') is-invalid @enderror" 
                                    id="shipping_address" name="shipping_address" value="{{ old('shipping_address') }}" required>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_city" class="form-label">City</label>
                                <input type="text" class="form-control @error('shipping_city') is-invalid @enderror" 
                                    id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" required>
                                @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_state" class="form-label">State</label>
                                <input type="text" class="form-control @error('shipping_state') is-invalid @enderror" 
                                    id="shipping_state" name="shipping_state" value="{{ old('shipping_state') }}" required>
                                @error('shipping_state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_zipcode" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control @error('shipping_zipcode') is-invalid @enderror" 
                                    id="shipping_zipcode" name="shipping_zipcode" value="{{ old('shipping_zipcode') }}" required>
                                @error('shipping_zipcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_country" class="form-label">Country</label>
                                <input type="text" class="form-control @error('shipping_country') is-invalid @enderror" 
                                    id="shipping_country" name="shipping_country" value="{{ old('shipping_country') }}" required>
                                @error('shipping_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5>Payment Method</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="credit_card" value="credit_card" checked>
                                <label class="form-check-label" for="credit_card">
                                    Credit Card
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    PayPal
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>${{ number_format($total, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 