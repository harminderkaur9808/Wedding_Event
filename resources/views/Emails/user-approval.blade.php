@php
    $weddingDate = \App\Models\PageSection::weddingDate();
    $weddingDateFormatted = $weddingDate ? $weddingDate->format('d M, Y') : '31 Dec, 2027';
    $saveTheDate = $weddingDate ? $weddingDate->format('m-d-Y') : '01-01-2027';
    $baseUrl = config('app.url');
    $logoUrl = $baseUrl . '/Images/Email_template_logo/email_logo.png';
    $bannerUrl = $baseUrl . '/Images/Email_template_logo/maintitlebg.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved - {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Georgia, 'Times New Roman', serif; background-color: #f0f4f8; padding: 24px 16px; color: #333; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08); }
        .email-logo-block { text-align: center; padding: 40px 24px 20px; background: #fff; }
        .email-logo-block img { max-width: 140px; height: auto; display: inline-block; }
        .email-logo-block .couple-name { display: block; font-size: 22px; font-weight: 600; color: #2F4F75; margin-top: 14px; letter-spacing: 0.5px; }
        .email-banner {
            background-image: url('{{ $bannerUrl }}');
            background-size: cover;
            background-position: center;
            background-color: #E8F2F7;
            padding: 40px 28px;
            text-align: center;
        }
        .email-banner h1 { font-size: 26px; font-weight: 700; color: #1e3a52; margin-bottom: 10px; line-height: 1.3; font-family: Georgia, serif; }
        .email-banner .subheading { font-size: 16px; font-weight: 600; color: #2F4F75; }
        .email-body { padding: 36px 32px; line-height: 1.7; font-size: 15px; text-align: center; }
        .email-body .content-inner { text-align: left; max-width: 520px; margin: 0 auto; }
        .email-body .greeting { font-size: 16px; color: #1e3a52; margin-bottom: 24px; }
        .email-body .great-news { font-size: 22px; font-weight: 700; color: #1e3a52; margin-bottom: 16px; text-align: center; }
        .email-body .intro { color: #444; margin-bottom: 20px; text-align: center; }
        .email-body .access-heading { font-size: 15px; color: #1e3a52; margin: 24px 0 12px; }
        .email-body ul { margin: 0 0 24px 20px; color: #444; font-size: 15px; }
        .email-body ul li { margin: 8px 0; }
        .email-body .note-text { font-size: 14px; color: #444; margin: 20px 0; text-align: center; }
        .cta-button {
            display: inline-block;
            background: #2C3E50;
            color: #ffffff !important;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            margin: 24px 0;
            text-align: center;
        }
        .wedding-date-row { margin-top: 28px; padding-top: 24px; border-top: 1px solid #e2e8f0; text-align: left; }
        .wedding-date-row .calendar-icon { display: inline-block; width: 22px; height: 22px; vertical-align: middle; margin-right: 10px; }
        .wedding-date-row .date-text { font-size: 15px; font-weight: 600; color: #2F4F75; }
        .email-footer { padding: 32px 28px; text-align: center; background: #fafbfc; border-top: 1px solid #e2e8f0; }
        .email-footer .closing { font-size: 15px; color: #444; margin-bottom: 24px; line-height: 1.6; }
        .email-footer .signature { font-size: 16px; font-weight: 600; font-style: italic; color: #2F4F75; margin-bottom: 8px; }
        .email-footer .couple-name { font-size: 16px; font-weight: 700; font-style: italic; color: #2F4F75; margin-bottom: 24px; }
        .email-footer .save-the-date { font-size: 14px; color: #64748b; font-weight: 600; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-logo-block">
            <img src="{{ $logoUrl }}" alt="Vickram & Nisha" width="140">
            <span class="couple-name">Vickram & Nisha</span>
        </div>
        <div class="email-banner">
            <h1>Account Approved</h1>
            <p class="subheading">Welcome to Vikram & Nisha's Wedding</p>
        </div>
        <div class="email-body">
            <div class="content-inner">
                <p class="greeting">Dear {{ $user->first_name }} {{ $user->last_name }},</p>
                <p class="great-news">Great News!</p>
                <p class="intro">Your account for Vikram & Nisha's Wedding Website has been successfully approved.</p>
                <p class="access-heading">You can now log in and access:</p>
                <ul>
                    <li>Event schedules &amp; updates</li>
                    <li>Travel &amp; accommodation information</li>
                    <li>Photos &amp; videos</li>
                    <li>Appointment bookings</li>
                    <li>Family updates</li>
                </ul>
                <p style="text-align: center;">
                    <a href="{{ url('/login') }}" class="cta-button">Login to your account</a>
                </p>
                <p class="note-text"><strong>Note:</strong> Please use the login credentials that were sent to you in your welcome email.</p>
                <div class="wedding-date-row">
                    <svg class="calendar-icon" viewBox="0 0 24 24" fill="none" stroke="#2F4F75" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span class="date-text">Wedding Date: {{ $weddingDateFormatted }}</span>
                </div>
            </div>
        </div>
        <div class="email-footer">
            <p class="closing">We are so happy to have you join us and can not wait to celebrate together!</p>
            <p class="signature">With Love,</p>
            <p class="couple-name">Vickram & Nisha</p>
            <p class="save-the-date">Save The Date: {{ $saveTheDate }}</p>
        </div>
    </div>
</body>
</html>
