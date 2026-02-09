/**
 * Wedding Countdown Timer
 * Dynamically calculates countdown from current time to wedding date
 * Supports homepage countdown and header countdown (Days, Hours, Minutes)
 * Automatically detects user's timezone/country
 */

(function() {
    'use strict';

    // Wedding date: from header (on every page) or homepage #wedding-countdown, or fallback
    const headerCountdownEl = document.getElementById('header-wedding-countdown');
    const mainCountdownEl = document.getElementById('wedding-countdown');
    const dateStr = (headerCountdownEl && headerCountdownEl.getAttribute('data-wedding-date'))
        || (mainCountdownEl && mainCountdownEl.getAttribute('data-wedding-date'));
    const weddingDate = dateStr ? new Date(dateStr) : new Date('2026-12-31T12:00:00');

    // Get user's timezone
    const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const userCountry = Intl.DateTimeFormat().resolvedOptions().locale;

    console.log('User Timezone:', userTimezone);
    console.log('User Locale:', userCountry);

    // DOM Elements - main (homepage) and header
    const daysElement = document.getElementById('days');
    const hoursElement = document.getElementById('hours');
    const minutesElement = document.getElementById('minutes');
    const secondsElement = document.getElementById('seconds');
    const headerDaysElement = document.getElementById('header-days');
    const headerHoursElement = document.getElementById('header-hours');
    const headerMinutesElement = document.getElementById('header-minutes');

    /**
     * Calculate time difference and update all countdown displays
     */
    function updateCountdown() {
        const now = new Date();
        const difference = weddingDate.getTime() - now.getTime();

        let days = 0, hours = 0, minutes = 0, seconds = 0;
        if (difference > 0) {
            days = Math.floor(difference / (1000 * 60 * 60 * 24));
            hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            seconds = Math.floor((difference % (1000 * 60)) / 1000);
        }

        const hoursStr = hours.toString().padStart(2, '0');
        const minutesStr = minutes.toString().padStart(2, '0');
        const secondsStr = seconds.toString().padStart(2, '0');

        // Update main (homepage) countdown if present
        if (daysElement) daysElement.textContent = days.toString();
        if (hoursElement) hoursElement.textContent = hoursStr;
        if (minutesElement) minutesElement.textContent = minutesStr;
        if (secondsElement) secondsElement.textContent = secondsStr;

        // Update header countdown if present
        if (headerDaysElement) headerDaysElement.textContent = days.toString();
        if (headerHoursElement) headerHoursElement.textContent = hoursStr;
        if (headerMinutesElement) headerMinutesElement.textContent = minutesStr;
    }

    /**
     * Initialize countdown - run if any countdown elements exist
     */
    function initCountdown() {
        const hasMain = daysElement && hoursElement && minutesElement;
        const hasHeader = headerDaysElement && headerHoursElement && headerMinutesElement;
        if (!hasMain && !hasHeader) {
            return;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCountdown);
    } else {
        initCountdown();
    }

    window.WeddingCountdown = {
        update: updateCountdown,
        getTimezone: () => userTimezone,
        getCountry: () => userCountry,
        getWeddingDate: () => weddingDate
    };

})();
