// Header JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle (if needed in future)
    const bookAppointmentBtn = document.querySelector('.book-appointment-btn');
    
    if (bookAppointmentBtn) {
        // Check if it's a link (has href attribute)
        const isLink = bookAppointmentBtn.tagName === 'A' && bookAppointmentBtn.getAttribute('href');
        
        if (!isLink) {
            // Only prevent default if it's a button without href
            bookAppointmentBtn.addEventListener('click', function(e) {
                e.preventDefault();
                // Add your appointment booking logic here
                console.log('Book appointment clicked');
                // You can add modal or redirect logic here
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
    navLinks.forEach(link => {
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
