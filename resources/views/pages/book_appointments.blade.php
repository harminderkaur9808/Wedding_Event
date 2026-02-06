@extends('layouts.app')

@section('title', 'Book Your Appointments - Wedding Event')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/book-appointments.css') }}">
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="book-appointments-hero">
        <div class="book-appointments-hero-bg" aria-hidden="true">
            <img
                src="{{ asset('Images/Book-your-appointments/Book-your-appointments_1stSec.png') }}"
                alt=""
                class="book-appointments-hero-bg-img"
            >
        </div>
        <div class="book-appointments-hero-overlay" aria-hidden="true"></div>
        <div class="container book-appointments-hero-content book-appointments-reveal">
            <div class="book-appointments-hero-text">
                <div class="book-appointments-hero-eyebrow">Confirm Time</div>
                <div class="book-appointments-hero-decorative">
                    <img src="{{ asset('Images/Book-your-appointments/Book_your_appointments_bwtxt.png') }}" alt="Decorative Element" class="book-appointments-hero-decorative-img">
                </div>
                <h1 class="book-appointments-hero-title">Book Your Appointments</h1>
            </div>
        </div>
    </section>

    <!-- Second Section - Hair Styling -->
    <section class="book-appointments-second-section book-appointments-section-with-skeleton">
        <!-- Left Decorative Frame -->
        <div class="book-appointments-left-frame">
            <img src="{{ asset('Images/Book-your-appointments/sec-sec/hair_sec_left_frame.png') }}" alt="Left Frame" class="book-appointments-frame-img">
        </div>

        <!-- Right Decorative Frame -->
        <div class="book-appointments-right-frame">
            <img src="{{ asset('Images/Book-your-appointments/sec-sec/hair_sec_right_frame.png') }}" alt="Right Frame" class="book-appointments-frame-img">
        </div>

        <div class="book-appointments-skeleton container" aria-hidden="true">
            <div class="book-appointments-skeleton-title-wrap">
                <span class="book-appointments-skeleton-line book-appointments-skeleton-eyebrow"></span>
                <span class="book-appointments-skeleton-line book-appointments-skeleton-deco"></span>
                <span class="book-appointments-skeleton-line book-appointments-skeleton-title"></span>
            </div>
            <div class="book-appointments-skeleton-content">
                <div class="book-appointments-skeleton-image"></div>
                <div class="book-appointments-skeleton-blocks">
                    <span class="book-appointments-skeleton-line"></span>
                    <span class="book-appointments-skeleton-line"></span>
                    <span class="book-appointments-skeleton-line book-appointments-skeleton-line-short"></span>
                </div>
            </div>
        </div>

        <div class="container book-appointments-second-wrapper book-appointments-animate">
            <!-- Title Section -->
            <div class="book-appointments-second-title-section">
                <div class="book-appointments-second-eyebrow">Hair Styling</div>
                <div class="book-appointments-second-decorative">
                    <img src="{{ asset('Images/Book-your-appointments/hairbetweenmain.svg') }}" alt="Decorative Element" class="book-appointments-second-decorative-img">
                </div>
                <h2 class="book-appointments-second-title">Hair</h2>
            </div>

            <!-- Main Content: Image Left, Detail Blocks Right -->
            <div class="book-appointments-second-content">
                <div class="book-appointments-main-image">
                    <img src="{{ asset('Images/Book-your-appointments/sec-sec/Hair_sec_main.png') }}" alt="Hair Styling Service" class="book-appointments-main-img">
                </div>
                <div class="book-appointments-detail-blocks">
                    @forelse(($entriesBySection['hair'] ?? []) as $entry)
                        @include('pages.partials.book_appointment_entry', ['entry' => $entry, 'section' => 'hair'])
                    @empty
                        <p class="book-appointments-no-entries">No locations added yet for Hair. Add entries from the admin panel.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Third Section - Makeup -->
    <section class="book-appointments-third-section book-appointments-section-with-skeleton">
        <!-- Full Width Background Image -->
        <div class="book-appointments-third-bg" aria-hidden="true">
            <img
                src="{{ asset('Images/Book-your-appointments/third_sec/Third_sec_imgs_bg.png') }}"
                alt=""
                class="book-appointments-third-bg-img"
            >
        </div>

        <div class="book-appointments-skeleton container" aria-hidden="true">
            <div class="book-appointments-skeleton-title-wrap">
                <span class="book-appointments-skeleton-line book-appointments-skeleton-eyebrow"></span>
                <span class="book-appointments-skeleton-line book-appointments-skeleton-deco"></span>
                <span class="book-appointments-skeleton-line book-appointments-skeleton-title"></span>
            </div>
            <div class="book-appointments-skeleton-content book-appointments-skeleton-content-reverse">
                <div class="book-appointments-skeleton-blocks">
                    <span class="book-appointments-skeleton-line"></span>
                    <span class="book-appointments-skeleton-line"></span>
                    <span class="book-appointments-skeleton-line book-appointments-skeleton-line-short"></span>
                </div>
                <div class="book-appointments-skeleton-image"></div>
            </div>
        </div>

        <div class="container book-appointments-third-wrapper book-appointments-animate">
            <!-- Title Section -->
            <div class="book-appointments-third-title-section">
                <div class="book-appointments-third-eyebrow">Special Event Makeup</div>
                <div class="book-appointments-third-decorative">
                    <img src="{{ asset('Images/Book-your-appointments/hairbetweenmain.svg') }}" alt="Decorative Element" class="book-appointments-third-decorative-img">
                </div>
                <h2 class="book-appointments-third-title">Makeup</h2>
            </div>

            <!-- Main Content - Detail Blocks Left, Image Right -->
            <div class="book-appointments-third-content">
                <div class="book-appointments-detail-blocks book-appointments-detail-blocks-left">
                    @forelse(($entriesBySection['makeup'] ?? []) as $entry)
                        @include('pages.partials.book_appointment_entry', ['entry' => $entry, 'section' => 'makeup'])
                    @empty
                        <p class="book-appointments-no-entries">No locations added yet for Makeup. Add entries from the admin panel.</p>
                    @endforelse
                </div>
                <div class="book-appointments-third-main-image">
                    <img src="{{ asset('Images/Book-your-appointments/third_sec/Third_sec_mainimg.png') }}" alt="Makeup Service" class="book-appointments-third-main-img">
                </div>
            </div>
        </div>
    </section>

    <!-- Fourth Section - Nails -->
    <section class="book-appointments-fourth-section book-appointments-section-with-skeleton">
        <!-- Left Decorative Frame -->
        <div class="book-appointments-fourth-left-frame">
            <img src="{{ asset('Images/Book-your-appointments/forth_sec/Forth_sec_img_left.png') }}" alt="Left Frame" class="book-appointments-fourth-frame-img">
        </div>

        <!-- Right Decorative Frame -->
        <div class="book-appointments-fourth-right-frame">
            <img src="{{ asset('Images/Book-your-appointments/forth_sec/Forth_sec_img_right.png') }}" alt="Right Frame" class="book-appointments-fourth-frame-img">
        </div>

        <div class="book-appointments-skeleton container" aria-hidden="true">
            <div class="book-appointments-skeleton-title-wrap">
                <span class="book-appointments-skeleton-line book-appointments-skeleton-eyebrow"></span>
                <span class="book-appointments-skeleton-line book-appointments-skeleton-deco"></span>
                <span class="book-appointments-skeleton-line book-appointments-skeleton-title"></span>
            </div>
            <div class="book-appointments-skeleton-content">
                <div class="book-appointments-skeleton-image"></div>
                <div class="book-appointments-skeleton-blocks">
                    <span class="book-appointments-skeleton-line"></span>
                    <span class="book-appointments-skeleton-line"></span>
                    <span class="book-appointments-skeleton-line book-appointments-skeleton-line-short"></span>
                </div>
            </div>
        </div>

        <div class="container book-appointments-fourth-wrapper book-appointments-animate">
            <!-- Title Section -->
            <div class="book-appointments-fourth-title-section">
                <div class="book-appointments-fourth-eyebrow">Special Event Makeup</div>
                <div class="book-appointments-fourth-decorative">
                    <img src="{{ asset('Images/Book-your-appointments/hairbetweenmain.svg') }}" alt="Decorative Element" class="book-appointments-fourth-decorative-img">
                </div>
                <h2 class="book-appointments-fourth-title">Nails</h2>
            </div>

            <!-- Main Content: Image Left, Detail Blocks Right -->
            <div class="book-appointments-fourth-content">
                <div class="book-appointments-fourth-main-image">
                    <img src="{{ asset('Images/Book-your-appointments/forth_sec/nails_sec_main_img.png') }}" alt="Nails Service" class="book-appointments-fourth-main-img">
                </div>
                <div class="book-appointments-detail-blocks">
                    @forelse(($entriesBySection['nails'] ?? []) as $entry)
                        @include('pages.partials.book_appointment_entry', ['entry' => $entry, 'section' => 'nails'])
                    @empty
                        <p class="book-appointments-no-entries">No locations added yet for Nails. Add entries from the admin panel.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Fifth Section - Spa -->
    <section class="book-appointments-fifth-section book-appointments-section-with-skeleton">
        <!-- Full Width Background Image -->
        <div class="book-appointments-fifth-bg" aria-hidden="true">
            <img
                src="{{ asset('Images/Book-your-appointments/fifthsec/fifth_spa_bg_img.png') }}"
                alt=""
                class="book-appointments-fifth-bg-img"
            >
        </div>

        <div class="book-appointments-skeleton container" aria-hidden="true">
            <div class="book-appointments-skeleton-title-wrap">
                <span class="book-appointments-skeleton-line book-appointments-skeleton-eyebrow"></span>
                <span class="book-appointments-skeleton-line book-appointments-skeleton-deco"></span>
                <span class="book-appointments-skeleton-line book-appointments-skeleton-title"></span>
            </div>
            <div class="book-appointments-skeleton-content book-appointments-skeleton-content-reverse">
                <div class="book-appointments-skeleton-blocks">
                    <span class="book-appointments-skeleton-line"></span>
                    <span class="book-appointments-skeleton-line"></span>
                    <span class="book-appointments-skeleton-line book-appointments-skeleton-line-short"></span>
                </div>
                <div class="book-appointments-skeleton-image"></div>
            </div>
        </div>

        <div class="container book-appointments-fifth-wrapper book-appointments-animate">
            <!-- Title Section -->
            <div class="book-appointments-fifth-title-section">
                <div class="book-appointments-fifth-eyebrow">Professional Spa Care</div>
                <div class="book-appointments-fifth-decorative">
                    <img src="{{ asset('Images/Book-your-appointments/hairbetweenmain.svg') }}" alt="Decorative Element" class="book-appointments-fifth-decorative-img">
                </div>
                <h2 class="book-appointments-fifth-title">Spa</h2>
            </div>

            <!-- Main Content - Detail Blocks Left, Image Right -->
            <div class="book-appointments-fifth-content">
                <div class="book-appointments-detail-blocks book-appointments-detail-blocks-left">
                    @forelse(($entriesBySection['spa'] ?? []) as $entry)
                        @include('pages.partials.book_appointment_entry', ['entry' => $entry, 'section' => 'spa'])
                    @empty
                        <p class="book-appointments-no-entries">No locations added yet for Spa. Add entries from the admin panel.</p>
                    @endforelse
                </div>
                <div class="book-appointments-fifth-main-image">
                    <img src="{{ asset('Images/Book-your-appointments/fifthsec/Spa_img_main.png') }}" alt="Spa Service" class="book-appointments-fifth-main-img">
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
(function() {
    function initBookAppointmentsReveal() {
        var hero = document.querySelector('.book-appointments-reveal');
        if (hero) hero.classList.add('book-appointments-in-view');
        var sections = document.querySelectorAll('.book-appointments-animate');
        if (!sections.length) return;
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('book-appointments-in-view');
                    var section = entry.target.closest('.book-appointments-section-with-skeleton');
                    if (section) section.classList.add('book-appointments-loaded');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
        sections.forEach(function(el) { observer.observe(el); });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBookAppointmentsReveal);
    } else {
        initBookAppointmentsReveal();
    }
})();
</script>
@endpush
