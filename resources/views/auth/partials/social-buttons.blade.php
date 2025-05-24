<link rel="stylesheet" href="{{ asset('css/social-login.css') }}">

<div class="social-auth-links text-center">
    <p class="text-center">- OR {{ $text ?? 'Sign in' }} With -</p>
    <div class="d-flex flex-wrap justify-content-center gap-2 mb-3">
        <a href="{{ route('socialite.redirect', 'facebook') }}" class="btn social-btn facebook-btn">
            <i class="fab fa-facebook-f"></i> Facebook
        </a>
        <a href="{{ route('socialite.redirect', 'google') }}" class="btn social-btn google-btn">
            <i class="fab fa-google"></i> Google
        </a>
        <a href="{{ route('socialite.redirect', 'github') }}" class="btn social-btn github-btn">
            <i class="fab fa-github"></i> GitHub
        </a>
    </div>
</div>
