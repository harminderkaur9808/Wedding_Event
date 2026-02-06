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
    <div class="book-appointments-detail-row">
        <img src="{{ asset('Images/Home/fifthsec/venue_svg_fifth.svg') }}" alt="" class="book-appointments-detail-icon" aria-hidden="true">
        <span>Distance: {{ $entry->distance ?: '—' }}</span>
    </div>
    <div class="book-appointments-detail-row">
        <img src="{{ asset('Images/Home/fifthsec/dresscode_svg_fifth.svg') }}" alt="" class="book-appointments-detail-icon" aria-hidden="true">
        <span>Services: {{ $entry->services ?: '—' }}</span>
    </div>
</div>
