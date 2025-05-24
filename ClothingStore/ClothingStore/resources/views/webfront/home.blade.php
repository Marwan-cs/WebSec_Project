@extends('layouts.app')

@section('title', 'Home - E-Commerce Store')

@section('content')
    <!-- Hero Section -->
    <div class="bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold">Welcome to Our Store</h1>
                    <p class="lead">Discover amazing products at unbeatable prices.</p>
                    <a href="{{ route('shop') }}" class="btn btn-light btn-lg">Shop Now</a>
                </div>
                <div class="col-md-6">
                    <img src="/img/hero/hero-1.jpg" alt="Hero Image" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Categories -->
    <section class="mb-5">
        <div class="container">
            <h2 class="text-center mb-4">Shop by Category</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="/img/banner/banner-1.jpg" class="card-img-top" alt="Electronics">
                        <div class="card-body text-center">
                            <h5 class="card-title">Electronics</h5>
                            <a href="{{ route('shop') }}?category=electronics" class="btn btn-outline-primary">View Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="/img/banner/banner-2.jpg" class="card-img-top" alt="Fashion">
                        <div class="card-body text-center">
                            <h5 class="card-title">Fashion</h5>
                            <a href="{{ route('shop') }}?category=fashion" class="btn btn-outline-primary">View Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="/img/banner/banner-3.jpg" class="card-img-top" alt="Home & Living">
                        <div class="card-body text-center">
                            <h5 class="card-title">Home & Living</h5>
                            <a href="{{ route('shop') }}?category=home" class="btn btn-outline-primary">View Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="mb-5">
        <div class="container">
            <h2 class="text-center mb-4">Featured Products</h2>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                <div class="col-md-3">
                    <div class="card h-100">
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Illuminate\Support\Str::limit($product->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">${{ number_format($product->price, 2) }}</span>
                                <a href="{{ url('/shop-details/' . $product->id) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Special Offers -->
    <section class="bg-light py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Special Offers</h2>
                    <p class="lead">Get up to 50% off on selected items!</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success me-2"></i> Free shipping on orders over $50</li>
                        <li><i class="fas fa-check text-success me-2"></i> 30-day money-back guarantee</li>
                        <li><i class="fas fa-check text-success me-2"></i> Secure payment processing</li>
                    </ul>
                    <a href="{{ route('shop') }}?sale=true" class="btn btn-primary btn-lg">Shop Sale Items</a>
                </div>
                <div class="col-md-6">
                    <img src="/img/hero/hero-1.jpg" alt="Special Offers" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="mb-5">
        <div class="container">
            <h2 class="text-center mb-4">What Our Customers Say</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="/img/about/testimonial-pic.jpg" class="rounded-circle me-3" alt="Customer" style="width: 64px; height: 64px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-0">John Doe</h5>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text">"Amazing products and fast shipping! Will definitely shop here again."</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="/img/about/testimonial-pic.jpg" class="rounded-circle me-3" alt="Customer" style="width: 64px; height: 64px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-0">Jane Smith</h5>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text">"Great customer service and quality products. Highly recommended!"</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="/img/about/testimonial-pic.jpg" class="rounded-circle me-3" alt="Customer" style="width: 64px; height: 64px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-0">Mike Johnson</h5>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text">"The best online shopping experience I've had. Fast delivery and great prices."</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
