@php
    $weddingDate = \App\Models\PageSection::weddingDate();
    $weddingDateFormatted = $weddingDate ? $weddingDate->format('F j, Y') : 'January 1, 2027';
    $saveTheDate = $weddingDate ? $weddingDate->format('m-d-Y') : '01-01-2027';
    $baseUrl = config('app.url');
    $logoUrl = $baseUrl . '/Images/Email_template_logo/email_logo.png';
    $bannerUrl = $baseUrl . '/Images/Email_template_logo/maintitlebg.png';
    $bgImageUrl = rtrim($baseUrl, '/') . '/Images/Email_template_logo/bgimageoftheemail.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your account has been created – {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Georgia, 'Times New Roman', serif; background-color: #f0f4f8; padding: 24px 16px; color: #333; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #ffffff url('{{ $bgImageUrl }}') center center no-repeat; background-size: cover; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08); }
        .email-logo-block { text-align: center; padding: 40px 24px 20px; background: #fff; }
        .email-logo-block img { max-width: 140px; height: auto; display: inline-block; }
        .email-logo-block .couple-name { display: block; font-size: 22px; font-weight: 600; color: #2F4F75; margin-top: 14px; letter-spacing: 0.5px; }
        .email-banner { background-image: url('{{ $bannerUrl }}'); background-size: cover; background-position: center; background-color: #E8F2F7; padding: 40px 28px; text-align: center; }
        .email-banner h1 { font-size: 26px; font-weight: 700; color: #1e3a52; margin-bottom: 10px; line-height: 1.3; font-family: Georgia, serif; }
        .email-banner .subheading { font-size: 16px; font-weight: 600; color: #2F4F75; }
        .email-body { padding: 36px 32px; line-height: 1.7; font-size: 15px; text-align: center; }
        .email-body .content-inner { text-align: left; max-width: 520px; margin: 0 auto; }
        .email-body .greeting { font-size: 16px; color: #333; margin-bottom: 18px; }
        .email-body .intro { color: #444; margin-bottom: 20px; }
        .admin-badge { display: inline-block; background: #E6F3FF; color: #2F4F75; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 20px; }
        .email-body .credentials-heading { font-size: 16px; font-weight: 700; color: #2F4F75; margin: 24px 0 12px; }
        .credentials-box { background: #f8fafc; border-left: 4px solid #2F4F75; padding: 18px 20px; margin: 16px 0 24px; border-radius: 0 8px 8px 0; }
        .credentials-box .credential-item { margin: 8px 0; font-size: 15px; }
        .credentials-box .credential-label { font-weight: 600; color: #333; }
        .credentials-box .credential-value { color: #2F4F75; font-weight: 600; }
        .cta-button { display: inline-block; background: #2C3E50; color: #ffffff !important; padding: 14px 32px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: 600; margin: 24px 0; text-align: center; }
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
            <h1>Account Created</h1>
            <p class="subheading">Welcome to Vikram & Nisha's Wedding Website</p>
        </div>
        <div class="email-body">
            <div class="content-inner">
                <p class="greeting">Dear {{ $user->first_name }} {{ $user->last_name }},</p>
                <p class="admin-badge">Account created by administrator</p>
                <p class="intro">An administrator has created an account for you on Vikram & Nisha's Wedding Website. Your account is ready and you can log in now.</p>
                <p class="credentials-heading">Please use the following credentials to sign in:</p>
                <div class="credentials-box">
                    <div class="credential-item"><span class="credential-label">Email: </span><span class="credential-value">{{ $user->email }}</span></div>
                    <div class="credential-item"><span class="credential-label">Password: </span><span class="credential-value">{{ $password }}</span></div>
                </div>
                <p class="intro">You can access your account now. Use the button below to log in.</p>
                <p style="text-align: center;">
                    <a href="{{ url('/login') }}" class="cta-button">Log in to your account</a>
                </p>
                <p class="intro" style="margin-top: 24px; padding-top: 20px; border-top: 1px solid #e2e8f0;">If you did not expect this email or have any questions, please contact the administrator.</p>
                <div class="wedding-date-row">
                    <svg class="calendar-icon" viewBox="0 0 24 24" fill="none" stroke="#2F4F75" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span class="date-text">Wedding Date: {{ $weddingDateFormatted }}</span>
                </div>
            </div>
        </div>
        <div class="email-footer">
            <p class="closing">We are excited to celebrate this beautiful journey together and look forward to sharing all event details with you soon.</p>
            <p class="signature">With Love,</p>
            <p class="couple-name">Vickram & Nisha</p>
            <p class="save-the-date">Save The Date: {{ $saveTheDate }}</p>
        </div>
    </div>
</body>
</html>
