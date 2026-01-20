// Our Story Section Scroll Animation
// Images start at endpoints, come close together when scrolling from first section to second section
document.addEventListener('DOMContentLoaded', function() {
    const storySection = document.querySelector('.wedding-mele-our-story-section');
    const coupleImages = document.querySelector('.wedding-mele-couple-images');
    const vickramImage = document.querySelector('.wedding-mele-vickram-image');
    const nishaImage = document.querySelector('.wedding-mele-nisha-image');
    
    if (!storySection || !coupleImages || !vickramImage || !nishaImage) return;
    
    // Track scroll position and direction
    let lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    let isScrollingDown = true;
    
    // Ensure container starts at default width (53%) - no animation on page load
    coupleImages.classList.remove('animate');
    coupleImages.style.width = '53%'; // Default width
    
    // Track scroll direction
    window.addEventListener('scroll', function() {
        const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
        isScrollingDown = currentScrollTop > lastScrollTop;
        lastScrollTop = currentScrollTop;
        
        // Check section position on every scroll
        const rect = storySection.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const sectionTop = rect.top;
        const sectionBottom = rect.bottom;
        
        // Check if section is in viewport (when scrolling down from first section)
        if (sectionTop < windowHeight * 0.8 && sectionTop > -200 && sectionBottom > 0) {
            // Section is coming into view - animate images to come close
            if (isScrollingDown || sectionTop < windowHeight * 0.5) {
                coupleImages.classList.add('animate');
            }
        } else if (sectionTop > windowHeight || sectionBottom < -100) {
            // Section is out of view - reset to default width
            coupleImages.classList.remove('animate');
            coupleImages.style.width = '53%';
        }
    }, { passive: true });
    
    // Create Intersection Observer as backup
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Add animate class when section comes into view
                coupleImages.classList.add('animate');
            } else {
                // Remove animate class when section is out of view - reset to default width
                coupleImages.classList.remove('animate');
                coupleImages.style.width = '53%';
            }
        });
    }, {
        threshold: 0.2, // Trigger when 20% of section is visible
        rootMargin: '0px 0px -100px 0px'
    });
    
    // Observe the story section
    observer.observe(storySection);
});
