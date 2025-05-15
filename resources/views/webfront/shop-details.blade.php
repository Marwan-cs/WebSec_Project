@extends('layouts.app')

@php use Illuminate\Support\Str; @endphp

@section('title', $product->name . ' - E-Commerce Store')

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('shop', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6 mb-4">
                @if(isset($product->images) && count($product->images) > 0)
                    <div class="card-body p-0">
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($product->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $image->url }}" class="d-block w-100" alt="{{ $product->name }}">
                                </div>
                                @endforeach
                            </div>
                            @if(count($product->images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                            @endif
                        </div>
                    </div>
                    <!-- Thumbnail Navigation -->
                    @if(count($product->images) > 1)
                    <div class="row mt-3">
                        @foreach($product->images as $index => $image)
                        <div class="col-3">
                            <img src="{{ $image->url }}" class="img-thumbnail cursor-pointer" 
                                 onclick="$('#productCarousel').carousel({{ $index }})" 
                                 alt="{{ $product->name }}">
                        </div>
                        @endforeach
                    </div>
                    @endif
                @else
                    <img src="{{ $product->image_url ?? '/img/shop-details/product-big.png' }}" class="img-fluid rounded w-100" alt="{{ $product->name }}">
                @endif
            </div>

            <!-- Product Info -->
            <div class="col-md-6">
                <h1 class="mb-3">{{ $product->name }}</h1>
                
                <!-- Price -->
                <div class="mb-3">
                    @if($product->is_sale)
                    <span class="text-decoration-line-through text-muted h4 me-2">${{ number_format($product->original_price, 2) }}</span>
                    @endif
                    <span class="h2 text-primary">${{ number_format($product->price, 2) }}</span>
                    @if($product->is_sale)
                    <span class="badge bg-danger ms-2">Sale</span>
                    @endif
                </div>

                <!-- Description -->
                <p class="text-muted mb-4">{{ $product->description }}</p>

                <!-- Stock Status -->
                <div class="mb-4">
                    @if($product->stock > 0)
                    <span class="badge bg-success">In Stock</span>
                    <small class="text-muted ms-2">{{ $product->stock }} units available</small>
                    @else
                    <span class="badge bg-danger">Out of Stock</span>
                    @endif
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" 
                                   value="1" min="1" max="{{ $product->stock }}">
                        </div>
                        <div class="col-md-9 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary btn-lg w-100" 
                                    {{ $product->stock === 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Product Meta -->
                <div class="border-top pt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>Category:</strong>
                                @if($product->category)
                                    <a href="{{ route('shop', ['category' => $product->category->slug]) }}">
                                        {{ $product->category->name }}
                                    </a>
                                @else
                                    <span>No Category</span>
                                @endif
                            </p>
                            <p class="mb-2">
                                <strong>Brand:</strong>
                                @if($product->brand)
                                    <a href="{{ route('shop', ['brand' => $product->brand->slug]) }}">
                                        {{ $product->brand->name }}
                                    </a>
                                @else
                                    <span>No Brand</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong>SKU:</strong> {{ $product->sku }}
                            </p>
                            <p class="mb-2">
                                <strong>Weight:</strong> {{ $product->weight }} kg
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Social Share -->
                <div class="border-top pt-4">
                    <h5>Share this product:</h5>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-primary" onclick="shareOnFacebook()">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-outline-info" onclick="shareOnTwitter()">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="btn btn-outline-danger" onclick="shareOnPinterest()">
                            <i class="fab fa-pinterest-p"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs" id="productTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description">
                            Description
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="specifications-tab" data-bs-toggle="tab" href="#specifications">
                            Specifications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews">
                            Reviews
                        </a>
                    </li>
                </ul>
                <div class="tab-content p-4 border border-top-0 rounded-bottom">
                    <div class="tab-pane fade show active" id="description">
                        {!! $product->long_description !!}
                    </div>
                    <div class="tab-pane fade" id="specifications">
                        <table class="table">
                            <tbody>
                                @if(!empty($product->specifications) && is_iterable($product->specifications))
                                    @foreach($product->specifications as $key => $value)
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <td>{{ $value }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">No specifications available.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="reviews">
                        @if(!empty($product->reviews) && is_countable($product->reviews) && $product->reviews->count() > 0)
                            @foreach($product->reviews as $review)
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <h6 class="mb-0">{{ $review->user->name }}</h6>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0">{{ $review->comment }}</p>
                            </div>
                            @endforeach
                        @else
                            <p class="text-muted">No reviews yet.</p>
                        @endif

                        @auth
                        <div class="mt-4">
                            <h5>Write a Review</h5>
                            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <div class="rating">
                                        @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}">
                                        <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Your Review</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Related Products</h3>
                <div class="row g-4">
                    @foreach($relatedProducts as $relatedProduct)
                    <div class="col-md-3">
                        <div class="card h-100">
                            <img src="{{ $relatedProduct->image_url ?? '/img/product/product-1.jpg' }}" class="card-img-top" alt="{{ $relatedProduct->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $relatedProduct->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($relatedProduct->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0">${{ number_format($relatedProduct->price, 2) }}</span>
                                    <a href="{{ url('/shop-details/' . $relatedProduct->id) }}" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('styles')
<style>
    .rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
    }
    .rating input {
        display: none;
    }
    .rating label {
        cursor: pointer;
        color: #ddd;
        font-size: 1.5rem;
        padding: 0 0.1em;
    }
    .rating input:checked ~ label,
    .rating label:hover,
    .rating label:hover ~ label {
        color: #ffd700;
    }
    .cursor-pointer {
        cursor: pointer;
    }
</style>
@endsection

@section('scripts')
<script>
    function shareOnFacebook() {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.href)}`);
    }

    function shareOnTwitter() {
        window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(window.location.href)}&text=${encodeURIComponent('{{ $product->name }}')}`);
    }

    function shareOnPinterest() {
        window.open(`https://pinterest.com/pin/create/button/?url=${encodeURIComponent(window.location.href)}&media=${encodeURIComponent('{{ $product->image_url }}')}&description=${encodeURIComponent('{{ $product->name }}')}`);
    }
</script>
@endsection