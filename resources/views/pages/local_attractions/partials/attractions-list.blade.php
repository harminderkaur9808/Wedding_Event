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
                        <img src="{{ secure_media_url(ltrim($attraction->image_path, '/')) }}" alt="" class="wm-la-item-img">
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
                        @if(!empty($attraction->website))
                            <li class="wm-la-item-meta-row">
                                <svg class="wm-la-item-meta-ico wm-la-item-meta-ico--svg" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" fill="currentColor"/>
                                </svg>
                                <span><strong>Website:</strong> <a class="wm-la-item-map-link" href="{{ $attraction->website }}" target="_blank" rel="noopener noreferrer">Visit Website</a></span>
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

