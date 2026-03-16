<section class="wedding-mele-sixth-section">
    <!-- Decorative Side SVGs -->
    <div class="wedding-mele-sixth-decor wedding-mele-sixth-decor-left" aria-hidden="true">
        <img src="{{ asset('Images/Home/sixthSec/left_decor_img.svg') }}" alt="" class="wedding-mele-sixth-decor-img">
    </div>
    <div class="wedding-mele-sixth-decor wedding-mele-sixth-decor-right" aria-hidden="true">
        <img src="{{ asset('Images/Home/sixthSec/right_decor_img.svg') }}" alt="" class="wedding-mele-sixth-decor-img">
    </div>

    <div class="container">
        <div class="wedding-mele-sixth-content">
            <!-- Header -->
            <div class="wedding-mele-sixth-header wm-reveal" style="--reveal-delay: 0ms;">
                @php $sixth = $sections['sixth'] ?? null; @endphp
                <h3 class="wedding-mele-colorful-vibes-text">{{ $sixth?->subtitle ?? 'Colorful Vibes' }}</h3>
                <div class="wedding-mele-sixth-between">
                    <img src="{{ asset('Images/Home/sixthSec/betweebtxt_img_0.svg') }}" alt="Decorative Element" class="wedding-mele-sixth-between-img">
                </div>
                <h2 class="wedding-mele-mehndi-text">{{ $sixth?->title ?? 'Mehndi' }}</h2>
                @if($sixth?->short_description)
                    <div class="wedding-mele-section-description">{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $sixth->short_description))) !!}</div>
                @endif
            </div>

            <!-- Main box -->
            <div class="wedding-mele-sixth-main-box">
                <!-- Left: Details -->
                <div class="wedding-mele-sixth-left wm-reveal wm-reveal--left" style="--reveal-delay: 220ms;">
                    <div class="wedding-mele-sixth-details">
                        <div class="wedding-mele-sixth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-sixth-detail-icon">
                            <span class="wedding-mele-sixth-detail-text">Date: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $sixth?->getExtra('date') ?? '2-25-2026'))) !!}</span></span>
                        </div>
                        <div class="wedding-mele-sixth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/time_svg_fifth.svg') }}" alt="Time" class="wedding-mele-sixth-detail-icon">
                            <span class="wedding-mele-sixth-detail-text">Time: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $sixth?->getExtra('time') ?? '4 - 7 pm'))) !!}</span></span>
                        </div>
                        <div class="wedding-mele-sixth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-sixth-detail-icon">
                            <span class="wedding-mele-sixth-detail-text">Venue: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $sixth?->getExtra('venue') ?? 'Ramit and Maninder Residence'))) !!}</span></span>
                        </div>
                        <div class="wedding-mele-sixth-detail-item">
                            <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="Address" class="wedding-mele-sixth-detail-icon">
                            <span class="wedding-mele-sixth-detail-text">Address: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $sixth?->getExtra('address') ?? '20865 N. 109th Place, Scottsdale AZ'))) !!}</span></span>
                        </div>
                        <div class="wedding-mele-sixth-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="Dress Code" class="wedding-mele-sixth-detail-icon">
                            <span class="wedding-mele-sixth-detail-text">Dress Code: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $sixth?->getExtra('dress_code') ?? 'Casual Indian Orange Yellow, Green Colors'))) !!}</span></span>
                        </div>
                        @if(trim((string)($sixth?->getExtra('note') ?? '')) !== '')
                        <div class="wedding-mele-sixth-detail-item">
                            <img src="{{ asset('Images/Home/note_icon.svg') }}" alt="Note" class="wedding-mele-sixth-detail-icon">
                            <span class="wedding-mele-sixth-detail-text">Note: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $sixth->getExtra('note')))) !!}</span></span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Image with board on it -->
                <div class="wedding-mele-sixth-right wm-reveal wm-reveal--right" style="--reveal-delay: 260ms;">
                    <div class="wedding-mele-sixth-image-wrapper">
                        @php $sixthImg = $sixth?->getExtra('image'); @endphp
                        <img src="{{ $sixthImg ? secure_media_url($sixthImg) : asset('Images/Home/sixthSec/Sixth-section-img-frame-right.png') }}" alt="Mehndi" class="wedding-mele-sixth-image">
                        <!-- Board on image + date text (same as Vatna / Sangeet) -->
                        <div class="wedding-mele-sixth-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="" class="wedding-mele-sixth-dynamic-board">
                            <div class="wedding-mele-sixth-board-date-text" aria-label="Event date">
                                @php
                                    $boardDate = $sixth?->getBoardDateFormatted();
                                @endphp
                                <span class="wedding-mele-sixth-board-line1">
                                    <span class="wedding-mele-sixth-board-day">{{ ($boardDate ?? [])['day'] ?? '25' }}</span> <span class="wedding-mele-sixth-board-month">{{ ($boardDate ?? [])['month'] ?? 'Feb' }}</span>
                                </span>
                                <span class="wedding-mele-sixth-board-year">{{ ($boardDate ?? [])['year'] ?? '2026' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
