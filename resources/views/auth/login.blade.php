@extends('layouts.app')

@section('title', 'Login - Wedding Event')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="login-wed-lex1-container">
    <!-- Left Decorative Image -->
    <div class="login-wed-lex1-left-decor">
        <img src="{{ asset('Images/LoginAssets/leftLoginDecor1.png') }}" alt="Left Decoration" class="login-wed-lex1-decor-image">
    </div>

    <!-- Right Decorative Image -->
    <div class="login-wed-lex1-right-decor">
        <img src="{{ asset('Images/LoginAssets/rightLoginDecor1.png') }}" alt="Right Decoration" class="login-wed-lex1-decor-image">
    </div>

    <div class="container-fluid login-wed-lex1-wrapper">
        <!-- Title Section at Top -->
        <div class="login-wed-lex1-title-section">
            <!-- Decorative Element Above Title -->
            <div class="login-wed-lex1-decorative-top">
                <img src="{{ asset('Images/LoginAssets/LogintxtDecor1.png') }}" alt="Text Decoration" class="login-wed-lex1-text-decor">
            </div>
            <!-- Title -->
            <h1 class="login-wed-lex1-title">Login</h1>
        </div>

        <div class="row g-0 login-wed-lex1-row">
            <!-- Left Section - Image -->
            <div class="col-lg-6 login-wed-lex1-image-section">
                <div class="login-wed-lex1-image-wrapper">
                    <img src="{{ asset('Images/LoginAssets/LoginPage_img1.png') }}" alt="Wedding Welcome" class="login-wed-lex1-image">
                </div>
            </div>

            <!-- Right Section - Login Form -->
            <div class="col-lg-6 login-wed-lex1-form-section">
                <div class="login-wed-lex1-form-wrapper">
                    <!-- Form -->
                    <form class="login-wed-lex1-form" method="POST" action="/login">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="login-wed-lex1-form-group">
                            <label for="email" class="login-wed-lex1-label">Email <span class="login-wed-lex1-required">*</span></label>
                            <input type="email" id="email" name="email" class="login-wed-lex1-input" placeholder="Email" required>
                        </div>

                        <!-- Password Field -->
                        <div class="login-wed-lex1-form-group">
                            <label for="password" class="login-wed-lex1-label">Password <span class="login-wed-lex1-required">*</span></label>
                            <input type="password" id="password" name="password" class="login-wed-lex1-input" placeholder="Password" required>
                        </div>

                        <!-- Forgot Password -->
                        <div class="login-wed-lex1-forgot-wrapper">
                            <a href="#" class="login-wed-lex1-forgot-link">Forgot password ?</a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="login-wed-lex1-submit-btn">Login</button>

                        <!-- Sign Up Link -->
                        <div class="login-wed-lex1-signup-wrapper">
                            <p class="login-wed-lex1-signup-text">Don't have an account? <a href="{{ route('signup') }}" class="login-wed-lex1-signup-link">Sign Up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
