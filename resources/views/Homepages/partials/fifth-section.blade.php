<section class="wedding-mele-fifth-section">
    <!-- Background Image - Full Width -->
    <div class="wedding-mele-fifth-bg">
        <img src="{{ asset('Images/Home/fifthsec/Fifthsection_bg_home.png') }}" alt="Background" class="wedding-mele-fifth-bg-image">
    </div>

    <div class="container">
        <div class="wedding-mele-fifth-content">
            <!-- Header Section -->
            <div class="wedding-mele-fifth-header">
                @php $fifth = $sections['fifth'] ?? null; @endphp
                <h3 class="wedding-mele-sacred-ritual-text">{{ $fifth?->subtitle ?? 'Sacred Ritual' }}</h3>
                <div class="wedding-mele-fifth-decorative">
                    <img src="{{ asset('Images/Home/fifthsec/Fifthsection_betweenimg_framer.png') }}" alt="Decorative Element" class="wedding-mele-fifth-decorative-img">
                </div>
                <h2 class="wedding-mele-vatna-text">{{ $fifth?->title ?? 'Vatna' }}</h2>
            </div>

            <!-- Main Content Box -->
            <div class="wedding-mele-fifth-main-box">

                <!-- Left Section - Main image with board attached -->
                <div class="wedding-mele-fifth-left">
                    <div class="wedding-mele-vatna-image-wrapper">
                        @php $fifthImg = $fifth?->getExtra('image'); @endphp
                        <img src="{{ $fifthImg ? asset('storage/' . $fifthImg) : asset('Images/Home/fifthsec/Fifthsection_Vatna _framer.png') }}" alt="Vatna Ceremony" class="wedding-mele-vatna-image">
                        <!-- wedding-mele-fifth-board-on-image: board image first, then date text under it -->
                        <div class="wedding-mele-fifth-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="Date board" class="wedding-mele-fifth-dynamic-board">
                            <div class="wedding-mele-fifth-board-date-text" aria-label="Event date">
                                @php
                                    $boardDate = $fifth?->getBoardDateFormatted();
                                @endphp
                                <span class="wedding-mele-fifth-board-line1">
                                    <span class="wedding-mele-fifth-board-day">{{ ($boardDate ?? [])['day'] ?? '25' }}</span> <span class="wedding-mele-fifth-board-month">{{ ($boardDate ?? [])['month'] ?? 'Feb' }}</span>
                                </span>
                                <span class="wedding-mele-fifth-board-year">{{ ($boardDate ?? [])['year'] ?? '2026' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section - Event Details -->
                <div class="wedding-mele-fifth-right">
                    <div class="wedding-mele-fifth-details">
                        <div class="wedding-mele-fifth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-fifth-detail-icon">
                            <span class="wedding-mele-fifth-detail-text">Date: {{ $fifth?->getExtra('date') ?? '2/25/2026' }}</span>
                        </div>
                        
                        <div class="wedding-mele-fifth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/time_svg_fifth.svg') }}" alt="Time" class="wedding-mele-fifth-detail-icon">
                            <span class="wedding-mele-fifth-detail-text">Time: {{ $fifth?->getExtra('time') ?? '9 am - 12 pm' }}</span>
                        </div>
                        
                        <div class="wedding-mele-fifth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-fifth-detail-icon">
                            <span class="wedding-mele-fifth-detail-text">Venue: {{ $fifth?->getExtra('venue') ?? 'Phoenix AZ' }}</span>
                        </div>
                        
                        <div class="wedding-mele-fifth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="Dress Code" class="wedding-mele-fifth-detail-icon">
                            <span class="wedding-mele-fifth-detail-text">Dress Code: {{ $fifth?->getExtra('dress_code') ?? 'Casual Indian Orange Yellow, Green Colors' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
