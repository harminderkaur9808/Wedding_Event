@extends('layouts.app')

@section('title', 'Sign Up - Wedding Event')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/signup.css') }}">
@endpush

@section('content')
<!-- Page Loader -->
<div class="login-wed-lex1-page-loader" id="pageLoader">
    <div class="login-wed-lex1-infinity-loader">
        <svg class="login-wed-lex1-infinity-svg" viewBox="0 0 200 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="signupLoaderGradient1" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:#2F4F75;stop-opacity:1" />
                    <stop offset="50%" style="stop-color:#A3A5C7;stop-opacity:1" />
                    <stop offset="100%" style="stop-color:#0055A5;stop-opacity:1" />
                </linearGradient>
            </defs>
            <!-- Infinity Symbol Path - Continuous Loop -->
            <path class="login-wed-lex1-infinity-path" 
                  d="M 40 50 
                     C 40 30, 60 30, 75 40
                     C 90 50, 90 50, 100 50
                     C 110 50, 110 50, 125 40
                     C 140 30, 160 30, 160 50
                     C 160 70, 140 70, 125 60
                     C 110 50, 110 50, 100 50
                     C 90 50, 90 50, 75 60
                     C 60 70, 40 70, 40 50 Z" 
                  fill="none" 
                  stroke="url(#signupLoaderGradient1)" 
                  stroke-width="6" 
                  stroke-linecap="round" 
                  stroke-linejoin="round"/>
        </svg>
    </div>
</div>

<div class="login-wed-lex1-container" id="mainContent" style="display: none;">
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
            <h1 class="login-wed-lex1-title">Sign Up</h1>
        </div>

        <div class="row g-0 login-wed-lex1-row">
            <!-- Left Section - Image -->
            <div class="col-lg-6 login-wed-lex1-image-section">
                <div class="login-wed-lex1-image-wrapper">
                    <img src="{{ asset('Images/LoginAssets/SignUp_img1.png') }}" alt="Wedding Couple" class="login-wed-lex1-image">
                </div>
            </div>

            <!-- Right Section - Sign Up Form -->
            <div class="col-lg-6 login-wed-lex1-form-section">
                <div class="login-wed-lex1-form-wrapper">
                    <!-- Error Messages -->
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

                    <!-- Form -->
                    <form class="login-wed-lex1-form" method="POST" action="/signup">
                        @csrf
                        
                        <!-- First Name Field -->
                        <div class="login-wed-lex1-form-group">
                            <label for="first_name" class="login-wed-lex1-label">First name <span class="login-wed-lex1-required">*</span></label>
                            <input type="text" id="first_name" name="first_name" class="login-wed-lex1-input @error('first_name') is-invalid @enderror" placeholder="First name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <span class="login-wed-lex1-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name Field -->
                        <div class="login-wed-lex1-form-group">
                            <label for="last_name" class="login-wed-lex1-label">Last name <span class="login-wed-lex1-required">*</span></label>
                            <input type="text" id="last_name" name="last_name" class="login-wed-lex1-input @error('last_name') is-invalid @enderror" placeholder="Last name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <span class="login-wed-lex1-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="login-wed-lex1-form-group">
                            <label for="email" class="login-wed-lex1-label">Email <span class="login-wed-lex1-required">*</span></label>
                            <input type="email" id="email" name="email" class="login-wed-lex1-input @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="login-wed-lex1-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Family Relation Field -->
                        <div class="login-wed-lex1-form-group">
                            <label for="family_relation" class="login-wed-lex1-label">Family relation <span class="login-wed-lex1-required">*</span></label>
                            <select id="family_relation" name="family_relation" class="login-wed-lex1-input @error('family_relation') is-invalid @enderror" required>
                                <option value="">Choose</option>
                                <option value="father" {{ old('family_relation') == 'father' ? 'selected' : '' }}>Father</option>
                                <option value="mother" {{ old('family_relation') == 'mother' ? 'selected' : '' }}>Mother</option>
                                <option value="brother" {{ old('family_relation') == 'brother' ? 'selected' : '' }}>Brother</option>
                                <option value="sister" {{ old('family_relation') == 'sister' ? 'selected' : '' }}>Sister</option>
                                <option value="uncle" {{ old('family_relation') == 'uncle' ? 'selected' : '' }}>Uncle</option>
                                <option value="aunt" {{ old('family_relation') == 'aunt' ? 'selected' : '' }}>Aunt</option>
                                <option value="cousin" {{ old('family_relation') == 'cousin' ? 'selected' : '' }}>Cousin</option>
                                <option value="grandfather" {{ old('family_relation') == 'grandfather' ? 'selected' : '' }}>Grandfather</option>
                                <option value="grandmother" {{ old('family_relation') == 'grandmother' ? 'selected' : '' }}>Grandmother</option>
                                <option value="nephew" {{ old('family_relation') == 'nephew' ? 'selected' : '' }}>Nephew</option>
                                <option value="niece" {{ old('family_relation') == 'niece' ? 'selected' : '' }}>Niece</option>
                                <option value="brother_in_law" {{ old('family_relation') == 'brother_in_law' ? 'selected' : '' }}>Brother-in-law</option>
                                <option value="sister_in_law" {{ old('family_relation') == 'sister_in_law' ? 'selected' : '' }}>Sister-in-law</option>
                                <option value="father_in_law" {{ old('family_relation') == 'father_in_law' ? 'selected' : '' }}>Father-in-law</option>
                                <option value="mother_in_law" {{ old('family_relation') == 'mother_in_law' ? 'selected' : '' }}>Mother-in-law</option>
                                <option value="friend" {{ old('family_relation') == 'friend' ? 'selected' : '' }}>Friend</option>
                                <option value="other" {{ old('family_relation') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('family_relation')
                                <span class="login-wed-lex1-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="login-wed-lex1-form-group">
                            <label for="password" class="login-wed-lex1-label">Password <span class="login-wed-lex1-required">*</span></label>
                            <div class="login-wed-lex1-password-wrapper">
                                <input type="password" id="password" name="password" class="login-wed-lex1-input @error('password') is-invalid @enderror" placeholder="Password" required>
                                <span class="login-wed-lex1-password-toggle" onclick="togglePassword('password')">
                                    <svg class="login-wed-lex1-eye-icon login-wed-lex1-eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <svg class="login-wed-lex1-eye-icon login-wed-lex1-eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                        <path d="M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.68192 3.96914 7.65663 6.06 6.06M9.9 4.24C10.5883 4.0789 11.2931 3.99836 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2048 20.84 15.19M14.12 14.12C13.8454 14.4148 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1751 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.4811 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8249 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                            @error('password')
                                <span class="login-wed-lex1-error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="login-wed-lex1-form-group">
                            <label for="password_confirmation" class="login-wed-lex1-label">Confirm password <span class="login-wed-lex1-required">*</span></label>
                            <div class="login-wed-lex1-password-wrapper">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="login-wed-lex1-input" placeholder="Password" required>
                                <span class="login-wed-lex1-password-toggle" onclick="togglePassword('password_confirmation')">
                                    <svg class="login-wed-lex1-eye-icon login-wed-lex1-eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 12C1 12 5 4 12 4C19 4 23 12 23 12C23 12 19 20 12 20C5 20 1 12 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <svg class="login-wed-lex1-eye-icon login-wed-lex1-eye-closed" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                        <path d="M17.94 17.94C16.2306 19.243 14.1491 19.9649 12 20C5 20 1 12 1 12C2.24389 9.68192 3.96914 7.65663 6.06 6.06M9.9 4.24C10.5883 4.0789 11.2931 3.99836 12 4C19 4 23 12 23 12C22.393 13.1356 21.6691 14.2048 20.84 15.19M14.12 14.12C13.8454 14.4148 13.5141 14.6512 13.1462 14.8151C12.7782 14.9791 12.3809 15.0673 11.9781 15.0744C11.5753 15.0815 11.1751 15.0074 10.8016 14.8565C10.4281 14.7056 10.0887 14.4811 9.80385 14.1962C9.51897 13.9113 9.29439 13.5719 9.14351 13.1984C8.99262 12.8249 8.91853 12.4247 8.92563 12.0219C8.93274 11.6191 9.02091 11.2218 9.18488 10.8538C9.34884 10.4859 9.58525 10.1546 9.88 9.88M1 1L23 23" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="login-wed-lex1-submit-btn">Sign up</button>

                        <!-- Sign In Link -->
                        <div class="login-wed-lex1-signup-wrapper">
                            <p class="login-wed-lex1-signup-text">Already have an account ? <a href="{{ route('login') }}" class="login-wed-lex1-signup-link">Sign in</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const wrapper = input.closest('.login-wed-lex1-password-wrapper');
    const eyeOpen = wrapper.querySelector('.login-wed-lex1-eye-open');
    const eyeClosed = wrapper.querySelector('.login-wed-lex1-eye-closed');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
    } else {
        input.type = 'password';
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
    }
}

// Page Loader - Hide after 1.5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const loader = document.getElementById('pageLoader');
    const mainContent = document.getElementById('mainContent');
    
    setTimeout(function() {
        if (loader) {
            loader.style.opacity = '0';
            loader.style.transition = 'opacity 0.5s ease-out';
            
            setTimeout(function() {
                loader.style.display = 'none';
                if (mainContent) {
                    mainContent.style.display = 'block';
                }
            }, 500);
        } else if (mainContent) {
            mainContent.style.display = 'block';
        }
    }, 1500); // 1.5 seconds
});
</script>
@endpush
@endsection
