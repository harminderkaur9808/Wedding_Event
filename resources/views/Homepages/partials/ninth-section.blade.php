<section class="wedding-mele-ninth-section">
    <div class="container">
        <div class="wedding-mele-ninth-content">
            <!-- Header -->
            <div class="wedding-mele-ninth-header wm-reveal" style="--reveal-delay: 0ms;">
                @php $ninth = $sections['ninth'] ?? null; @endphp
                <h3 class="wedding-mele-ninth-subtitle">{{ $ninth?->subtitle ?? 'Full Magic' }}</h3>
                <div class="wedding-mele-ninth-between">
                    <img src="{{ asset('Images/Home/ninthSec/betweebtxtico_frame.svg') }}" alt="Decorative Element" class="wedding-mele-ninth-between-img">
                </div>
                <h2 class="wedding-mele-ninth-title">{!! nl2br(e($ninth?->title ?? "Jaggo, Gidha and\nBhangra Night")) !!}</h2>
            </div>

            <!-- Main -->
            <div class="wedding-mele-ninth-main">
                <!-- Left: Details -->
                <div class="wedding-mele-ninth-left wm-reveal wm-reveal--left" style="--reveal-delay: 220ms;">
                    <div class="wedding-mele-ninth-details">
                        <div class="wedding-mele-ninth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-ninth-detail-icon">
                            <span class="wedding-mele-ninth-detail-text">Date: <span>{{ $ninth?->getDateDisplayString() ?? '28 Feb 2026' }}</span></span>
                        </div>

                        <div class="wedding-mele-ninth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/time_svg_fifth.svg') }}" alt="Time" class="wedding-mele-ninth-detail-icon">
                            <span class="wedding-mele-ninth-detail-text">Time: <span>{{ $ninth?->getExtra('time') ?? '6 pm to midnight' }}</span></span>
                        </div>

                        <div class="wedding-mele-ninth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-ninth-detail-icon">
                            <span class="wedding-mele-ninth-detail-text">Venue: <span>{{ $ninth?->getExtra('venue') ?? 'Park Hyatt Aviara Resort-760-448-1234' }}</span></span>
                        </div>

                        <div class="wedding-mele-ninth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="Dress Code" class="wedding-mele-ninth-detail-icon">
                            <span class="wedding-mele-ninth-detail-text">Dress Code: <span>{{ $ninth?->getExtra('dress_code') ?? 'Indian Traditional Outfits' }}</span></span>
                        </div>

                        <div class="wedding-mele-ninth-detail-item">
                            <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="Address" class="wedding-mele-ninth-detail-icon">
                            <span class="wedding-mele-ninth-detail-text">Address: <span>{{ $ninth?->getExtra('address') ?? '7100 Aviara Resort Drive, Carlsbad CA 92011' }}</span></span>
                        </div>
                    </div>

                    <div class="wedding-mele-ninth-entertainment">
                        <div class="wedding-mele-ninth-entertainment-grid">
                            <div class="wedding-mele-ninth-entertainment-col wedding-mele-ninth-entertainment-col--entertainment">
                                <div class="wedding-mele-ninth-entertainment-title">Entertainment</div>
                                <div class="wedding-mele-ninth-nameplate">
                                    <img src="{{ asset('Images/Home/ninthSec/Entertainment_nameplate.svg') }}" alt="" class="wedding-mele-ninth-nameplate-bg" aria-hidden="true">
                                    <span class="wedding-mele-ninth-nameplate-text">{{ $ninth?->getExtra('entertainment_mc') ?? 'MC: Herman Kahlon' }}</span>
                                </div>
                            </div>

                            <div class="wedding-mele-ninth-entertainment-col wedding-mele-ninth-entertainment-col--performance">
                                <div class="wedding-mele-ninth-entertainment-title">Performance :</div>
                                <div class="wedding-mele-ninth-nameplate">
                                    <img src="{{ asset('Images/Home/ninthSec/Performance_nameplate.svg') }}" alt="" class="wedding-mele-ninth-nameplate-bg" aria-hidden="true">
                                    <span class="wedding-mele-ninth-nameplate-text">{{ $ninth?->getExtra('performance_text') ?? 'Giddha by family members' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Image with board on it -->
                <div class="wedding-mele-ninth-right wm-reveal wm-reveal--right" style="--reveal-delay: 260ms;">
                    <div class="wedding-mele-ninth-image-wrapper">
                        @php $ninthImg = $ninth?->getExtra('image'); @endphp
                        <img src="{{ $ninthImg ? asset('storage/' . $ninthImg) : asset('Images/Home/ninthSec/Jaggo_Gidha%20_and_Bhangra_Night.png') }}" alt="Jaggo, Gidha and Bhangra Night" class="wedding-mele-ninth-image">
                        <!-- Board on image + date text (same as Vatna / Mehndi / Sangeet) -->
                        <div class="wedding-mele-ninth-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="" class="wedding-mele-ninth-dynamic-board">
                            <div class="wedding-mele-ninth-board-date-text" aria-label="Event date">
                                @php
                                    $boardDate = $ninth?->getBoardDateFormatted();
                                @endphp
                                <span class="wedding-mele-ninth-board-line1">
                                    <span class="wedding-mele-ninth-board-day">{{ ($boardDate ?? [])['day'] ?? '28' }}</span> <span class="wedding-mele-ninth-board-month">{{ ($boardDate ?? [])['month'] ?? 'Feb' }}</span>
                                </span>
                                <span class="wedding-mele-ninth-board-year">{{ ($boardDate ?? [])['year'] ?? '2026' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

