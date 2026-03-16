@php
    $thirteenth = $sections['thirteenth'] ?? null;
    $hasSubtitle = $thirteenth && trim((string) $thirteenth->subtitle) !== '';
    $hasTitle = $thirteenth && trim((string) $thirteenth->title) !== '';
    $hasDescription = $thirteenth && trim((string) ($thirteenth->short_description ?? '')) !== '';
    $hasDate = $thirteenth && trim((string) ($thirteenth->getExtra('date') ?? '')) !== '';
    $hasTime = $thirteenth && trim((string) ($thirteenth->getExtra('time') ?? '')) !== '';
    $hasVenue = $thirteenth && trim((string) ($thirteenth->getExtra('venue') ?? '')) !== '';
    $hasAddress = $thirteenth && trim((string) ($thirteenth->getExtra('address') ?? '')) !== '';
    $hasDressCode = $thirteenth && trim((string) ($thirteenth->getExtra('dress_code') ?? '')) !== '';
    $hasDressMen = $thirteenth && trim((string) ($thirteenth->getExtra('dress_code_men') ?? '')) !== '';
    $hasDressWomen = $thirteenth && trim((string) ($thirteenth->getExtra('dress_code_women') ?? '')) !== '';
    $hasDressSubtext = $thirteenth && trim((string) ($thirteenth->getExtra('dress_code_subtext') ?? '')) !== '';
    $thirteenthImg = $thirteenth?->getExtra('image');
    $hasImage = $thirteenthImg && trim((string) $thirteenthImg) !== '';
    $boardDate = $thirteenth?->getBoardDateFormatted();
    $hasBoardDate = $boardDate && !empty($boardDate['day']) && !empty($boardDate['month']) && !empty($boardDate['year']);
    $hasAnyHeader = $hasSubtitle || $hasTitle || $hasDescription;
    $hasAnyDetail = $hasDate || $hasTime || $hasVenue || $hasAddress || $hasDressCode || $hasDressMen || $hasDressWomen || $hasDressSubtext;
    $hasAnyContent = $hasAnyHeader || $hasAnyDetail || $hasImage;
@endphp
@if($hasAnyContent)
<section class="wedding-mele-eleventh-section">
    <img src="{{ asset('Images/Home/eleventhsecimg/heart_img_decor.svg') }}" alt="" class="wedding-mele-eleventh-heart wedding-mele-eleventh-heart--left" aria-hidden="true">
    <img src="{{ asset('Images/Home/eleventhsecimg/heart_img_decor.svg') }}" alt="" class="wedding-mele-eleventh-heart wedding-mele-eleventh-heart--right" aria-hidden="true">

    <div class="container">
        <div class="wedding-mele-eleventh-content">
            @if($hasAnyHeader)
            <div class="wedding-mele-eleventh-header wm-reveal" style="--reveal-delay: 0ms;">
                @if($hasSubtitle)
                    <h3 class="wedding-mele-eleventh-subtitle">{{ $thirteenth->subtitle }}</h3>
                @endif
                @if($hasSubtitle || $hasTitle)
                <div class="wedding-mele-eleventh-between">
                    <img src="{{ asset('Images/Home/eleventhsecimg/between_txtframe.png') }}" alt="" class="wedding-mele-eleventh-between-img">
                </div>
                @endif
                @if($hasTitle)
                    <h2 class="wedding-mele-eleventh-title">{{ $thirteenth->title }}</h2>
                @endif
                @if($hasDescription)
                    <div class="wedding-mele-section-description">{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->short_description))) !!}</div>
                @endif
            </div>
            @endif

            @if($hasAnyDetail || $hasImage)
            <div class="wedding-mele-eleventh-main">
                @if($hasAnyDetail)
                <div class="wedding-mele-eleventh-left wm-reveal wm-reveal--left" style="--reveal-delay: 220ms;">
                    <div class="wedding-mele-eleventh-details">
                        @if($hasDate)
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/date_svg_fifth.svg') }}" alt="Date" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Date: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('date')))) !!}</span></span>
                        </div>
                        @endif
                        @if($hasTime)
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/time_svg_fifth.svg') }}" alt="Time" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Time: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('time')))) !!}</span></span>
                        </div>
                        @endif
                        @if($hasVenue)
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="Venue" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Venue: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('venue')))) !!}</span></span>
                        </div>
                        @endif
                        @if($hasAddress)
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="Address" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Address: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('address')))) !!}</span></span>
                        </div>
                        @endif
                        @if($hasDressCode || $hasDressMen || $hasDressWomen || $hasDressSubtext)
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="Dress Code" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">
                                @if($hasDressCode)
                                    Dress Code: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('dress_code')))) !!}</span>
                                @endif
                                @if($hasDressMen || $hasDressWomen)
                                    <span class="wedding-mele-eleventh-detail-subtext"><b>Men:</b> {!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('dress_code_men') ?? ''))) !!}&nbsp;&nbsp;&nbsp;<b>Women:</b> {!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('dress_code_women') ?? ''))) !!}</span>
                                @elseif($hasDressSubtext)
                                    @php
                                        $sub = preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('dress_code_subtext'));
                                        $sub = nl2br(e($sub));
                                        $sub = preg_replace('/\bMen:\s*/', '<b>Men:</b> ', $sub);
                                        $sub = preg_replace('/\bWomen:\s*/', '<b>Women:</b> ', $sub);
                                    @endphp
                                    <span class="wedding-mele-eleventh-detail-subtext">{!! $sub !!}</span>
                                @endif
                            </span>
                        </div>
                        @endif
                        @if($thirteenth && trim((string)($thirteenth->getExtra('note') ?? '')) !== '')
                        <div class="wedding-mele-eleventh-detail-item">
                            <img src="{{ asset('Images/Home/note_icon.svg') }}" alt="Note" class="wedding-mele-eleventh-detail-icon">
                            <span class="wedding-mele-eleventh-detail-text">Note: <span>{!! nl2br(e(preg_replace('/<br\s*\/?>/i', "\n", $thirteenth->getExtra('note')))) !!}</span></span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if($hasImage)
                <div class="wedding-mele-eleventh-right wm-reveal wm-reveal--right" style="--reveal-delay: 260ms;">
                    <div class="wedding-mele-eleventh-image-wrapper">
                        <img src="{{ secure_media_url($thirteenthImg) }}" alt="Wedding" class="wedding-mele-eleventh-image">
                        @if($hasBoardDate)
                        <div class="wedding-mele-eleventh-board-on-image">
                            <img src="{{ asset('Images/Home/Dynmaic_image_board.png') }}" alt="" class="wedding-mele-eleventh-dynamic-board">
                            <div class="wedding-mele-eleventh-board-date-text" aria-label="Event date">
                                <span class="wedding-mele-eleventh-board-line1">
                                    <span class="wedding-mele-eleventh-board-day">{{ $boardDate['day'] }}</span> <span class="wedding-mele-eleventh-board-month">{{ $boardDate['month'] }}</span>
                                </span>
                                <span class="wedding-mele-eleventh-board-year">{{ $boardDate['year'] }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>
@endif
