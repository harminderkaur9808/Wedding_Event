// Header JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Book appointment button
    const bookAppointmentBtn = document.querySelector('.book-appointment-btn');
    
    if (bookAppointmentBtn) {
        bookAppointmentBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Book appointment clicked');
            // Add your appointment booking logic here
        });
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
