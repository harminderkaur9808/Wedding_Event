@php
    $weddingDate = \App\Models\PageSection::weddingDate();
    $saveTheDate = $weddingDate ? $weddingDate->format('m-d-Y') : '12-31-2026';
    $baseUrl = config('app.url');
    $logoUrl = $baseUrl . '/Images/Email_template_logo/email_logo.png';
    $bannerUrl = $baseUrl . '/Images/Email_template_logo/maintitlebg.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration - Approval Required</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Georgia, 'Times New Roman', serif; background-color: #f0f4f8; padding: 24px 16px; color: #333; }
        .email-wrapper { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08); }
        .email-logo-block { text-align: center; padding: 40px 24px 20px; background: #fff; }
        .email-logo-block img { max-width: 140px; height: auto; display: inline-block; }
        .email-logo-block .couple-name { display: block; font-size: 22px; font-weight: 600; color: #2F4F75; margin-top: 14px; letter-spacing: 0.5px; }
        .email-banner { background-image: url('{{ $bannerUrl }}'); background-size: cover; background-position: center; background-color: #E8F2F7; padding: 40px 28px; text-align: center; }
        .email-banner h1 { font-size: 26px; font-weight: 700; color: #1e3a52; margin-bottom: 10px; line-height: 1.3; font-family: Georgia, serif; }
        .email-banner .subheading { font-size: 16px; font-weight: 600; color: #2F4F75; }
        .email-body { padding: 36px 32px; line-height: 1.7; font-size: 15px; text-align: center; }
        .email-body .content-inner { text-align: left; max-width: 520px; margin: 0 auto; }
        .email-body .greeting { font-size: 16px; color: #1e3a52; margin-bottom: 20px; }
        .email-body .intro { color: #444; margin-bottom: 20px; text-align: center; }
        .alert-box { background: #fff8e6; border-left: 4px solid #e6b800; padding: 18px 20px; margin: 24px 0; border-radius: 0 8px 8px 0; }
        .alert-box strong { color: #2F4F75; }
        .user-info-box { background: #f8fafc; border-left: 4px solid #2F4F75; padding: 18px 20px; margin: 16px 0 24px; border-radius: 0 8px 8px 0; }
        .user-info-box h3 { color: #2F4F75; font-size: 16px; font-weight: 700; margin-bottom: 12px; }
        .user-info-box .info-item { margin: 8px 0; font-size: 15px; }
        .user-info-box .info-label { font-weight: 600; color: #333; display: inline-block; min-width: 140px; }
        .user-info-box .info-value { color: #2F4F75; }
        .cta-button { display: inline-block; background: #2C3E50; color: #ffffff !important; padding: 14px 32px; text-decoration: none; border-radius: 8px; font-size: 16px; font-weight: 600; margin: 24px 0; text-align: center; }
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
            <h1>New User – Approval Required</h1>
            <p class="subheading">Admin Notification – Vikram & Nisha's Wedding Website</p>
        </div>
        <div class="email-body">
            <div class="content-inner">
                <p class="greeting">Hello Administrator,</p>
                <p class="intro">A new user has registered on Vikram & Nisha's Wedding Website and requires your approval.</p>
                <div class="alert-box">
                    <strong>Action Required:</strong> Please review the user details below and approve or reject their account from the admin dashboard.
                </div>
                <div class="user-info-box">
                    <h3>New User Details</h3>
                    <div class="info-item"><span class="info-label">Full Name:</span><span class="info-value">{{ $user->first_name }} {{ $user->last_name }}</span></div>
                    <div class="info-item"><span class="info-label">Email:</span><span class="info-value">{{ $user->email }}</span></div>
                    <div class="info-item"><span class="info-label">Phone:</span><span class="info-value">{{ $user->phone ?? 'N/A' }}</span></div>
                    <div class="info-item"><span class="info-label">Family Relation:</span><span class="info-value">{{ $user->family_relation ?? 'N/A' }}</span></div>
                    <div class="info-item"><span class="info-label">Registration Date:</span><span class="info-value">{{ $user->created_at->format('F d, Y h:i A') }}</span></div>
                    <div class="info-item"><span class="info-label">Status:</span><span class="info-value" style="color: #e67e22; font-weight: 600;">Pending Approval</span></div>
                </div>
                <p class="intro">Please log in to the admin dashboard to review and take action on this registration.</p>
                <p style="text-align: center;">
                    <a href="{{ url('/admin/dashboard?tab=all-users') }}" class="cta-button">Go to Admin Dashboard</a>
                </p>
            </div>
        </div>
        <div class="email-footer">
            <p class="closing">{{ config('app.name') }} – Wedding Event</p>
            <p class="signature">With Love,</p>
            <p class="couple-name">Vickram & Nisha</p>
            <p class="save-the-date">Save The Date: {{ $saveTheDate }}</p>
        </div>
    </div>
</body>
</html>
