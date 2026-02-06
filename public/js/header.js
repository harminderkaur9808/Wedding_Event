// Header JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Reserve space for fixed header so first section is never behind it
    (function() {
        var header = document.querySelector('.wedding-header');
        var mainEl = document.querySelector('main');
        function setHeaderOffset() {
            if (header && mainEl) {
                var h = header.offsetHeight;
                document.documentElement.style.setProperty('--header-height', h + 'px');
                mainEl.style.paddingTop = h + 'px';
            }
        }
        setHeaderOffset();
        window.addEventListener('resize', setHeaderOffset);
    })();

    // Sticky header: hide on scroll down, show on scroll up
    (function() {
        var header = document.querySelector('.wedding-header');
        if (!header) return;
        var lastScrollY = window.scrollY || window.pageYOffset;
        var threshold = 80;
        var scrollUpTolerance = 10;

        function onScroll() {
            var currentScrollY = window.scrollY || window.pageYOffset;
            if (currentScrollY <= scrollUpTolerance) {
                header.classList.remove('header-hidden');
            } else if (currentScrollY > lastScrollY && currentScrollY > threshold) {
                header.classList.add('header-hidden');
            } else if (currentScrollY < lastScrollY) {
                header.classList.remove('header-hidden');
            }
            lastScrollY = currentScrollY;
        }

        var ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    onScroll();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    })();

    // Book appointment button - only prevent default if it's a button without href
    const bookAppointmentBtn = document.querySelector('.book-appointment-btn');
    
    if (bookAppointmentBtn) {
        // Check if it's a link (has href attribute)
        const isLink = bookAppointmentBtn.tagName === 'A' && bookAppointmentBtn.getAttribute('href');
        
        if (!isLink) {
            // Only prevent default if it's a button without href
            bookAppointmentBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Book appointment clicked');
                // Add your appointment booking logic here
            });
        } else {
            // Ensure link is clickable - remove any event listeners that might interfere
            bookAppointmentBtn.style.pointerEvents = 'auto';
            bookAppointmentBtn.style.cursor = 'pointer';
        }
        // If it's a link, let it navigate normally
    }

    // Smooth scroll for navigation links
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href && href.startsWith('#')) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
});
