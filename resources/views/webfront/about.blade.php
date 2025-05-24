@extends('layouts.master')

@section('title', 'About Us - HAM Store')

@section('content')
<style>
    .about-section {
        padding: 80px 0;
        background: var(--white);
    }
    .about__pic img {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    .about__pic img:hover {
        transform: scale(1.02);
    }
    .about__item {
        background: var(--white);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        margin-bottom: 30px;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .about__item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .about__item h4 {
        color: var(--text-color);
        font-weight: 700;
        margin-bottom: 25px;
        position: relative;
        padding-bottom: 15px;
        font-size: 24px;
    }
    .about__item h4:after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
    }
    .about__item p {
        color: var(--light-text);
        line-height: 1.8;
        font-size: 16px;
    }
    .counter__item {
        text-align: center;
        padding: 40px 30px;
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .counter__item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .counter__item__number h2 {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 15px;
    }
    .counter__item span {
        color: var(--light-text);
        font-size: 18px;
        font-weight: 500;
    }
    .team__item {
        text-align: center;
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }
    .team__item:hover {
        transform: translateY(-10px);
    }
    .team__item img {
        width: 100%;
        border-radius: 20px;
        margin-bottom: 25px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .team__item h4 {
        color: var(--text-color);
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 20px;
    }
    .team__item span {
        color: var(--primary-color);
        font-size: 16px;
        font-weight: 500;
    }
    .section-title {
        text-align: center;
        margin-bottom: 60px;
    }
    .section-title span {
        color: var(--primary-color);
        font-size: 18px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 4px;
        margin-bottom: 15px;
        display: block;
    }
    .section-title h2 {
        color: var(--text-color);
        font-size: 40px;
        font-weight: 700;
        margin-top: 10px;
    }
    .clients {
        background: var(--light-bg);
        padding: 80px 0;
    }
    .client__item {
        display: block;
        padding: 30px;
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }
    .client__item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    }
    .client__item img {
        max-width: 100%;
        height: auto;
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
        color: #e7ab3c;
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
        color: #e7ab3c;
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
        background: #e7ab3c;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .footer__newsletter button:hover {
        background: #d49b2c;
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

    <!-- Breadcrumb Section End -->

    <!-- About Section Begin -->
    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about__pic">
                        <img src="{{ asset('img/about/about-us.jpg') }}" alt="About Us">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>Who We Are?</h4>
                        <p>We are a dedicated team of fashion enthusiasts committed to bringing you the latest trends and highest quality products. Our passion for style and customer satisfaction drives everything we do.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>What We Do</h4>
                        <p>We curate and deliver exceptional fashion products that help our customers express their unique style. From trendy clothing to accessories, we ensure every item meets our high standards of quality.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>Why Choose Us</h4>
                        <p>With years of experience in the fashion industry, we offer unmatched quality, competitive prices, and exceptional customer service. Your satisfaction is our top priority.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Testimonial Section Begin -->
    <section class="testimonial">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="testimonial__text">
                        <span class="icon_quotations"></span>
                        <p>"We don’t just design clothes, we design moods. If you’ve ever worn a hoodie and felt like a superhero, yeah… that’s us"
                        </p>
                        <div class="testimonial__author">
                            <div class="testimonial__author__pic">
                                <img src="img/about/logo.png" alt="">
                            </div>
                            <div class="testimonial__author__text">
                                <h6>HAM Team</h6>
                                <h7>Where Style Meets Soul</h7>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="testimonial__pic set-bg" data-setbg="img/about/testimonial-pic.jpg"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Section End -->

    <!-- Counter Section Begin -->
    <section class="counter spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__number">
                            <h2 class="cn_num">{{ $clientsCount }}</h2>
                        </div>
                        <span>Our <br />Clients</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__number">
                            <h2 class="cn_num">{{ $categoriesCount }}</h2>
                        </div>
                        <span>Total <br />Categories</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__number">
                            <h2 class="cn_num">{{ $countriesCount }}</h2>
                        </div>
                        <span>In <br />Country</span>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="counter__item">
                        <div class="counter__item__number" style="display: flex; align-items: baseline; justify-content: center; gap: 4px;">
                            <h2 class="cn_num" style="color: #ffd700;">{{ $happyCustomersPercent }}</h2>
                            <strong style="color: #ffd700; font-size: 48px; font-weight: 700;">%</strong>
                        </div>
                        <span>Happy <br />Customers</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Counter Section End -->

    <!-- Team Section Begin -->
    <section class="team spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Our Team</span>
                        <h2>Meet Our Team</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="team__item">
                        <img src="{{ asset('img/about/team1.jpg') }}" alt="Mohamed Ali">
                        <h4>Mohamed Ali</h4>
                        <span>Designer</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="team__item">
                        <img src="img/about/team2.jpg" alt="Mostafa wagdy">
                        <h4>Mostafa wagdy</h4>
                        <span>C.E.O</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="team__item">
                        <img src="img/about/team3.jpg" alt="Marwan">
                        <h4>Marwan</h4>
                        <span>Manager</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="team__item">
                        <img src="img/about/team4.jpg" alt="Ahmed">
                        <h4>Desouky</h4>
                        <span>Co-Founder</span>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="team__item">
                        <img src="img/about/team5.jpg" alt="Hazem">
                        <h4>Hazem</h4>
                        <span>Web Developer</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Client Section Begin -->
    <section class="clients spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Partner</span>
                        <h2>Happy Clients</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                    <a href="#" class="client__item">
                        <img src="img/clients/client1.png" alt="Polytechnic Logo">
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                    <a href="#" class="client__item">
                        <img src="img/clients/client2.png" alt="Polytechnic Logo">
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                    <a href="#" class="client__item">
                        <img src="img/clients/client3.png" alt="Polytechnic Logo">
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                    <a href="#" class="client__item">
                        <img src="img/clients/client4.png" alt="Polytechnic Logo">
                    </a>
                </div>
                
            </div>

            </div>
        </div>
    </section>
    <!-- Client Section End -->

    

  
<!-- 
    Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@endsection