@extends('layouts.app')

@section('title', 'Forgot Password - Wedding Event')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<!-- Page Loader -->
<div class="login-wed-lex1-page-loader" id="pageLoader">
    <div class="login-wed-lex1-infinity-loader">
        <svg class="login-wed-lex1-infinity-svg" viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="loaderGradient1" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#2F4F75;stop-opacity:1" />
                    <stop offset="50%" style="stop-color:#A3A5C7;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#0055A5;stop-opacity:1" />
                </linearGradient>
            </defs>
            <path class="login-wed-lex1-infinity-path" d="M 40 50 C 40 30, 60 30, 75 40 C 90 50, 90 50, 100 50 C 110 50, 110 50, 125 40 C 140 30, 160 30, 160 50 C 160 70, 140 70, 125 60 C 110 50, 110 50, 100 50 C 90 50, 90 50, 75 60 C 60 70, 40 70, 40 50 Z" fill="none" stroke="url(#loaderGradient1)" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
</div>

<div class="login-wed-lex1-container" id="mainContent" style="display: none;">
    <div class="login-wed-lex1-left-decor">
        <img src="{{ asset('Images/LoginAssets/leftLoginDecor1.png') }}" alt="Left Decoration" class="login-wed-lex1-decor-image">
    </div>
    <div class="login-wed-lex1-right-decor">
        <img src="{{ asset('Images/LoginAssets/rightLoginDecor1.png') }}" alt="Right Decoration" class="login-wed-lex1-decor-image">
    </div>

    <div class="container-fluid login-wed-lex1-wrapper">
        <div class="login-wed-lex1-title-section">
            <div class="login-wed-lex1-decorative-top">
                <img src="{{ asset('Images/LoginAssets/LogintxtDecor1.png') }}" alt="Text Decoration" class="login-wed-lex1-text-decor">
            </div>
            <h1 class="login-wed-lex1-title">Forgot Password</h1>
        </div>

        <div class="row g-0 login-wed-lex1-row">
            <div class="col-lg-6 login-wed-lex1-image-section">
                <div class="login-wed-lex1-image-wrapper">
                    <img src="{{ asset('Images/LoginAssets/LoginPage_img1.png') }}" alt="Wedding Welcome" class="login-wed-lex1-image">
                </div>
            </div>

            <div class="col-lg-6 login-wed-lex1-form-section">
                <div class="login-wed-lex1-form-wrapper">
                    @if(session('status'))
                        <div class="login-wed-lex1-alert login-wed-lex1-alert-success">
                            <svg class="login-wed-lex1-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>{{ session('status') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="login-wed-lex1-alert login-wed-lex1-alert-error">
                            <svg class="login-wed-lex1-alert-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8V12M12 16H12.01M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div>
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <p class="login-wed-lex1-forgot-intro">Enter your email address and we'll send you a link to reset your password.</p>

                    <form class="login-wed-lex1-form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="login-wed-lex1-form-group">
                            <label for="email" class="login-wed-lex1-label">Email <span class="login-wed-lex1-required">*</span></label>
                            <input type="email" id="email" name="email" class="login-wed-lex1-input @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="login-wed-lex1-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="login-wed-lex1-submit-btn">Send reset link</button>

                        <div class="login-wed-lex1-signup-wrapper">
                            <p class="login-wed-lex1-signup-text">Remember your password? <a href="{{ route('login') }}" class="login-wed-lex1-signup-link">Back to Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var loader = document.getElementById('pageLoader');
    var mainContent = document.getElementById('mainContent');
    setTimeout(function() {
        if (loader) {
            loader.style.opacity = '0';
            loader.style.transition = 'opacity 0.5s ease-out';
            setTimeout(function() {
                loader.style.display = 'none';
                if (mainContent) mainContent.style.display = 'block';
            }, 500);
        } else if (mainContent) mainContent.style.display = 'block';
    }, 1500);
});
</script>
@endpush
@endsection
