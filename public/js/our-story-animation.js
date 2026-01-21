// Our Story Section Scroll Effect
// On scroll into the section: width 53% -> 45% in 1% steps
document.addEventListener('DOMContentLoaded', function () {
    const storySection = document.querySelector('.wedding-mele-our-story-section');
    const coupleImages = document.querySelector('.wedding-mele-couple-images');
    if (!storySection || !coupleImages) return;

    const MAX_WIDTH = 65; // %
    const MIN_WIDTH = 43; // %
    const RANGE = MAX_WIDTH - MIN_WIDTH; // 8

    // Start at default
    coupleImages.style.width = `${MAX_WIDTH}%`;

    let ticking = false;

    function clamp(n, min, max) {
        return Math.max(min, Math.min(max, n));
    }

    function update() {
        ticking = false;

        const rect = storySection.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;

        // Out of view => reset
        if (rect.bottom <= 0 || rect.top >= vh) {
            coupleImages.style.width = `${MAX_WIDTH}%`;
            coupleImages.classList.remove('animate');
            return;
        }

        // In view => show "animate" (used for opacity) and adjust width
        coupleImages.classList.add('animate');

        // Progress based on viewport center position inside the section.
        // This works smoothly scrolling both down and up.
        const viewportFocusY = vh * 0.55; // slightly below center feels nicer
        const base = clamp((viewportFocusY - rect.top) / rect.height, 0, 1);

        // Make it "close" by the time you reach the main/middle part of section.
        // (65% -> 43% reaches MIN around mid scroll)
        const t = clamp(base * 2.0, 0, 1);

        // 1% step changes (53 -> 45)
        const step = Math.round(RANGE * t); // 0..RANGE (1% steps, slower)
        const width = MAX_WIDTH - step;
        coupleImages.style.width = `${width}%`;
    }

    function onScrollOrResize() {
        if (ticking) return;
        ticking = true;
        window.requestAnimationFrame(update);
    }

    window.addEventListener('scroll', onScrollOrResize, { passive: true });
    window.addEventListener('resize', onScrollOrResize, { passive: true });
    update();
});
