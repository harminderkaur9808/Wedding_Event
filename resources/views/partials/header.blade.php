<header class="wedding-header">
    <!-- Top Header -->
    <div class="top-header">
        <div class="container">
            <div class="top-header-content">
                <div class="top-header-left">
                    <span class="save-date-text">Save The Date</span>
                    <div class="date-section">
                        <img src="{{ asset('Images/Header/Calender_imghader.png') }}" alt="Calendar" class="calendar-icon">
                        <span class="wedding-date">12-31-2026</span>
                    </div>
                </div>
                <div class="top-header-right">
                    <a href="{{ route('login') }}" class="login-btn">
                        <img src="{{ asset('Images/Header/Login-Ico.png') }}" alt="Login" class="login-icon">
                        <span>Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <!-- Logo -->
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('Images/Header/weeding_logo.png') }}" alt="Wedding Logo" class="wedding-logo">
                </a>

                <!-- Mobile Menu Toggle Button -->
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="header-right ms-auto d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                        <nav class="main-nav d-flex flex-column flex-lg-row align-items-start align-items-lg-center">
                            <a href="#" class="nav-link">Pictures and Videos</a>
                            <a href="#" class="nav-link">Ask the Host</a>
                            <a href="#" class="nav-link">Updates by family</a>
                            <a href="#" class="nav-link">Lets Plan Our Outfits</a>
                        </nav>
                        <button class="book-appointment-btn mt-3 mt-lg-0 ms-lg-3">Book your appointments</button>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
