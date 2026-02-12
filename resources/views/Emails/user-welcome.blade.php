@php
    $baseUrl = rtrim(config('app.url', ''), '/');
    $logoUrl = $baseUrl . '/Images/Email_template_logo/email_logo.png';
    $bannerUrl = $baseUrl . '/Images/Email_template_logo/maintitlebg.png';
    $heartIconUrl = $baseUrl . '/Images/Email_template_logo/Heartcleander.png';
    $leftDecorUrl = $baseUrl . '/Images/Email_template_logo/left_ICO.png';
    $rightDecorUrl = $baseUrl . '/Images/Email_template_logo/right_ICO.png';
    $bgImageUrl = $baseUrl . '/Images/Email_template_logo/bgimageoftheemail.png';
    try {
        $weddingDate = \App\Models\PageSection::weddingDate();
        $weddingDateFormatted = $weddingDate ? $weddingDate->format('j M, Y') : '31 Dec, 2027';
        $saveTheDate = $weddingDate ? $weddingDate->format('m-d-Y') : '01-01-2027';
    } catch (\Throwable $e) {
        $weddingDateFormatted = '31 Dec, 2027';
        $saveTheDate = '01-01-2027';
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Vikram & Nisha's Wedding Website</title>
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
            background: #ffffff url('{{ $bgImageUrl }}') center center no-repeat;
            background-size: cover;
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
            font-size: 26px;
            font-weight: 700;
            color: #2F4F75;
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
            color: #054C82;
            margin-bottom: 18px;
        }
        .email-body .intro {
            color: #054C82;
            margin-bottom: 16px;
            font-weight: 600;
        }
        .email-body .intro-highlight {
            font-weight: 700;
            color: #054C82;
            text-decoration: none;
        }
        .email-body .credentials-heading {
            font-size: 16px;
            font-weight: 700;
            color: #2F4F75;
            margin: 24px 0 12px;
            text-align: center;
        }
        .credentials-plain {
            margin: 0 0 24px;
            text-align: center;
        }
        .credentials-plain .credential-item {
            margin: 6px 0;
            font-size: 15px;
            color: #054C82;
            font-weight: 700;
        }
        .credentials-plain .credential-label,
        .credentials-plain .credential-value {
            font-weight: 400;
            color: #054C82;
        }
        .important-notice {
            padding: 0;
            margin: 20px 0;
            font-size: 14px;
            color: #054C82;
            text-align: left;
        }
        .important-notice strong { color: #054C82; }
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
            font-weight: 400;
            color: #054C82;
        }
        .email-footer {
            padding: 32px 28px;
            text-align: center;
            background: #fafbfc;
            border-top: 1px solid #e2e8f0;
        }
        .email-footer .closing {
            font-size: 15px;
            color: #054C82;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .email-footer .signature {
            font-size: 16px;
            margin-bottom: 24px;
        }
        .email-footer .signature-intro {
            color: #054C82;
            font-weight: 400;
        }
        .email-footer .signature-names {
            color: #054C82;
            font-weight: 700;
            font-size: 17px;
        }
        .email-footer .save-the-date {
            font-size: 14px;
            font-weight: 700;
            color: #054C82;
        }
        .email-footer .save-the-date-value {
            font-weight: 700;
            color: #054C82;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">

        <div class="email-logo-block">
            <img src="{{ $logoUrl }}" alt="Vickram & Nisha" width="140">
        </div>

        <div class="email-banner">
            <h1>Welcome to Vikram & Nisha's Wedding Website!</h1>
            <p class="subheading">Your Access Request is Pending Approval</p>
        </div>

        <div class="email-body">
            <div class="content-inner">
                <p class="greeting">Dear {{ $user->first_name }} {{ $user->last_name }},</p>
                <p class="intro">Thank you for joining Vikram & Nisha's Wedding Website.</p>
                <p class="intro">Your account has been successfully created and is currently <span class="intro-highlight">pending approval by the host.</span></p>

                <p class="credentials-heading">Please find your login credentials below:</p>
                <div class="credentials-plain">
                    <div class="credential-item"><span class="credential-label">Email: </span><span class="credential-value">{{ $user->email }}</span></div>
                    <div class="credential-item"><span class="credential-label">Password: </span><span class="credential-value">{{ $password }}</span></div>
                </div>

                <div class="important-notice">
                    <strong>Important:</strong> Your account is currently pending approval. You will receive an email notification once your account has been approved by the administrator. After approval, you'll be able to log in and access all features.
                </div>

                <div class="wedding-date-wrap">
                    <div class="wedding-date-row">
                        <img src="{{ $heartIconUrl }}" alt="Wedding date" class="calendar-icon" width="28" height="28">
                        <span class="date-label">Wedding Date: </span><span class="date-value">{{ $weddingDateFormatted }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="email-footer">
            <p class="closing">We are excited to celebrate this beautiful journey together and look forward to sharing all event details with you soon.</p>
            <p class="signature"><span class="signature-intro">With Love,</span><br><span class="signature-names">Vickram & Nisha</span></p>
            <p class="save-the-date">Save The Date: <span class="save-the-date-value">{{ $saveTheDate }}</span></p>
        </div>
    </div>
</body>
</html>
