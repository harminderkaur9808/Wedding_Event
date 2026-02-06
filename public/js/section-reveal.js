/**
 * Smooth reveal-on-scroll for .wm-reveal (homepage sections).
 * Uses IntersectionObserver + requestAnimationFrame for correct timing.
 */
(function () {
    function init() {
        var elements = document.querySelectorAll('.wm-reveal');
        if (!elements.length) return;

        if (!('IntersectionObserver' in window)) {
            elements.forEach(function (el) { el.classList.add('is-visible'); });
            return;
        }

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    var el = entry.target;
                    observer.unobserve(el);
                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () {
                            el.classList.add('is-visible');
                        });
                    });
                });
            },
            {
                threshold: 0.08,
                rootMargin: '0px 0px -5% 0px',
            }
        );

        elements.forEach(function (el) { observer.observe(el); });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
