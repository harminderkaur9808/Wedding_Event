<div class="book-appointments-detail-block">
    <div class="book-appointments-detail-block-header">{{ $entry->store_name ?: '—' }}</div>
    @if(($section ?? '') === 'hair')
    <p class="book-appointments-detail-instruction">{{ $entry->instruction ?: 'Call at least one month ahead and book your appointments.' }}</p>
    @endif
    {{-- Instruction shown only for Hair section; commented out for Makeup, Nails, Spa --}}
    <div class="book-appointments-detail-row">
        <img src="{{ asset('Images/Home/sixthSec/address_ico_main.svg') }}" alt="" class="book-appointments-detail-icon" aria-hidden="true">
        <span>Address: {{ $entry->address ?: '—' }}</span>
    </div>
    @if(!empty($entry->phone_number))
    <div class="book-appointments-detail-row">
        <svg class="book-appointments-detail-icon book-appointments-detail-icon-svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#2F4F75" stroke-width="2" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        <span>Phone: {{ $entry->phone_number }}</span>
    </div>
    @endif
    <div class="book-appointments-detail-row">
        <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="" class="book-appointments-detail-icon" aria-hidden="true">
        <span>Distance: {{ $entry->distance ?: '—' }}</span>
    </div>
    <div class="book-appointments-detail-row">
        <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="" class="book-appointments-detail-icon" aria-hidden="true">
        <span>Services: {{ $entry->services ?: '—' }}</span>
    </div>
</div>
