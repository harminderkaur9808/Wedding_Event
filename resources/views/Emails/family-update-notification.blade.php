@php
    $baseUrl = rtrim(config('app.url', ''), '/');
    $logoUrl = $baseUrl . '/Images/Email_template_logo/email_logo.png';
    $bannerUrl = $baseUrl . '/Images/Email_template_logo/maintitlebg.png';
    $leftDecorUrl = $baseUrl . '/Images/Email_template_logo/left_ICO.png';
    $rightDecorUrl = $baseUrl . '/Images/Email_template_logo/right_ICO.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Update - Vikram & Nisha's Wedding</title>
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
            font-weight: 700;
            color: #2F4F75;
            margin-bottom: 12px;
        }
        .email-body .intro {
            color: #2F4F75;
            margin-bottom: 20px;
            font-weight: 400;
        }
        .email-body .update-heading {
            font-size: 16px;
            font-weight: 700;
            color: #2F4F75;
            margin: 24px 0 8px;
        }
        .email-body .update-content {
            color: #333;
            margin-bottom: 12px;
            font-weight: 400;
            text-align: left;
            max-width: 360px;
            margin-left: auto;
            margin-right: auto;
            white-space: pre-wrap;
        }
        .email-body .posted-by {
            font-size: 15px;
            color: #2F4F75;
            font-weight: 600;
            margin-bottom: 24px;
        }
        .email-cta-row {
            margin: 12px 0 24px;
            text-align: center;
        }
        .email-cta-row .cta-label {
            font-size: 15px;
            color: #2F4F75;
            margin: 0;
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }
        .email-cta-row .email-cta-btn {
            display: inline-block;
            vertical-align: middle;
        }
        .email-cta-btn {
            display: inline-block;
            background: #2F4F75;
            color: #fff !important;
            font-size: 15px;
            font-weight: 400;
            padding: 4px 11px;
            text-decoration: none;
            font-family: Georgia, serif;
            border-radius: 4px;
        }
        .email-cta-btn:hover {
            background: #1e3a52;
        }
        .email-body .closing-message {
            font-size: 15px;
            font-weight: 700;
            color: #2F4F75;
            margin-top: 0;
            line-height: 1.6;
        }
        .email-footer {
            padding: 32px 28px;
            text-align: center;
            background: #fafbfc;
            border-top: 1px solid #e2e8f0;
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
            <h1>Family Update</h1>
        </div>

        <div class="email-body">
            <div class="content-inner">
                <p class="greeting">Dear {{ $recipient->first_name }} {{ $recipient->last_name }},</p>
                <p class="intro">A new update has been shared on Vikram & Nisha's Wedding Website.</p>

                <p class="update-heading">Update information</p>
                <p class="update-content">{{ $familyUpdate->message }}</p>
                <p class="posted-by">Posted by: {{ $postedByName }}</p>

                <div class="email-cta-row">
                    <span class="cta-label">View Full Update</span>
                    <a href="{{ $viewUpdateUrl }}" class="email-cta-btn">Click here</a>
                </div>

                <p class="closing-message">Stay connected for more joyful moments, important announcements, and wedding details.</p>
            </div>
        </div>

        <div class="email-footer">
            <p class="signature"><span class="signature-intro">With Love,</span><br><span class="signature-names">Vickram & Nisha</span></p>
            <p class="save-the-date">Save The Date: <span class="save-the-date-value">{{ $saveTheDate }}</span></p>
        </div>
    </div>
</body>
</html>
