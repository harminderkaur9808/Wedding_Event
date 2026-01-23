<footer class="wedding-footer">
    <!-- Decorative left flower -->
    <div class="footer-left-flower">
        <img src="{{ asset('Images/footer/leftthalfflower.png') }}" alt="Left Flower" class="footer-flower-img">
    </div>

    <!-- Decorative right flower -->
    <div class="footer-right-flower">
        <img src="{{ asset('Images/footer/righthalfflower.png') }}" alt="Right Flower" class="footer-flower-img">
    </div>

    <div class="container">
        <div class="footer-content">
            <!-- Left Column - Brand/Couple Information -->
            <div class="footer-column footer-brand">
                <div class="footer-logo-section">
                    <img src="{{ asset('Images/footer/footer_logo_0.png') }}" alt="Wedding Logo" class="footer-logo">
                </div>
                <h3 class="footer-couple-names">Vickram & Nisha</h3>
                <p class="footer-description">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
                </p>
            </div>

            <!-- Middle Column - Quick Links -->
            <div class="footer-column footer-links">
                <h3 class="footer-heading">Quick Links</h3>
                <ul class="footer-link-list">
                    <li><a href="#" class="footer-link">Pictures And Videos</a></li>
                    <li><a href="#" class="footer-link">Ask The Host</a></li>
                    <li><a href="#" class="footer-link">Updates By Family</a></li>
                    <li><a href="#" class="footer-link">Lets Plan Our Outfits</a></li>
                    <li><a href="{{ route('book.appointments') }}" class="footer-link">Book Your Appointments</a></li>
                </ul>
            </div>

            <!-- Right Column - Contact Us -->
            <div class="footer-column footer-contact">
                <h3 class="footer-heading">Contact Us</h3>
                <ul class="footer-contact-list">
                    <li class="footer-contact-item">
                        <svg class="contact-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Dummy@gmail.com</span>
                    </li>
                    <li class="footer-contact-item">
                        <svg class="contact-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" stroke="currentColor" stroke-width="2"/>
                            <circle cx="12" cy="10" r="3" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        <span>Dummy@gmail.com</span>
                    </li>
                    <li class="footer-contact-item">
                        <svg class="contact-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>123456791</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Decorative Divider -->
        <div class="footer-divider">
            <img src="{{ asset('Images/footer/footer_down_p.png') }}" alt="Footer Decoration" class="footer-divider-img">
        </div>

        <!-- Copyright -->
        <div class="footer-copyright">
            <p>Copyright © 2026. All rights reserved.</p>
        </div>
    </div>
</footer>
