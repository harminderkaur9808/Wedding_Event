// Header JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
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
