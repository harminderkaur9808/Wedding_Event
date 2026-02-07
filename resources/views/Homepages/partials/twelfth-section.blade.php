<section class="wedding-mele-twelfth-section">
    <!-- Background Image - Full Width (same design as tenth) -->
    <div class="wedding-mele-twelfth-bg" aria-hidden="true">
        <img src="{{ asset('Images/Home/tenthsecimg/Sehra-Surma-Ceremony.png') }}" alt="" class="wedding-mele-twelfth-bg-image">
    </div>

    <div class="container">
        <div class="wedding-mele-twelfth-content">
            <!-- Header -->
            <div class="wedding-mele-twelfth-header wm-reveal" style="--reveal-delay: 0ms;">
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
                <div class="wedding-mele-twelfth-left wm-reveal wm-reveal--left" style="--reveal-delay: 220ms;">
                    <div class="wedding-mele-twelfth-details">
                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">Reception: <span>{{ $twelfth?->getExtra('date') ?? '1/2/2027' }}</span></span>
                        </div>

                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">Venue: <span>{{ $twelfth?->getExtra('venue') ?? 'Park Hyatt Aviara Resort-760-448-1234' }}</span></span>
                        </div>

                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="Address" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">Address: <span>{{ $twelfth?->getExtra('address') ?? '7100 Aviara Resort Drive, Carlsbad CA 92011' }}</span></span>
                        </div>

                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/time_svg_fifth.svg') }}" alt="Time" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">Time: <span>{{ $twelfth?->getExtra('time') ?? '6 pm onwards' }}</span></span>
                        </div>

                        {{-- Dress code and Dress code subtext removed for twelfth section
                        <div class="wedding-mele-twelfth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="Dress Code" class="wedding-mele-twelfth-detail-icon">
                            <span class="wedding-mele-twelfth-detail-text">
                                Dress Code: <span>{{ $twelfth?->getExtra('dress_code') ?? 'Indian traditional outfits' }}</span>
                                <span class="wedding-mele-twelfth-detail-subtext">{{ $twelfth?->getExtra('dress_code_subtext') ?? 'Men: Formals. Women: any color' }}</span>
                            </span>
                        </div>
                        --}}
                    </div>
                </div>

                <!-- Right: Image with board (clip) on it -->
                <div class="wedding-mele-twelfth-right wm-reveal wm-reveal--right" style="--reveal-delay: 260ms;">
                    <div class="wedding-mele-twelfth-image-wrapper">
                        @php $twelfthImg = $twelfth?->getExtra('image'); @endphp
                        <img src="{{ $twelfthImg ? secure_media_url($twelfthImg) : asset('Images/Home/eleventhsecimg/wedding_img_sec_last.png') }}" alt="Reception" class="wedding-mele-twelfth-image">
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
