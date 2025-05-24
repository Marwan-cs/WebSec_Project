@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp
@php use Illuminate\Support\Facades\Auth; @endphp

@section('title', 'Shop - E-Commerce Store')

@section('content')
<style>
    body {
        background: #f8f9fa;
    }
    .shop-header {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(99,108,113,0.08);
        padding: 32px 24px 24px 24px;
        margin-bottom: 32px;
    }
    .shop-header h1 {
        color: #333;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .dropdown .btn {
        border-radius: 8px;
        font-weight: 600;
    }
    .btn-group .btn {
        border-radius: 8px !important;
    }
    .card {
        border-radius: 18px;
        box-shadow: 0 2px 12px rgba(99,108,113,0.07);
        border: none;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .card:hover {
        box-shadow: 0 8px 32px rgba(99,108,113,0.13);
        transform: translateY(-4px) scale(1.01);
    }
    .card-title {
        font-weight: 700;
        color: #222;
    }
    .card-text {
        color: #666;
        font-size: 0.98rem;
    }
    .badge.bg-danger {
        background: #e74c3c !important;
        font-size: 0.95rem;
        padding: 0.5em 1em;
        border-radius: 12px;
        font-weight: 600;
    }
    .btn-primary, .btn-success, .btn-warning, .btn-danger {
        border-radius: 8px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(99,108,113,0.07);
        transition: background 0.2s, color 0.2s;
    }
    .btn-primary {
        background: #e7ab3c;
        border: none;
        color: #fff;
    }
    .btn-primary:hover {
        background: #ffd700;
        color: #333;
    }
    .btn-outline-primary {
        border-radius: 8px;
        color: #e7ab3c;
        border: 1.5px solid #e7ab3c;
        font-weight: 600;
    }
    .btn-outline-primary:hover {
        background: #e7ab3c;
        color: #fff;
    }
    .btn-outline-secondary {
        border-radius: 8px;
        font-weight: 600;
    }
    .add-to-cart {
        background: #333;
        color: #fff;
        border: none;
        border-radius: 8px;
        transition: background 0.2s;
    }
    .add-to-cart:hover {
        background: #e7ab3c;
        color: #fff;
    }
    .list-group-item.active {
        background: #e7ab3c;
        border-color: #e7ab3c;
        color: #fff;
        font-weight: 700;
    }
    .list-group-item {
        border-radius: 8px !important;
        margin-bottom: 6px;
        font-weight: 500;
        color: #333;
    }
    .form-control, .form-check-input {
        border-radius: 8px;
    }
    .form-check-label {
        font-weight: 500;
        color: #444;
    }
    .card-img-top {
        border-radius: 14px 14px 0 0;
        object-fit: cover;
        height: 220px;
        background: #f8f9fa;
    }
    .btn-group .btn {
        margin-right: 4px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    .pagination .page-link {
        border-radius: 8px !important;
        color: #e7ab3c;
        font-weight: 600;
    }
    .pagination .page-item.active .page-link {
        background: #e7ab3c;
        border-color: #e7ab3c;
        color: #fff;
    }
    @media (max-width: 991px) {
        .card-img-top {
            height: 160px;
        }
    }
</style>
    <!-- Shop Header -->
    <div class="shop-header bg-light py-4 mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0">Shop</h1>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end">
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                                Sort By
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Price: Low to High</a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Price: High to Low</a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest First</a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}">Most Popular</a></li>
                            </ul>
                        </div>
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Categories</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('shop') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                                All Categories
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" 
                               class="list-group-item list-group-item-action {{ request('category') == $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Price Range</h5>
                        <form action="{{ route('shop') }}" method="GET">
                            <div class="mb-3">
                                <label for="min_price" class="form-label">Min Price</label>
                                <input type="number" class="form-control" id="min_price" name="min_price" 
                                       value="{{ request('min_price') }}" min="0">
                            </div>
                            <div class="mb-3">
                                <label for="max_price" class="form-label">Max Price</label>
                                <input type="number" class="form-control" id="max_price" name="max_price" 
                                       value="{{ request('max_price') }}" min="0">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Brands</h5>
                        <div class="form-check">
                            @foreach($brands as $brand)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="brands[]" 
                                       value="{{ $brand->id }}" id="brand{{ $brand->id }}"
                                       {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="brand{{ $brand->id }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                @if(Auth::user() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')))
                    <div class="mb-3">
                        <a href="{{ route('products.create') }}" class="btn btn-success">Add Product</a>
                    </div>
                @endif
                <div class="row g-4" id="products-grid">
                    @forelse($products as $product)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="position-relative">
                                <img src="{{ $product->image_url ?? '/img/product/product-1.jpg' }}" class="card-img-top" alt="{{ $product->name }}">
                                @if($product->is_sale)
                                <span class="position-absolute top-0 end-0 badge bg-danger m-2">Sale</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($product->is_sale)
                                        <span class="text-decoration-line-through text-muted me-2">${{ number_format($product->original_price, 2) }}</span>
                                        @endif
                                        <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                    <div class="btn-group">
                                        <a href="{{ url('/shop-details/' . $product->id) }}" class="btn btn-outline-primary">View</a>
                                        <button type="button" class="btn btn-primary add-to-cart" data-product-id="{{ $product->id }}">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                        @if(Auth::user() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager')))
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No products found matching your criteria.
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // View switching
    document.querySelectorAll('[data-view]').forEach(button => {
        button.addEventListener('click', function() {
            const view = this.dataset.view;
            const productsGrid = document.getElementById('products-grid');
            
            // Update active state
            document.querySelectorAll('[data-view]').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update grid/list view
            if (view === 'list') {
                productsGrid.classList.remove('row');
                productsGrid.classList.add('list-view');
            } else {
                productsGrid.classList.remove('list-view');
                productsGrid.classList.add('row');
            }
        });
    });

    // Add to cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            // Send AJAX request to add to cart
            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    document.querySelector('.cart-count').textContent = data.cartCount;
                    
                    // Show success message
                    alert('Product added to cart successfully!');
                } else {
                    alert('Error adding product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding product to cart');
            });
        });
    });
</script>
@endsection