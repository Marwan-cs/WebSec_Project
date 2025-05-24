@php
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HAM')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
           :root {
            --primary-color:rgb(99, 108, 113);
            --secondary-color: #ffd700;
            --text-color: #333333;
            --light-text: #666666;
            --white: #ffffff;
            --light-bg: #f8f9fa;
        }

        body {
            font-family: 'Nunito Sans', sans-serif;
            color: var(--text-color);
            background: var(--white);
        }

        .navbar {
            padding: 1rem 0;
            background: var(--white) !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .navbar-brand i {
            margin-right: 8px;
        }

        .nav-link {
            color: var(--text-color) !important;
            font-weight: 600;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .header__top {
            background: var(--light-bg);
            padding: 10px 0;
            font-size: 14px;
        }

        .header__top__left p {
            margin: 0;
            color: var(--light-text);
        }

        .header__top__links a {
            color: var(--light-text);
            text-decoration: none;
            margin-left: 20px;
            transition: all 0.3s ease;
        }

        .header__top__links a:hover {
            color: var(--primary-color);
        }

        .header__top__links button {
            background: none;
            border: none;
            color: var(--light-text);
            margin-left: 20px;
            transition: all 0.3s ease;
        }

        .header__top__links button:hover {
            color: var(--primary-color);
        }

        main {
            min-height: calc(100vh - 300px);
            padding: 40px 0;
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .navbar-brand img {
            height: 40px;
        }
        .cart-icon {
            position: relative;
        }
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
        .footer {
            background: #f8f9fa;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer {
        background: #ffffff;
        padding: 80px 0 0;
        box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
    }
    .footer__widget {
        margin-bottom: 40px;
    }
    .footer__widget h4 {
        color: #333333;
        font-weight: 700;
        margin-bottom: 25px;
        font-size: 20px;
        position: relative;
        padding-bottom: 15px;
    }
    .footer__widget h4:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 2px;
        background: linear-gradient(to right, #e7ab3c, #ffd700);
    }
    .footer__widget p {
        color: #666666;
        line-height: 1.8;
        margin-bottom: 20px;
    }
    .footer__social {
        margin-top: 20px;
    }
    .footer__social a {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: #f8f9fa;
        border-radius: 50%;
        text-align: center;
        line-height: 40px;
        color: #333333;
        margin-right: 10px;
        transition: all 0.3s ease;
    }
    .footer__social a:hover {
        background: #e7ab3c;
        color: #ffffff;
        transform: translateY(-3px);
    }
    .footer__links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer__links li {
        margin-bottom: 15px;
    }
    .footer__links a {
        color: #666666;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .footer__links a:hover {
        color:#333333;
        padding-left: 5px;
    }
    .footer__contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer__contact li {
        color: #666666;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    .footer__contact li i {
        color: #333333;
        margin-right: 10px;
        font-size: 18px;
    }
    .footer__newsletter input {
        width: 100%;
        padding: 15px;
        border: 1px solid #e1e1e1;
        border-radius: 5px;
        margin-bottom: 10px;
    }
    .footer__newsletter button {
        width: 100%;
        padding: 15px;
        background:#e7ab3c;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .footer__newsletter button:hover {
        background:#d49b2c;
    }
    .footer__copyright {
        border-top: 1px solid #e1e1e1;
        padding: 20px 0;
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .footer__copyright__text p {
        color: #666666;
        margin: 0;
    }
    .footer__copyright__payment img {
        height: 30px;
    }
    @media (max-width: 767px) {
        .footer__copyright {
            flex-direction: column;
            text-align: center;
        }
        .footer__copyright__payment {
            margin-top: 15px;
        }
    }
    </style>
    @yield('head')
    @yield('styles')
</head>
<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>


    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Free shipping, 30-day return or refund guarantee.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__links">
                                @guest
                                    <a href="{{ url('/login') }}">Sign In</a>
                                    <a href="{{ url('/register') }}">Register</a>
                                @else
                                    @if (!Auth::user()->hasVerifiedEmail())
                                        <a href="{{ route('verification.notice') }}" style="color: #e53637;">Verify Email</a>
                                    @endif
                                    <a href="{{ url('/profile') }}">Profile ({{ Auth::user()->name }})</a>
                                    <form action="{{ route('account.delete') }}" method="POST" style="display: inline; margin-right: 10px;" onsubmit="return confirm('Are you sure you want to permanently delete your account? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; color: #e53637; padding: 0;">Delete Account</button>
                                    </form>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: none; border: none; color: #e53637; padding: 0; margin-right: 15px;">Logout</button>
                                    </form>
                                @endguest
                                <!-- <a href="#">FAQs</a> -->
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>

   
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="HAM Store Logo" style="height: 38px; margin-right: 10px; display: inline-block; vertical-align: middle;">
                HAM Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link cart-icon" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="cart-count">{{ Cart::count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">Orders</a></li>
                                @if(Auth::user()->hasRole('admin'))
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                                @endif
                                @if(Auth::user()->hasRole('manager'))
                                    <li><a class="dropdown-item" href="{{ route('manager.dashboard') }}">Manager Dashboard</a></li>
                                @endif
                                @if(Auth::user()->hasRole('staff'))
                                    <li><a class="dropdown-item" href="{{ route('staff.dashboard') }}">Staff Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

     <!-- Footer Section Begin -->
     <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer__widget">
                        <h4>About HAM Store</h4>
                        <p>Your premier destination for fashion and style. We bring you the latest trends and highest quality products to express your unique style.</p>
                        <div class="footer__social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="footer__widget">
                        <h4>Quick Links</h4>
                        <ul class="footer__links">
                            <li><a href="/home">Home</a></li>
                            <li><a href="/shop">Shop</a></li>
                            <li><a href="/about">About Us</a></li>
                            <li><a href="contact">Contact</a></li>
                            <!-- <li><a href="#">Blog</a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="footer__widget">
                        <h4>Contact Info</h4>
                        <ul class="footer__contact">
                            <li><i class="fas fa-map-marker-alt"></i> Cairo, Egypt</li>
                            <li><i class="fas fa-phone"></i>15755</li>
                            <li><i class="fas fa-envelope"></i> info@hamstore.com</li>
                            <li><i class="fas fa-clock"></i> Sun-Thu: 9:00 AM - 6:00 PM</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer__widget">
                        <h4>Newsletter</h4>
                        <p>Subscribe to our newsletter for the latest updates and offers.</p>
                        <form class="footer__newsletter">
                            <input type="email" placeholder="Your email address">
                            <button type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p>Copyright © 2025 HAM Store. All rights reserved.</p>
                        </div>
                        <div class="footer__copyright__payment">
                            <img src="img/payment3.png" alt="Payment Methods">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

 

    <!-- Js Plugins  -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
    <!-- CSRF Token Setup -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
    @stack('scripts')
</body>
</html> 