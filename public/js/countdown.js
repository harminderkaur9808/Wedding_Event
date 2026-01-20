/**
 * Wedding Countdown Timer
 * Dynamically calculates countdown from current time to wedding date
 * Automatically detects user's timezone/country
 */

(function() {
    'use strict';

    // Wedding date: December 31, 2026 at 12:00 PM (noon) in user's local timezone
    // You can modify this date as needed
    const weddingDate = new Date('2026-12-31T12:00:00');
    
    // Get user's timezone
    const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    const userCountry = Intl.DateTimeFormat().resolvedOptions().locale;
    
    console.log('User Timezone:', userTimezone);
    console.log('User Locale:', userCountry);

    // DOM Elements
    const daysElement = document.getElementById('days');
    const hoursElement = document.getElementById('hours');
    const minutesElement = document.getElementById('minutes');

    /**
     * Calculate time difference and update countdown
     */
    function updateCountdown() {
        const now = new Date();
        const difference = weddingDate.getTime() - now.getTime();

        // If wedding date has passed
        if (difference <= 0) {
            daysElement.textContent = '0';
            hoursElement.textContent = '0';
            minutesElement.textContent = '0';
            return;
        }

        // Calculate days, hours, and minutes
        const days = Math.floor(difference / (1000 * 60 * 60 * 24));
        const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));

        // Update DOM elements
        daysElement.textContent = days.toString();
        hoursElement.textContent = hours.toString().padStart(2, '0');
        minutesElement.textContent = minutes.toString().padStart(2, '0');
    }

    /**
     * Format number with leading zeros if needed
     */
    function formatNumber(num, digits = 2) {
        return num.toString().padStart(digits, '0');
    }

    /**
     * Initialize countdown
     */
    function initCountdown() {
        // Check if elements exist
        if (!daysElement || !hoursElement || !minutesElement) {
            console.error('Countdown elements not found');
            return;
        }

        // Initial update
        updateCountdown();

        // Update every second for real-time countdown
        setInterval(updateCountdown, 1000);
    }

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCountdown);
    } else {
        initCountdown();
    }

    // Export for potential external use
    window.WeddingCountdown = {
        update: updateCountdown,
        getTimezone: () => userTimezone,
        getCountry: () => userCountry,
        getWeddingDate: () => weddingDate
    };

})();
