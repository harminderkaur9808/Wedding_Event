<section class="wedding-mele-fourth-section">
    <div class="container">
        <div class="wedding-mele-fourth-content">
            <!-- Header Section -->
            <div class="wedding-mele-fourth-header wm-reveal" style="--reveal-delay: 0ms;">
                @php $fourth = $sections['fourth'] ?? null; @endphp
                <h3 class="wedding-mele-blessings-text">{{ $fourth?->subtitle ?? 'With Blessings' }}</h3>
                <div class="wedding-mele-fourth-decorative">
                    <img src="{{ asset('Images/Home/Forth_sec/between_txtframe.png') }}" alt="Decorative Element" class="wedding-mele-fourth-decorative-img">
                </div>
                <h2 class="wedding-mele-shagun-text">{{ $fourth?->title ?? 'Shagun' }}</h2>
            </div>

            <!-- Main Invitation Box -->
            <div class="wedding-mele-invitation-box wm-reveal wm-reveal--scale" style="--reveal-delay: 120ms;">
                <!-- Background Image Inside Box -->
                <div class="wedding-mele-invitation-bg">
                    <img src="{{ asset('Images/Home/Forth_sec/Foth_sbg_home.png') }}" alt="Background" class="wedding-mele-invitation-bg-image">
                </div>
                <!-- Left Section - Text Content -->
                <div class="wedding-mele-invitation-left wm-reveal wm-reveal--left" style="--reveal-delay: 220ms;">
                    <h1 class="wedding-mele-invitation-title">Invitation</h1>
                    <p class="wedding-mele-invitation-intro">{{ $fourth?->short_description ?? 'We inviting you and your family on' }}</p>
                    
                    <div class="wedding-mele-invitation-details">
                        <div class="wedding-mele-detail-item">
                            <img
                                src="{{ asset('Images/Home/Forth_sec/ico/Dress_code_icon_0.svg') }}"
                                alt="Dress Code"
                                class="wedding-mele-detail-icon"
                            >
                            <span class="wedding-mele-detail-text">Dress Code: <span>{{ $fourth?->getExtra('dress_code') ?? 'Traditional Outfits' }}</span></span>
                        </div>
                        
                        <div class="wedding-mele-detail-item">
                            <img
                                src="{{ asset('Images/Home/Forth_sec/ico/Mask%20group.svg') }}"
                                alt="Date"
                                class="wedding-mele-detail-icon"
                            >
                            <span class="wedding-mele-detail-text">Date: <span>{{ $fourth?->getExtra('date') ?? '2/21/2026' }}</span></span>
                        </div>
                        
                        <div class="wedding-mele-detail-item">
                            <img
                                src="{{ asset('Images/Home/Forth_sec/ico/timer_icon_0.svg') }}"
                                alt="Time"
                                class="wedding-mele-detail-icon"
                            >
                            <span class="wedding-mele-detail-text">Time: <span>{{ $fourth?->getExtra('time') ?? '9 am - 12 pm' }}</span></span>
                        </div>
                        
                        <div class="wedding-mele-detail-item">
                            <img
                                src="{{ asset('Images/Home/Forth_sec/ico/venue_ico_0.svg') }}"
                                alt="Venue"
                                class="wedding-mele-detail-icon"
                            >
                            <span class="wedding-mele-detail-text">Venue: <span>{{ $fourth?->getExtra('venue') ?? 'Phoenix AZ' }}</span></span>
                        </div>
                    </div>
                </div>

                <!-- Right Section - Image with board on it -->
                <div class="wedding-mele-invitation-right wm-reveal wm-reveal--right" style="--reveal-delay: 260ms;">
                    <div class="wedding-mele-right-image-wrapper">
                        @php $fourthImg = $fourth?->getExtra('image'); @endphp
                        <img src="{{ $fourthImg ? secure_media_url($fourthImg) : asset('Images/Home/Forth_sec/Foth_sec_right_frame.png') }}" alt="Couple" class="wedding-mele-right-image">
                        <!-- Board / clip on image + date text (same as other sections) -->
                        <div class="wedding-mele-fourth-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="" class="wedding-mele-fourth-dynamic-board">
                            <div class="wedding-mele-fourth-board-date-text" aria-label="Event date">
                                @php
                                    $boardDate = $fourth?->getBoardDateFormatted();
                                @endphp
                                <span class="wedding-mele-fourth-board-line1">
                                    <span class="wedding-mele-fourth-board-day">{{ ($boardDate ?? [])['day'] ?? '21' }}</span> <span class="wedding-mele-fourth-board-month">{{ ($boardDate ?? [])['month'] ?? 'Feb' }}</span>
                                </span>
                                <span class="wedding-mele-fourth-board-year">{{ ($boardDate ?? [])['year'] ?? '2026' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
