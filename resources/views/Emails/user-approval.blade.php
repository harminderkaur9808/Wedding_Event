@php
    $baseUrl = rtrim(config('app.url', ''), '/');
    $logoUrl = $baseUrl . '/Images/Email_template_logo/email_logo.png';
    $bannerUrl = $baseUrl . '/Images/Email_template_logo/maintitlebg.png';
    $heartIconUrl = $baseUrl . '/Images/Email_template_logo/Heartcleander.png';
    $leftDecorUrl = $baseUrl . '/Images/Email_template_logo/left_ICO.png';
    $rightDecorUrl = $baseUrl . '/Images/Email_template_logo/right_ICO.png';
    try {
        $weddingDate = \App\Models\PageSection::weddingDate();
        $weddingDateFormatted = $weddingDate ? $weddingDate->format('j M, Y') : '31 Dec, 2027';
        $saveTheDate = $weddingDate ? $weddingDate->format('m-d-Y') : '01-01-2027';
    } catch (\Throwable $e) {
        $weddingDateFormatted = '31 Dec, 2027';
        $saveTheDate = '01-01-2027';
    }
    $loginUrl = url('/login');
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved - Vikram & Nisha's Wedding</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Georgia, 'Times New Roman', serif;
            background-color: #e8eef4;
            padding: 24px 16px;
            color: #333;
        }
        .email-wrapper {
            position: relative;
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            background: #ffffff;
            overflow: hidden;
        }
        .email-decor-left,
        .email-decor-right {
            position: absolute;
            top: 39%;
            width: 126px;
            max-width: 55%;
            object-fit: contain;
            object-position: center;
            pointer-events: none;
            z-index: 17;
        }
        .email-decor-left { left: 0; }
        .email-decor-right { right: 0; }
        .email-wrapper .email-logo-block,
        .email-wrapper .email-banner,
        .email-wrapper .email-body,
        .email-wrapper .email-footer {
            position: relative;
            z-index: 1;
        }
        .email-logo-block {
            text-align: center;
            padding: 40px 24px 20px;
            background: #fff;
        }
        .email-logo-block img {
            max-width: 140px;
            height: auto;
            display: inline-block;
        }
        .email-banner {
            background-image: url('{{ $bannerUrl }}');
            background-size: cover;
            background-position: center;
            background-color: #b8d4e8;
            padding: 40px 28px;
            text-align: center;
        }
        .email-banner h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1e3a52;
            margin-bottom: 10px;
            line-height: 1.3;
            font-family: Georgia, serif;
        }
        .email-banner .subheading {
            font-size: 16px;
            font-weight: 600;
            color: #2F4F75;
        }
        .email-body {
            padding: 36px 32px;
            line-height: 1.7;
            font-size: 15px;
            text-align: center;
        }
        .email-body .content-inner {
            text-align: center;
            max-width: 520px;
            margin: 0 auto;
        }
        .email-body .greeting {
            font-size: 16px;
            color: #2F4F75;
            margin-bottom: 12px;
        }
        .email-body .great-news {
            font-size: 22px;
            font-weight: 700;
            color: #2F4F75;
            margin-bottom: 16px;
        }
        .email-body .intro {
            color: #2F4F75;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .email-body .access-intro {
            font-size: 15px;
            font-weight: 600;
            color: #2F4F75;
            margin: 24px 0 12px;
        }
        .email-body .access-list {
            list-style: none;
            text-align: left;
            max-width: 320px;
            margin: 0 auto 24px;
            padding-left: 24px;
            color: #2F4F75;
            font-size: 15px;
        }
        .email-body .access-list li {
            padding: 3px 0;
            padding-left: 0;
            margin-left: 0;
            position: relative;
            display: block;
        }
        .email-body .access-list .list-bullet {
            font-weight: 700;
            color: #2F4F75;
            margin-right: 8px;
        }
        .email-cta-wrap {
            margin: 28px 0 24px;
        }
        .email-cta-btn {
            display: inline-block;
            background: #2F4F75;
            color: #fff !important;
            font-size: 15px;
            font-weight: 400;
            padding: 9px 16px;
            text-decoration: none;
            font-family: Georgia, serif;
        }
        .email-cta-btn:hover {
            background: #1e3a52;
        }
        .email-body .note-text {
            font-size: 14px;
            color: #2F4F75;
            margin-top: 20px;
        }
        .email-body .note-text strong { color: #2F4F75; }
        .wedding-date-wrap {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }
        .wedding-date-row {
            display: inline-block;
            background: #E9F6FF;
            border: 1px solid #b8d4e8;
            padding: 7px 11px;
            text-align: left;
        }
        .wedding-date-row .calendar-icon {
            display: inline-block;
            width: 28px;
            height: 28px;
            vertical-align: middle;
            margin-right: 10px;
            object-fit: contain;
        }
        .wedding-date-row .date-label,
        .wedding-date-row .date-value {
            font-size: 15px;
            font-weight: 700;
            color: #2F4F75;
        }
        .email-footer {
            padding: 32px 28px;
            text-align: center;
            background: #fafbfc;
            border-top: 1px solid #e2e8f0;
        }
        .email-footer .closing {
            font-size: 15px;
            color: #2F4F75;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .email-footer .signature {
            font-size: 16px;
            margin-bottom: 24px;
        }
        .email-footer .signature-intro {
            color: #2F4F75;
            font-weight: 400;
        }
        .email-footer .signature-names {
            color: #2F4F75;
            font-weight: 700;
            font-size: 18px;
            font-style: italic;
        }
        .email-footer .save-the-date {
            font-size: 14px;
            font-weight: 400;
            color: #2F4F75;
        }
        .email-footer .save-the-date-value {
            font-weight: 700;
            color: #2F4F75;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <img src="{{ $leftDecorUrl }}" alt="" class="email-decor-left" aria-hidden="true">
        <img src="{{ $rightDecorUrl }}" alt="" class="email-decor-right" aria-hidden="true">
        <div class="email-logo-block">
            <img src="{{ $logoUrl }}" alt="Vickram & Nisha" width="140">
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

                <p class="access-intro">You can now log in and access:</p>
                <ul class="access-list">
                    <li><span class="list-bullet">•</span> Event schedules &amp; updates</li>
                    <li><span class="list-bullet">•</span> Travel &amp; accommodation information</li>
                    <li><span class="list-bullet">•</span> Photos &amp; videos</li>
                    <li><span class="list-bullet">•</span> Appointment bookings</li>
                    <li><span class="list-bullet">•</span> Family updates</li>
                </ul>

                <div class="email-cta-wrap">
                    <a href="{{ $loginUrl }}" class="email-cta-btn">Login to your account</a>
                </div>

                <p class="note-text"><strong>Note:</strong> Please use the login credentials that were sent to you in your welcome email.</p>

                <div class="wedding-date-wrap">
                    <div class="wedding-date-row">
                        <img src="{{ $heartIconUrl }}" alt="Wedding date" class="calendar-icon" width="28" height="28">
                        <span class="date-label">Wedding Date: </span><span class="date-value">{{ $weddingDateFormatted }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="email-footer">
            <p class="closing">We are so happy to have you join us and can not wait to celebrate together!</p>
            <p class="signature"><span class="signature-intro">With Love,</span><br><span class="signature-names">Vickram & Nisha</span></p>
            <p class="save-the-date">Save The Date: <span class="save-the-date-value">{{ $saveTheDate }}</span></p>
        </div>
    </div>
</body>
</html>
