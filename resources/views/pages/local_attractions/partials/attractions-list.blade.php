<section class="wm-la-list">
    <div class="container wm-la-list-container">
        @forelse($attractions as $attraction)
            @php
                $pos = $attraction->image_position === 'right' ? 'right' : 'left';
                $showDecor = $loop->odd; /* 1st, 3rd, 5th, ... */
                $showBg = $loop->even;   /* 2nd, 4th, 6th, ... full-width background */
            @endphp
            @if($showBg)
                <div class="wm-la-item-row wm-la-item-row--with-bg" style="background-image: url('{{ asset('Images/Local_attractions/Local_attractions_09.png') }}');">
                    <div class="wm-la-list-container wm-la-list-container--inner">
            @endif
            @if($showDecor)
                <div class="wm-la-item-row wm-la-item-row--with-decor">
                    <img src="{{ asset('Images/Local_attractions/decor/Left_side_decor.png') }}" alt="" class="wm-la-decor wm-la-decor--left" aria-hidden="true">
                    <img src="{{ asset('Images/Local_attractions/decor/right_side_decor.png') }}" alt="" class="wm-la-decor wm-la-decor--right" aria-hidden="true">
            @endif
            <article class="wm-la-item wm-la-item--{{ $pos }} wm-la-animate wm-la-item-index-{{ $loop->iteration }}">
                <div class="wm-la-item-media" aria-hidden="true">
                    @if(!empty($attraction->image_path))
                        <img src="{{ asset('storage/' . ltrim($attraction->image_path, '/')) }}" alt="" class="wm-la-item-img">
                    @else
                        <div class="wm-la-item-img wm-la-item-img--placeholder"></div>
                    @endif
                </div>

                <div class="wm-la-item-card">
                    <h3 class="wm-la-item-title">{{ $attraction->title }}</h3>
                    @if(!empty($attraction->description))
                        <p class="wm-la-item-desc">{{ $attraction->description }}</p>
                    @endif

                    <ul class="wm-la-item-meta" role="list">
                        @if(!empty($attraction->address))
                            <li class="wm-la-item-meta-row">
                                <img src="{{ asset('Images/Local_attractions/Address_main_icon.svg') }}" alt="" class="wm-la-item-meta-ico">
                                <span><strong>Address:</strong> {{ $attraction->address }}</span>
                            </li>
                        @endif
                        @if(!empty($attraction->distance))
                            <li class="wm-la-item-meta-row">
                                <img src="{{ asset('Images/Local_attractions/Distance_main_icon.svg') }}" alt="" class="wm-la-item-meta-ico">
                                <span><strong>Distance:</strong> {{ $attraction->distance }}</span>
                            </li>
                        @endif
                        @if(!empty($attraction->map_url))
                            <li class="wm-la-item-meta-row">
                                <img src="{{ asset('Images/Local_attractions/map_location_main_icon.svg') }}" alt="" class="wm-la-item-meta-ico">
                                <span><strong>Map Location:</strong> <a class="wm-la-item-map-link" href="{{ $attraction->map_url }}" target="_blank" rel="noopener noreferrer">Click Here</a></span>
                            </li>
                        @endif
                    </ul>
                </div>
            </article>
            @if($showDecor)
                </div>
            @endif
            @if($showBg)
                    </div>
                </div>
            @endif
        @empty
            <div class="wm-la-empty">
                <p>No local attractions added yet.</p>
            </div>
        @endforelse
    </div>
</section>

