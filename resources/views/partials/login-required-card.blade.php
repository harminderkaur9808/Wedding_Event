{{-- Shared "Login required" card – same UI for Pictures & Videos, Ask the Host, Updates by Family, Local Attractions --}}
<section class="login-gate-section">
    <div class="login-gate-card">
        <div class="login-gate-icon" aria-hidden="true">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M7 11V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2 class="login-gate-title">{{ $title ?? 'Login required' }}</h2>
        <p class="login-gate-message">{{ $message }}</p>
        <a href="{{ route('login', ['intended' => url()->current()]) }}" class="login-gate-btn">Go to Login</a>
    </div>
</section>
