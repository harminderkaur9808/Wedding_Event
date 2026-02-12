<header class="wedding-header">
    <!-- Top Header -->
    <div class="top-header">
        <div class="container">
            <div class="top-header-content">
                <div class="top-header-left">
                    <span class="top-header-countdown-title">Countdown to Wedding</span>
                    <div class="top-header-countdown-wrapper" id="header-wedding-countdown" data-wedding-date="{{ $headerWeddingDateIso ?? '2027-01-01T12:00:00' }}">
                        <div class="top-header-countdown-box">
                            <span class="top-header-countdown-number" id="header-days">0</span>
                            <span class="top-header-countdown-label">Days</span>
                        </div>
                    </div>
                </div>
                <div class="top-header-center">
                    <span class="save-date-text">Save The Date</span>
                    <div class="date-section">
                        <img src="{{ asset('Images/Header/Calender_imghader.png') }}" alt="Calendar" class="calendar-icon">
                        <span class="wedding-date">{{ $headerWeddingDate ?? '01-01-2027' }}</span>
                    </div>
                </div>
                <div class="top-header-right">
                    @auth
                        <div class="user-welcome-section">
                            <span class="welcome-text">Welcome, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                            @if(Auth::user()->profile_image)
                                <img src="{{ secure_media_url('profile_images/' . Auth::user()->profile_image) }}" alt="Profile" class="header-profile-img">
                            @else
                                <div class="header-profile-initials">{{ strtoupper(substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1)) }}</div>
                            @endif
                            <div class="user-dropdown">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">Admin Dashboard</a>
                                @else
                                    <a href="{{ route('user.dashboard') }}" class="dropdown-item">My Dashboard</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST" class="dropdown-form">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout-btn">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="login-btn">
                            <img src="{{ asset('Images/Header/Login-Ico.png') }}" alt="Login" class="login-icon">
                            <span>Login</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
        <div class="container">
            <nav class="navbar navbar-expand-xl navbar-light p-0">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('Images/Header/weeding_logo.png') }}" alt="Wedding Logo" class="wedding-logo">
                </a>

                <!-- Mobile/Tablet Menu Toggle Button (hidden on desktop 1025px+) -->
                <button class="navbar-toggler d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="header-right ms-auto d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                        <nav class="main-nav d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <a href="{{ route('pictures_videos') }}" class="nav-link {{ request()->routeIs('pictures_videos') ? 'active' : '' }}">Pictures and Videos</a>
                            <a href="{{ route('ask.the.host') }}" class="nav-link {{ request()->routeIs('ask.the.host') ? 'active' : '' }}">Ask the Host</a>
                            <a href="{{ route('updates.by.family') }}" class="nav-link {{ request()->routeIs('updates.by.family') ? 'active' : '' }}">Updates by family</a>
                            <a href="{{ route('local.attractions') }}" class="nav-link {{ request()->routeIs('local.attractions') ? 'active' : '' }}">Local Attractions</a>
                            <a href="{{ route('important.notification') }}" class="nav-link {{ request()->routeIs('important.notification') ? 'active' : '' }}">Travel & Accommodation</a>
                        </nav>
                        <a href="{{ route('book.appointments') }}" 
                           class="book-appointment-btn mt-3 mt-lg-0 ms-lg-3"
                           style="z-index: 9999 !important; pointer-events: auto !important; text-decoration: none !important; cursor: pointer !important;">
                           Book your appointments
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
