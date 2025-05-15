@extends('layouts.app')

@section('title', 'Checkout - E-Commerce Store')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Checkout</h1>

        @if(Cart::count() > 0)
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-8">
                <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                    @csrf
                    
                    <!-- Shipping Information -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Shipping Information</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" 
                                           value="{{ old('first_name', auth()->user()->first_name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" 
                                           value="{{ old('last_name', auth()->user()->last_name ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                                </div>
                                <div class="col-12">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" 
                                           value="{{ old('address', auth()->user()->address ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control" id="city" name="city" 
                                           value="{{ old('city', auth()->user()->city ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control" id="state" name="state" 
                                           value="{{ old('state', auth()->user()->state ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="zip_code" class="form-label">ZIP Code</label>
                                    <input type="text" class="form-control" id="zip_code" name="zip_code" 
                                           value="{{ old('zip_code', auth()->user()->zip_code ?? '') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="country" name="country" required>
                                        <option value="">Select Country</option>
                                        @foreach($countries as $code => $name)
                                        <option value="{{ $code }}" {{ old('country', auth()->user()->country ?? '') == $code ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Shipping Method</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="shipping_method" 
                                       id="standard" value="standard" checked>
                                <label class="form-check-label" for="standard">
                                    Standard Shipping (3-5 business days)
                                    <span class="float-end">Free</span>
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="shipping_method" 
                                       id="express" value="express">
                                <label class="form-check-label" for="express">
                                    Express Shipping (1-2 business days)
                                    <span class="float-end">$10.00</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Payment Method</h5>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="credit_card" value="credit_card" checked>
                                <label class="form-check-label" for="credit_card">
                                    Credit Card
                                </label>
                            </div>
                            <div id="creditCardFields" class="ps-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="card_number" class="form-label">Card Number</label>
                                        <input type="text" class="form-control" id="card_number" 
                                               placeholder="1234 5678 9012 3456" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry_date" 
                                               placeholder="MM/YY" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cvv" class="form-label">CVV</label>
                                        <input type="text" class="form-control" id="cvv" 
                                               placeholder="123" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mb-3 mt-3">
                                <input class="form-check-input" type="radio" name="payment_method" 
                                       id="paypal" value="paypal">
                                <label class="form-check-label" for="paypal">
                                    PayPal
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Order Notes (Optional)</h5>
                            <textarea class="form-control" name="notes" rows="3" 
                                      placeholder="Add any special instructions or notes for your order...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Order Summary</h5>
                        
                        <!-- Cart Items -->
                        <div class="mb-4">
                            @foreach(Cart::content() as $item)
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                    <small class="text-muted">Qty: {{ $item->qty }}</small>
                                </div>
                                <span>${{ number_format($item->total, 2) }}</span>
                            </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="border-top pt-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>${{ number_format(Cart::subtotal(), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax</span>
                                <span>${{ number_format(Cart::tax(), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping</span>
                                <span id="shippingCost">Free</span>
                            </div>
                            @if(Cart::discount() > 0)
                            <div class="d-flex justify-content-between mb-2 text-success">
                                <span>Discount</span>
                                <span>-${{ number_format(Cart::discount(), 2) }}</span>
                            </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total</strong>
                                <strong class="text-primary" id="orderTotal">${{ number_format(Cart::total(), 2) }}</strong>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" form="checkoutForm" class="btn btn-primary w-100">
                            Place Order
                        </button>
                    </div>
                </div>

                <!-- Security Notice -->
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lock text-primary me-3 fa-2x"></i>
                            <div>
                                <h6 class="mb-1">Secure Checkout</h6>
                                <p class="mb-0 small text-muted">Your payment information is encrypted and secure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Please add items to your cart before proceeding to checkout.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary mt-3">
                Continue Shopping
            </a>
        </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    // Handle shipping method change
    document.querySelectorAll('input[name="shipping_method"]').forEach(input => {
        input.addEventListener('change', function() {
            const shippingCost = this.value === 'express' ? 10 : 0;
            const shippingElement = document.getElementById('shippingCost');
            const totalElement = document.getElementById('orderTotal');
            
            shippingElement.textContent = shippingCost === 0 ? 'Free' : `$${shippingCost.toFixed(2)}`;
            
            // Update total (you'll need to implement the actual calculation based on your cart total)
            const currentTotal = parseFloat(totalElement.textContent.replace('$', ''));
            const newTotal = currentTotal + shippingCost;
            totalElement.textContent = `$${newTotal.toFixed(2)}`;
        });
    });

    // Handle payment method change
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', function() {
            const creditCardFields = document.getElementById('creditCardFields');
            creditCardFields.style.display = this.value === 'credit_card' ? 'block' : 'none';
        });
    });

    // Form validation
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Add your form validation logic here
        // If validation passes, submit the form
        this.submit();
    });

    // Card number formatting
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = '';
        for(let i = 0; i < value.length; i++) {
            if(i > 0 && i % 4 === 0) {
                formattedValue += ' ';
            }
            formattedValue += value[i];
        }
        e.target.value = formattedValue;
    });

    // Expiry date formatting
    document.getElementById('expiry_date').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if(value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });

    // CVV validation
    document.getElementById('cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '').substring(0, 3);
    });
</script>
@endsection 