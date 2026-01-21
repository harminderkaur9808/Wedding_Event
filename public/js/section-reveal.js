// Generic reveal-on-scroll animation (IntersectionObserver)
document.addEventListener('DOMContentLoaded', function () {
    const elements = document.querySelectorAll('.wm-reveal');
    if (!elements.length) return;

    // If browser doesn't support IntersectionObserver, show everything
    if (!('IntersectionObserver' in window)) {
        elements.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target); // animate once
            });
        },
        {
            threshold: 0.18,
            rootMargin: '0px 0px -10% 0px',
        }
    );

    elements.forEach((el) => observer.observe(el));
});

