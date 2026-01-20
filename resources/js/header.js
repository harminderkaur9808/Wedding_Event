// Header JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle (if needed in future)
    const bookAppointmentBtn = document.querySelector('.book-appointment-btn');
    
    if (bookAppointmentBtn) {
        bookAppointmentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Add your appointment booking logic here
            console.log('Book appointment clicked');
            // You can add modal or redirect logic here
        });
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
