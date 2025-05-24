@php
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="HAM Store - Your Fashion Destination">
    <meta name="keywords" content="HAM Store, fashion, clothing, accessories">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'HAM Store')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">

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

        footer {
            background: var(--white);
            padding: 60px 0 20px;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
        }

        footer h5 {
            color: var(--text-color);
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        footer h5:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 2px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }

        footer p {
            color: var(--light-text);
            line-height: 1.8;
        }

        footer ul li {
            margin-bottom: 12px;
        }

        footer ul li a {
            color: var(--light-text);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        footer ul li a:hover {
            color: var(--primary-color);
            padding-left: 5px;
        }

        footer ul li i {
            color: var(--primary-color);
            margin-right: 10px;
        }

        hr {
            margin: 30px 0;
            border-color: rgba(0,0,0,0.1);
        }

        .text-center p {
            margin: 0;
            color: var(--light-text);
        }

        @media (max-width: 767px) {
            .header__top__left {
                text-align: center;
                margin-bottom: 10px;
            }
            .header__top__right {
                text-align: center;
            }
            .header__top__links {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .header__top__links a,
            .header__top__links button {
                margin: 5px 0;
            }
        }
    </style>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
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
            </div>

        </div>
      
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>Free shipping, 30-day return or refund guarantee.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

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
     <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('img/logo.png') }}" alt="HAM Store Logo" style="height: 38px; margin-right: 10px; display: inline-block; vertical-align: middle;">
                HAM Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
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
              

            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
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
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

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

    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins  -->
    <!-- <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.js') }}"></script>
    <script src="{{ asset('js/mixitup.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
     -->
    <!-- CSRF Token Setup
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>

</html>