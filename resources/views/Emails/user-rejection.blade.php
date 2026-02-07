@php
    $weddingDate = \App\Models\PageSection::weddingDate();
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
    <title>Account Status Update - {{ config('app.name') }}</title>
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
        .email-body .intro { color: #444; margin-bottom: 20px; text-align: center; }
        .notice-box {
            background: #fef2f2;
            border-left: 4px solid #b91c1c;
            padding: 20px 22px;
            margin: 24px 0;
            border-radius: 0 8px 8px 0;
        }
        .notice-box .title { font-size: 18px; font-weight: 700; color: #b91c1c; margin-bottom: 10px; }
        .notice-box p { font-size: 15px; color: #444; margin: 0; line-height: 1.6; }
        .email-body .closing-text { font-size: 15px; color: #444; margin-top: 24px; text-align: center; }
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
            <h1>Account Not Approved</h1>
            <p class="subheading">Vikram & Nisha's Wedding Website</p>
        </div>
        <div class="email-body">
            <div class="content-inner">
                <p class="greeting">Dear {{ $user->first_name }} {{ $user->last_name }},</p>
                <p class="intro">Thank you for your interest in joining Vikram & Nisha's Wedding Website.</p>
                <div class="notice-box">
                    <p class="title">Account Status Update</p>
                    <p>We regret to inform you that your account registration has not been approved at this time. After careful review, we were unable to approve your account request.</p>
                </div>
                <p class="closing-text">If you believe this is an error or would like to discuss your registration, please contact us directly. We appreciate your understanding and thank you for your interest in being part of our celebration.</p>
            </div>
        </div>
        <div class="email-footer">
            <p class="closing">We wish you all the best.</p>
            <p class="signature">With Love,</p>
            <p class="couple-name">Vickram & Nisha</p>
            <p class="save-the-date">Save The Date: {{ $saveTheDate }}</p>
        </div>
    </div>
</body>
</html>
