    <section class="wedding-mele-seventh-section">
    <!-- Background Image - Full Width -->
    <div class="wedding-mele-seventh-bg" aria-hidden="true">
        <img src="{{ asset('Images/Home/Seven_sec_img/Sangeet_seven_bg.png') }}" alt="" class="wedding-mele-seventh-bg-image">
    </div>

    <div class="container">
        <div class="wedding-mele-seventh-content">
            <!-- Header -->
            <div class="wedding-mele-seventh-header wm-reveal" style="--reveal-delay: 0ms;">
                @php $seventh = $sections['seventh'] ?? null; @endphp
                <h3 class="wedding-mele-seventh-subtitle">{{ $seventh?->subtitle ?? 'Musical Vibes' }}</h3>
                <div class="wedding-mele-seventh-between">
                    <img src="{{ asset('Images/Home/Seven_sec_img/betweebtxtico_frame.svg') }}" alt="Decorative Element" class="wedding-mele-seventh-between-img">
                </div>
                <h2 class="wedding-mele-seventh-title">{{ $seventh?->title ?? 'Sangeet Night' }}</h2>
                @if($seventh?->short_description)
                    <p class="wedding-mele-section-description">{{ $seventh->short_description }}</p>
                @endif
            </div>

            <!-- Main -->
            <div class="wedding-mele-seventh-main">
                <!-- Left: Image with board on it -->
                <div class="wedding-mele-seventh-left wm-reveal wm-reveal--left" style="--reveal-delay: 220ms;">
                    <div class="wedding-mele-seventh-image-wrapper">
                        @php $seventhImg = $seventh?->getExtra('image'); @endphp
                        <img src="{{ $seventhImg ? secure_media_url($seventhImg) : asset('Images/Home/Seven_sec_img/Sangeet_seven_sec_img.png') }}" alt="Sangeet Night" class="wedding-mele-seventh-image">
                        <!-- Board on image + date text under it (like Vatna section) -->
                        <div class="wedding-mele-seventh-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="" class="wedding-mele-seventh-dynamic-board">
                            <div class="wedding-mele-seventh-board-date-text" aria-label="Event date">
                                @php
                                    $boardDate = $seventh?->getBoardDateFormatted();
                                @endphp
                                <span class="wedding-mele-seventh-board-line1">
                                    <span class="wedding-mele-seventh-board-day">{{ ($boardDate ?? [])['day'] ?? '26' }}</span> <span class="wedding-mele-seventh-board-month">{{ ($boardDate ?? [])['month'] ?? 'Feb' }}</span>
                                </span>
                                <span class="wedding-mele-seventh-board-year">{{ ($boardDate ?? [])['year'] ?? '2026' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Details -->
                <div class="wedding-mele-seventh-right wm-reveal wm-reveal--right" style="--reveal-delay: 260ms;">
                    <div class="wedding-mele-seventh-details">
                        <div class="wedding-mele-seventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-seventh-detail-icon">
                            <span class="wedding-mele-seventh-detail-text">Date: <span>{{ $seventh?->getExtra('date') ?? '2-26-2026' }}</span></span>
                        </div>

                        <div class="wedding-mele-seventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/time_svg_fifth.svg') }}" alt="Time" class="wedding-mele-seventh-detail-icon">
                            <span class="wedding-mele-seventh-detail-text">Time: <span>{{ $seventh?->getExtra('time') ?? '6pm - midnight' }}</span></span>
                        </div>

                        <div class="wedding-mele-seventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-seventh-detail-icon">
                            <span class="wedding-mele-seventh-detail-text">Venue: <span>{{ $seventh?->getExtra('venue') ?? 'Jasmine and Mannttej Residence' }}</span></span>
                        </div>

                        <div class="wedding-mele-seventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="Dress Code" class="wedding-mele-seventh-detail-icon">
                            <span class="wedding-mele-seventh-detail-text">Dress Code: <span>{{ $seventh?->getExtra('dress_code') ?? 'Indian. Outside venue. Be warm and comfortable' }}</span></span>
                        </div>

                        <div class="wedding-mele-seventh-detail-item">
                            <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="Address" class="wedding-mele-seventh-detail-icon">
                            <span class="wedding-mele-seventh-detail-text">Address: <span>{{ $seventh?->getExtra('address') ?? '4608 W El Cortez Pl, Phoenix AZ 85083' }}</span></span>
                        </div>
                    </div>

                    <div class="wedding-mele-seventh-entertainment">
                        <div class="wedding-mele-seventh-entertainment-title">Entertainment</div>
                        <div class="wedding-mele-seventh-nameplate-wrap">
                            <img src="{{ asset('Images/Home/Seven_sec_img/name_frame_sev_sec.svg') }}" alt="" class="wedding-mele-seventh-nameplate" aria-hidden="true">
                            <span class="wedding-mele-seventh-nameplate-text">{{ $seventh?->getExtra('entertainment_mc') ?? 'MC: Jastej Sra' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
