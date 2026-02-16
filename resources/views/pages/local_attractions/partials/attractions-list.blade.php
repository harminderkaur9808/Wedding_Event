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
                    <div class="book-appointments-detail-block">
                        <div class="book-appointments-detail-block-header">{{ $attraction->title ?: '—' }}</div>

                        @if(!empty(trim($attraction->description ?? '')))
                        <div class="book-appointments-detail-row">
                            {{-- <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="" class="book-appointments-detail-icon" aria-hidden="true"> --}}
                            <span><strong>Description:</strong> {{ $attraction->description }}</span>
                        </div>
                        @endif

                        @if(!empty(trim($attraction->note_to_guests ?? '')))
                        <div class="book-appointments-detail-row">
                            {{-- <svg class="book-appointments-detail-icon book-appointments-detail-icon-svg book-appointments-detail-icon-note" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg> --}}
                            <span><strong>Note to Guests:</strong> {{ $attraction->note_to_guests }}</span>
                        </div>
                        @endif

                        @if(!empty(trim($attraction->address ?? '')))
                        <div class="book-appointments-detail-row">
                            {{-- <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="" class="book-appointments-detail-icon" aria-hidden="true"> --}}
                            <span><strong>Address:</strong> {{ $attraction->address }}</span>
                        </div>
                        @endif

                        @if(!empty(trim($attraction->phone ?? '')))
                        <div class="book-appointments-detail-row">
                            {{-- <svg class="book-appointments-detail-icon book-appointments-detail-icon-svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2F4F75" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> --}}
                            <span><strong>Phone:</strong> {{ $attraction->phone }}</span>
                        </div>
                        @endif

                        @if(!empty(trim($attraction->website ?? '')))
                        <div class="book-appointments-detail-row">
                            {{-- <svg class="book-appointments-detail-icon book-appointments-detail-icon-svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2F4F75" stroke-width="2" aria-hidden="true"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg> --}}
                            <span><strong>Website:</strong> <a class="book-appointments-detail-link book-appointments-detail-url" href="{{ $attraction->website }}" target="_blank" rel="noopener noreferrer">{{ $attraction->website }}</a></span>
                        </div>
                        @endif

                        @if(!empty(trim($attraction->map_url ?? '')))
                        <div class="book-appointments-detail-row">
                            {{-- <svg class="book-appointments-detail-icon book-appointments-detail-icon-svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2F4F75" stroke-width="2" aria-hidden="true"><path d="M21 10c0 6-9 13-9 13S3 16 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> --}}
                            <span><strong>Map Link:</strong> <a class="book-appointments-detail-link" href="{{ $attraction->map_url }}" target="_blank" rel="noopener noreferrer">Click Here</a></span>
                        </div>
                        @endif

                        @if(!empty(trim($attraction->distance ?? '')))
                        <div class="book-appointments-detail-row">
                            {{-- <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="" class="book-appointments-detail-icon" aria-hidden="true"> --}}
                            <span><strong>Distance:</strong> {{ $attraction->distance }}</span>
                        </div>
                        @endif
                    </div>
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

