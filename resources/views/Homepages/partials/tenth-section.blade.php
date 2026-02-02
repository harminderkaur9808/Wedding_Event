<section class="wedding-mele-tenth-section">
    <!-- Background Image - Full Width -->
    <div class="wedding-mele-tenth-bg" aria-hidden="true">
        <img src="{{ asset('Images/Home/tenthsecimg/Sehra%20%26%20Surma%20Ceremony_bg.png') }}" alt="" class="wedding-mele-tenth-bg-image">
    </div>

    <div class="container">
        <div class="wedding-mele-tenth-content">
            <!-- Header -->
            <div class="wedding-mele-tenth-header">
                @php $tenth = $sections['tenth'] ?? null; @endphp
                <h3 class="wedding-mele-tenth-subtitle">{{ $tenth?->subtitle ?? 'Cultural Elegance' }}</h3>
                <div class="wedding-mele-tenth-between">
                    <img src="{{ asset('Images/Home/tenthsecimg/betweebtxtico_frame.svg') }}" alt="Decorative Element" class="wedding-mele-tenth-between-img">
                </div>
                <h2 class="wedding-mele-tenth-title">{{ $tenth?->title ?? 'Sehra & Surma Ceremony' }}</h2>
            </div>

            <!-- Main -->
            <div class="wedding-mele-tenth-main">
                <!-- Left: Details -->
                <div class="wedding-mele-tenth-left">
                    <div class="wedding-mele-tenth-details">
                        <div class="wedding-mele-tenth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-tenth-detail-icon">
                            <span class="wedding-mele-tenth-detail-text">Date: {{ $tenth?->getExtra('date') ?? '12-31-2026' }}</span>
                        </div>

                        <div class="wedding-mele-tenth-detail-item">
                            <img src="{{ asset('Images/Home/tenthsecimg/TurbanTying_icon.svg') }}" alt="Turban Tying" class="wedding-mele-tenth-detail-icon">
                            <span class="wedding-mele-tenth-detail-text">Turban Tying: {{ $tenth?->getExtra('turban_tying') ?? 'At 7 am' }}</span>
                        </div>

                        <div class="wedding-mele-tenth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-tenth-detail-icon">
                            <span class="wedding-mele-tenth-detail-text">Venue: {{ $tenth?->getExtra('venue') ?? 'Hopitality Room' }}</span>
                        </div>

                        <div class="wedding-mele-tenth-detail-item">
                            <img src="{{ asset('Images/Home/tenthsecimg/Barat_leaves_ico.svg') }}" alt="Barat leaves" class="wedding-mele-tenth-detail-icon">
                            <span class="wedding-mele-tenth-detail-text">Barat leaves: {{ $tenth?->getExtra('barat_leaves') ?? 'Indian Traditional Outfits' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Image with board (clip) on it -->
                <div class="wedding-mele-tenth-right">
                    <div class="wedding-mele-tenth-image-wrapper">
                        @php $tenthImg = $tenth?->getExtra('image'); @endphp
                        <img src="{{ $tenthImg ? asset('storage/' . $tenthImg) : asset('Images/Home/tenthsecimg/Sehra%20%26%20Surma%20Ceremony.png') }}" alt="Sehra & Surma Ceremony" class="wedding-mele-tenth-image">
                        <!-- Board / clip on image + date text (same as other sections) -->
                        <div class="wedding-mele-tenth-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="" class="wedding-mele-tenth-dynamic-board">
                            <div class="wedding-mele-tenth-board-date-text" aria-label="Event date">
                                @php
                                    $boardDate = $tenth?->getBoardDateFormatted();
                                @endphp
                                <span class="wedding-mele-tenth-board-line1">
                                    <span class="wedding-mele-tenth-board-day">{{ ($boardDate ?? [])['day'] ?? '31' }}</span> <span class="wedding-mele-tenth-board-month">{{ ($boardDate ?? [])['month'] ?? 'Dec' }}</span>
                                </span>
                                <span class="wedding-mele-tenth-board-year">{{ ($boardDate ?? [])['year'] ?? '2026' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

