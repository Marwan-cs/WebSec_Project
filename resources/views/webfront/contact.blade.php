@extends('layouts.master')

@section('title', 'Contact Us - HAM Store')

@section('content')
<style>
    .contact-section {
        padding: 60px 0 40px 0;
        background: var(--light-bg);
    }
    .contact-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 6px 24px rgba(99,108,113,0.10);
        padding: 40px 32px 32px 32px;
        max-width: 950px;
        margin: 0 auto 40px auto;
        display: flex;
        flex-wrap: wrap;
        gap: 32px;
    }
    .contact-info {
        flex: 1 1 260px;
        min-width: 240px;
        margin-bottom: 20px;
    }
    .contact-info h3 {
        color: var(--primary-color);
        font-weight: 800;
        margin-bottom: 18px;
        font-size: 1.5rem;
    }
    .contact-info ul {
        list-style: none;
        padding: 0;
        margin: 0 0 18px 0;
    }
    .contact-info ul li {
        margin-bottom: 14px;
        color: #555;
        font-size: 1.05rem;
        display: flex;
        align-items: center;
    }
    .contact-info ul li i {
        color: var(--primary-color);
        margin-right: 10px;
        font-size: 1.2rem;
        min-width: 22px;
        text-align: center;
    }
    .contact-info .social {
        margin-top: 18px;
    }
    .contact-info .social a {
        display: inline-block;
        margin-right: 10px;
        color: var(--primary-color);
        font-size: 1.3rem;
        transition: color 0.2s;
    }
    .contact-info .social a:hover {
        color: var(--secondary-color);
    }
    .contact-form {
        flex: 2 1 340px;
        min-width: 280px;
    }
    .contact-form h3 {
        color: var(--primary-color);
        font-weight: 800;
        margin-bottom: 18px;
        font-size: 1.5rem;
    }
    .contact-form form input,
    .contact-form form textarea {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e1e1e1;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 1rem;
        background: #f8f9fa;
        transition: border 0.2s;
    }
    .contact-form form input:focus,
    .contact-form form textarea:focus {
        border-color: var(--primary-color);
        outline: none;
    }
    .contact-form form button {
        background: var(--primary-color);
        color: #fff;
        border: none;
        padding: 12px 32px;
        border-radius: 6px;
        font-weight: bold;
        font-size: 1.1rem;
        transition: background 0.2s;
    }
    .contact-form form button:hover {
        background: var(--secondary-color);
        color: #333;
    }
    .map-responsive {
        overflow: hidden;
        padding-bottom: 40%;
        position: relative;
        height: 0;
        border-radius: 18px;
        margin-top: 40px;
        box-shadow: 0 4px 18px rgba(99,108,113,0.08);
    }
    .map-responsive iframe {
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        position: absolute;
        border: 0;
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

    @media (max-width: 900px) {
        .contact-card {
            flex-direction: column;
            padding: 32px 10px 24px 10px;
        }
        .map-responsive {
            padding-bottom: 60%;
        }
    }
</style>

<section class="contact-section">
    <div style="text-align:center; margin-bottom: 30px;">
        <img src="{{ asset('img/logo.png') }}" alt="HAM Store Logo" style="height:70px; border-radius:16px; box-shadow:0 2px 12px rgba(99,108,113,0.10);">
        <h4 style="color: #333333; font-weight: 700; margin-bottom: 25px; font-size: 20px; position: relative; padding-bottom: 15px;">Ham Store</h4>
    </div>
    <div class="contact-card">
        <!-- Contact Info -->
        <div class="contact-info">
            <h3>Contact Information</h3>
            <ul>
                <li><i class="fas fa-map-marker-alt"></i> Cairo, Egypt</li>
                <li><i class="fas fa-phone"></i> 15755</li>
                <li><i class="fas fa-envelope"></i> info@hamstore.com</li>
                <li><i class="fas fa-clock"></i> Sun-Thu: 9:00 AM - 6:00 PM</li>
            </ul>
            <div class="social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <!-- Contact Form -->
        <div class="contact-form">
            <h3>Send Us a Message</h3>
            <form method="POST" action="#">
                @csrf
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="subject" placeholder="Subject" required>
                <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>
    <!-- Google Map (optional, you can remove this if you don't want a map) -->
    <div class="map-responsive">
        <iframe src="https://www.google.com/maps?q=Cairo,+Egypt&output=embed"></iframe>
    </div>
</section>
@endsection

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