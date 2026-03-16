<section class="wedding-mele-eleventh-section">
    <!-- Decorative hearts -->
    <img src="{{ asset('Images/Home/eleventhsecimg/heart_img_decor.svg') }}" alt="" class="wedding-mele-eleventh-heart wedding-mele-eleventh-heart--left" aria-hidden="true">
    <img src="{{ asset('Images/Home/eleventhsecimg/heart_img_decor.svg') }}" alt="" class="wedding-mele-eleventh-heart wedding-mele-eleventh-heart--right" aria-hidden="true">

    <div class="container">
        <div class="wedding-mele-eleventh-content">
            <!-- Header -->
            <div class="wedding-mele-eleventh-header wm-reveal" style="--reveal-delay: 0ms;">
                @php $eleventh = $sections['eleventh'] ?? null; @endphp
                <h3 class="wedding-mele-eleventh-subtitle">{{ $eleventh?->subtitle ?? 'Sacred Union' }}</h3>
                <div class="wedding-mele-eleventh-between">
                    <img src="{{ asset('Images/Home/eleventhsecimg/between_txtframe.png') }}" alt="Decorative Element" class="wedding-mele-eleventh-between-img">
                </div>
                <h2 class="wedding-mele-eleventh-title">{{ $eleventh?->title ?? 'Wedding' }}</h2>
                @if($eleventh?->short_description)
                    <div class="wedding-mele-section-description">{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $eleventh->short_description))) !!}</div>
                @endif
            </div>

            <!-- Main -->
            <div class="wedding-mele-eleventh-main">
                <!-- Left: Details -->
                <div class="wedding-mele-eleventh-left wm-reveal wm-reveal--left" style="--reveal-delay: 220ms;">
                    <div class="wedding-mele-eleventh-details">
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Date: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $eleventh?->getExtra('date') ?? '01-01-2027'))) !!}</span></span>
                        </div>
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/time_svg_fifth.svg') }}" alt="Time" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Time: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $eleventh?->getExtra('time') ?? '9 am-12 pm'))) !!}</span></span>
                        </div>
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Venue: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $eleventh?->getExtra('venue') ?? 'Ramit and Maninder Residence'))) !!}</span></span>
                        </div>
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="Address" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Address: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $eleventh?->getExtra('address') ?? '20865 N 109th Place Scottsdale AZ'))) !!}</span></span>
                        </div>
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="Dress Code" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">
                                Dress Code: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $eleventh?->getExtra('dress_code') ?? 'Indian Traditional Outfits'))) !!}</span>
                                @php $menText = $eleventh?->getExtra('dress_code_men'); $womenText = $eleventh?->getExtra('dress_code_women'); @endphp
                                @if($menText || $womenText)
                                    <span class="wedding-mele-eleventh-detail-subtext"><b>Men:</b> {!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $menText ?? '—'))) !!}&nbsp;&nbsp;&nbsp;<b>Women:</b> {!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $womenText ?? '—'))) !!}</span>
                                @elseif($eleventh?->getExtra('dress_code_subtext'))
                                    @php
                                        $sub = preg_replace('/<br\s*\/?>/i', "\n", $eleventh->getExtra('dress_code_subtext'));
                                        $sub = nl2br(e($sub));
                                        $sub = preg_replace('/\bMen:\s*/', '<b>Men:</b> ', $sub);
                                        $sub = preg_replace('/\bWomen:\s*/', '<b>Women:</b> ', $sub);
                                    @endphp
                                    <span class="wedding-mele-eleventh-detail-subtext">{!! $sub !!}</span>
                                @else
                                    <span class="wedding-mele-eleventh-detail-subtext"><b>Men:</b> Red Turbans Head Covers&nbsp;&nbsp;&nbsp;<b>Women:</b> Any Color</span>
                                @endif
                            </span>
                        </div>
                        @if(trim((string)($eleventh?->getExtra('note') ?? '')) !== '')
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/note_icon.svg') }}" alt="Note" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Note: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $eleventh->getExtra('note')))) !!}</span></span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Image with board on it (top-right as indicated) -->
                <div class="wedding-mele-eleventh-right wm-reveal wm-reveal--right" style="--reveal-delay: 260ms;">
                    <div class="wedding-mele-eleventh-image-wrapper">
                        @php $eleventhImg = $eleventh?->getExtra('image'); @endphp
                        <img src="{{ $eleventhImg ? secure_media_url($eleventhImg) : asset('Images/Home/eleventhsecimg/wedding_img_sec_last.png') }}" alt="Wedding" class="wedding-mele-eleventh-image">
                        <!-- Board on image + date text (top-right corner) -->
                        <div class="wedding-mele-eleventh-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="" class="wedding-mele-eleventh-dynamic-board">
                            <div class="wedding-mele-eleventh-board-date-text" aria-label="Event date">
                                @php
                                    $boardDate = $eleventh?->getBoardDateFormatted();
                                @endphp
                                <span class="wedding-mele-eleventh-board-line1">
                                    <span class="wedding-mele-eleventh-board-day">{{ ($boardDate ?? [])['day'] ?? '31' }}</span> <span class="wedding-mele-eleventh-board-month">{{ ($boardDate ?? [])['month'] ?? 'Dec' }}</span>
                                </span>
                                <span class="wedding-mele-eleventh-board-year">{{ ($boardDate ?? [])['year'] ?? '2026' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

