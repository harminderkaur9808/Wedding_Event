@php
    $hero = $sections['hero'] ?? null;
    $defaultImage = asset('Images/Home/First_slider_image.png');
    $sliderImages = [];
    for ($i = 1; $i <= 3; $i++) {
        $path = $hero?->getExtra('slider_' . $i);
        if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            $sliderImages[] = secure_media_url($path);
        } else {
            $sliderImages[] = $defaultImage;
        }
    }
@endphp
<section class="wedding-mele-hero-section">
    <div id="wedding-mele-hero-carousel" class="carousel slide wedding-mele-carousel" data-bs-ride="carousel" data-bs-interval="5000">
        <!-- Carousel Indicators -->
        <div class="carousel-indicators wedding-mele-carousel-indicators">
            <button type="button" data-bs-target="#wedding-mele-hero-carousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#wedding-mele-hero-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#wedding-mele-hero-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- Carousel Items -->
        <div class="carousel-inner wedding-mele-carousel-inner">
            @foreach($sliderImages as $index => $imageUrl)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }} wedding-mele-carousel-item">
                <img src="{{ $imageUrl }}" class="d-block w-100 wedding-mele-slide-image" alt="Wedding Slide {{ $index + 1 }}">

                <!-- Animated Heart Overlay -->
                <div class="wedding-mele-heart-overlay">
                    <div class="wedding-mele-particles">
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                        <span class="wedding-mele-particle"></span>
                    </div>
                    <div class="wedding-mele-heart-container">
                        <div class="wedding-mele-heart-shape">
                            <div class="wedding-mele-heart-sparkles">
                                @for($s = 0; $s < 40; $s++)
                                <span class="wedding-mele-sparkle"></span>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Carousel Controls -->
        <button class="carousel-control-prev wedding-mele-carousel-control-prev" type="button" data-bs-target="#wedding-mele-hero-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon wedding-mele-carousel-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next wedding-mele-carousel-control-next" type="button" data-bs-target="#wedding-mele-hero-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon wedding-mele-carousel-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
