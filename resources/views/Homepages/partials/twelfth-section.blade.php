<section class="wedding-mele-twelfth-section">
    <!-- Background Image - Full Width (same design as tenth) -->
    <div class="wedding-mele-twelfth-bg" aria-hidden="true">
        <img src="{{ asset('Images/Home/tenthsecimg/Sehra%20%26%20Surma%20Ceremony_bg.png') }}" alt="" class="wedding-mele-twelfth-bg-image">
    </div>

    <div class="container">
        <div class="wedding-mele-twelfth-content">
            <!-- Header -->
            <div class="wedding-mele-twelfth-header">
                @php $twelfth = $sections['twelfth'] ?? null; @endphp
                <h3 class="wedding-mele-twelfth-subtitle">{{ $twelfth?->subtitle ?? 'Celebration' }}</h3>
                <div class="wedding-mele-twelfth-between">
                    <img src="{{ asset('Images/Home/tenthsecimg/betweebtxtico_frame.svg') }}" alt="Decorative Element" class="wedding-mele-twelfth-between-img">
                </div>
                <h2 class="wedding-mele-twelfth-title">{{ $twelfth?->title ?? 'Reception' }}</h2>
            </div>

            <!-- Main -->
            <div class="wedding-mele-twelfth-main">
                <!-- Left: Details -->
                <div class="wedding-mele-twelfth-left">
                    <div class="wedding-mele-twelfth-details">
                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">Reception: {{ $twelfth?->getExtra('date') ?? '1/2/2027' }}</span>
                        </div>

                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">Venue: {{ $twelfth?->getExtra('venue') ?? 'Park Hyatt Aviara Resort-760-448-1234' }}</span>
                        </div>

                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="Address" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">Address: {{ $twelfth?->getExtra('address') ?? '7100 Aviara Resort Drive, Carlsbad CA 92011' }}</span>
                        </div>

                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/time_svg_fifth.svg') }}" alt="Time" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">Time: {{ $twelfth?->getExtra('time') ?? '6 pm onwards' }}</span>
                        </div>

                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="Dress Code" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">
                                Dress Code: {{ $twelfth?->getExtra('dress_code') ?? 'Indian traditional outfits' }}
                                <span class="wedding-mele-twelfth-detail-subtext">{{ $twelfth?->getExtra('dress_code_subtext') ?? 'Men: Formals. Women: any color' }}</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Right: Image with board (clip) on it -->
                <div class="wedding-mele-twelfth-right">
                    <div class="wedding-mele-twelfth-image-wrapper">
                        @php $twelfthImg = $twelfth?->getExtra('image'); @endphp
                        <img src="{{ $twelfthImg ? asset('storage/' . $twelfthImg) : asset('Images/Home/tenthsecimg/Sehra%20%26%20Surma%20Ceremony.png') }}" alt="Reception" class="wedding-mele-twelfth-image">
                        <!-- Board / clip on image + date text (same as tenth) -->
                        <div class="wedding-mele-twelfth-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="" class="wedding-mele-twelfth-dynamic-board">
                            <div class="wedding-mele-twelfth-board-date-text" aria-label="Event date">
                                @php
                                    $boardDate = $twelfth?->getBoardDateFormatted();
                                @endphp
                                <span class="wedding-mele-twelfth-board-line1">
                                    <span class="wedding-mele-twelfth-board-day">{{ ($boardDate ?? [])['day'] ?? '2' }}</span> <span class="wedding-mele-twelfth-board-month">{{ ($boardDate ?? [])['month'] ?? 'Jan' }}</span>
                                </span>
                                <span class="wedding-mele-twelfth-board-year">{{ ($boardDate ?? [])['year'] ?? '2027' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
