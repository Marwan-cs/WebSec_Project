@extends('layouts.app')

@section('title', 'Shopping Cart - E-Commerce Store')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Shopping Cart</h1>

        @if(Cart::count() > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Cart::content() as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item['image'] ?? '/img/product/product-1.jpg' }}" alt="{{ $item['name'] }}" 
                                                     class="img-thumbnail me-3" style="width: 80px;">
                                                <div>
                                                    <h6 class="mb-0">{{ $item['name'] }}</h6>
                                                    <small class="text-muted">
                                                        @if($item->options->has('size'))
                                                        Size: {{ $item->options->size }}
                                                        @endif
                                                        @if($item->options->has('color'))
                                                        Color: {{ $item->options->color }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>
                                            <div class="input-group" style="width: 120px;">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                                        onclick="updateQuantity({{ $item->rowId }}, 'decrease')">-</button>
                                                <input type="number" class="form-control form-control-sm text-center" 
                                                       value="{{ $item->qty }}" min="1" max="{{ $item->model->stock }}"
                                                       onchange="updateQuantity({{ $item->rowId }}, 'set', this.value)">
                                                <button type="button" class="btn btn-outline-secondary btn-sm" 
                                                        onclick="updateQuantity({{ $item->rowId }}, 'increase')">+</button>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->total, 2) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-link text-danger" 
                                                    onclick="removeItem('{{ $item->rowId }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Cart Actions -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <button type="button" class="btn btn-outline-danger" onclick="clearCart()">
                        <i class="fas fa-trash me-2"></i>Clear Cart
                    </button>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Order Summary</h5>
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
                            <span>Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong class="text-primary">${{ number_format(Cart::total(), 2) }}</strong>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>

                <!-- Promo Code -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Promo Code</h5>
                        <form id="promoForm" class="d-flex gap-2">
                            <input type="text" class="form-control" placeholder="Enter promo code">
                            <button type="submit" class="btn btn-outline-primary">Apply</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h3>Your cart is empty</h3>
            <p class="text-muted">Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary mt-3">
                Start Shopping
            </a>
        </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    function updateQuantity(rowId, action, value = null) {
        let currentQty = parseInt(document.querySelector(`input[value="${value}"]`).value);
        let newQty = currentQty;

        if (action === 'increase') {
            newQty = currentQty + 1;
        } else if (action === 'decrease') {
            newQty = currentQty - 1;
        } else if (action === 'set') {
            newQty = parseInt(value);
        }

        if (newQty < 1) return;

        fetch(`/cart/update/${rowId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: newQty })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating cart');
        });
    }

    function removeItem(rowId) {
        if (!confirm('Are you sure you want to remove this item?')) return;

        fetch(`/cart/remove/${rowId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing item');
        });
    }

    function clearCart() {
        if (!confirm('Are you sure you want to clear your cart?')) return;

        fetch('/cart/clear', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error clearing cart');
        });
    }

    // Promo code form submission
    document.getElementById('promoForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const code = this.querySelector('input').value;

        fetch('/cart/apply-promo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ code })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Invalid promo code');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error applying promo code');
        });
    });
</script>
@endsection 