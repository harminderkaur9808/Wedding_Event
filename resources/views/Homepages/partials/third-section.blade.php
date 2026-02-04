<section class="wedding-mele-third-section">
    <div class="wedding-mele-third-section-bg">
        <img src="{{ asset('Images/Home/thirdsec/thirdsection_img_bg.png') }}" alt="Background" class="wedding-mele-bg-image">
    </div>
    
    <div class="container">
        <div class="wedding-mele-third-content">
            <!-- Title Section -->
            <div class="wedding-mele-third-title-section">
                @php $weddingDay = $sections['wedding_day'] ?? null; @endphp
                <h2 class="wedding-mele-wedding-day-text">{{ $weddingDay?->subtitle ?? 'Wedding Day' }}</h2>
                <div class="wedding-mele-third-decorative">
                    <img src="{{ asset('Images/Home/thirdsec/thirdbetweentxtframe.png') }}" alt="Decorative Element" class="wedding-mele-third-decorative-img">
                </div>
                <h3 class="wedding-mele-date-text">{{ $weddingDay?->title ?? 'Date We Getting Married' }}</h3>
            </div>

            <!-- Countdown Section (date from backend for wedding_day section) -->
            <div class="wedding-mele-countdown-wrapper" id="wedding-countdown" @if($weddingDate) data-wedding-date="{{ $weddingDate->format('Y-m-d\TH:i:s') }}" @endif>
                <div class="wedding-mele-countdown-box">
                    <div class="wedding-mele-countdown-number" id="days">0</div>
                    <div class="wedding-mele-countdown-label">Day</div>
                </div>
                <div class="wedding-mele-countdown-box">
                    <div class="wedding-mele-countdown-number" id="hours">0</div>
                    <div class="wedding-mele-countdown-label">Hours</div>
                </div>
                <div class="wedding-mele-countdown-box">
                    <div class="wedding-mele-countdown-number" id="minutes">0</div>
                    <div class="wedding-mele-countdown-label">Minutes</div>
                </div>
                <div class="wedding-mele-countdown-box">
                    <div class="wedding-mele-countdown-number" id="seconds">0</div>
                    <div class="wedding-mele-countdown-label">Seconds</div>
                </div>
            </div>
        </div>
    </div>
</section>
