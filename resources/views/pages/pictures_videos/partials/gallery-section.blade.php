<section class="wm-pv-gallery-section wm-pv-animate">
    <div class="container">
        <div class="wm-pv-gallery-grid">
            @foreach($categories ?? [] as $cat)
            <div class="wm-pv-gallery-card wm-pv-animate-entry">
                <div class="wm-pv-gallery-card-bg">
                    <img src="{{ asset('Images/picturesandvideos/thisimages/' . ($cat->image_path ?? 'Roka_image.png')) }}" alt="{{ $cat->name }}" class="wm-pv-gallery-card-img" onerror="this.src='{{ asset('Images/picturesandvideos/thisimages/Roka_image.png') }}'">
                </div>
                <div class="wm-pv-gallery-card-overlay"></div>
                <div class="wm-pv-gallery-card-content">
                    <h3 class="wm-pv-gallery-card-title">{{ $cat->name }}</h3>
                    <a href="{{ route('pictures_videos.category', ['category' => $cat->slug]) }}" class="wm-pv-gallery-card-btn">View All</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
