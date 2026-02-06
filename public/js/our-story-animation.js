// Our Story Section: scroll-based width animation (desktop) and opacity (all)
document.addEventListener('DOMContentLoaded', function () {
    var storySection = document.querySelector('.wedding-mele-our-story-section');
    var coupleImages = document.querySelector('.wedding-mele-couple-images');
    if (!storySection || !coupleImages) return;

    var MAX_WIDTH = 65;
    var MIN_WIDTH = 38;
    var RANGE = MAX_WIDTH - MIN_WIDTH;
    /* iPad / iPad Mini / tablet: no scroll width animation to avoid "come close" overlap */
    var MOBILE_BREAKPOINT = 1024;

    coupleImages.style.width = MAX_WIDTH + '%';

    var ticking = false;

    function isMobile() {
        return (window.innerWidth || document.documentElement.clientWidth) <= MOBILE_BREAKPOINT;
    }

    function clamp(n, min, max) {
        return Math.max(min, Math.min(max, n));
    }

    function update() {
        ticking = false;
        var rect = storySection.getBoundingClientRect();
        var vh = window.innerHeight || document.documentElement.clientHeight;

        if (rect.bottom <= 0 || rect.top >= vh) {
            if (!isMobile()) coupleImages.style.width = MAX_WIDTH + '%';
            coupleImages.classList.remove('animate');
            return;
        }

        coupleImages.classList.add('animate');

        if (isMobile()) {
            coupleImages.style.width = '100%';
            return;
        }

        var viewportFocusY = vh * 0.55;
        var base = clamp((viewportFocusY - rect.top) / rect.height, 0, 1);
        var t = clamp(base * 2.0, 0, 1);
        var step = Math.round(RANGE * t);
        var width = MAX_WIDTH - step;
        coupleImages.style.width = width + '%';
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
