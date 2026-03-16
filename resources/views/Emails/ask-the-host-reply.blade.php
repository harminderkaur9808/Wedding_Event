@php
    $baseUrl = rtrim(config('app.url', ''), '/');
    $logoUrl = $baseUrl . '/Images/Email_template_logo/email_logo.png';
    $bannerUrl = $baseUrl . '/Images/Email_template_logo/maintitlebg.png';
    $leftDecorUrl = $baseUrl . '/Images/Email_template_logo/left_ICO.png';
    $rightDecorUrl = $baseUrl . '/Images/Email_template_logo/right_ICO.png';
    $bgImageUrl = $baseUrl . '/Images/Email_template_logo/bgimageoftheemail.png';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Question Was Answered - Ask the Host</title>
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
        .email-body .intro .intro-bold {
            font-weight: 700;
            color: #2F4F75;
        }
        .email-body .section-box {
            text-align: left;
            max-width: 460px;
            margin: 0 auto 20px;
            padding: 20px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
        }
        .email-body .section-heading {
            font-size: 14px;
            font-weight: 700;
            color: #2F4F75;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .email-body .section-content {
            color: #333;
            font-size: 15px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .email-body .reply-meta {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 12px;
        }
        .email-body .reply-meta .replied-by {
            font-weight: 700;
            color: #2F4F75;
        }
        .email-cta-row {
            margin: 20px 0 24px;
            text-align: center;
        }
        .email-cta-row .cta-label {
            font-size: 15px;
            color: #2F4F75;
            margin: 0 0 12px 0;
            display: block;
        }
        .email-cta-row .email-cta-btn {
            display: inline-block;
            background: #2F4F75;
            color: #fff !important;
            font-size: 15px;
            font-weight: 400;
            padding: 10px 24px;
            text-decoration: none;
            font-family: Georgia, serif;
            border-radius: 6px;
        }
        .email-cta-btn:hover {
            background: #1e3a52;
        }
        .email-body .note-text {
            font-size: 14px;
            color: #2F4F75;
            margin-top: 0;
        }
        .email-body .note-text strong { color: #2F4F75; }
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

        <div class="email-logo-block">
            <img src="{{ $logoUrl }}" alt="Vickram & Nisha" width="140">
        </div>

        <div class="email-banner">
            <h1>Your Question Was Answered</h1>
        </div>

        <div class="email-body">
            <div class="content-inner">
                <p class="greeting">Hello {{ $questionerName }},</p>
                @if(!empty($parentReply))
                <p class="intro">There is a new reply in a conversation you're part of on <span class="intro-bold">Ask the Host</span>.</p>
                @else
                <p class="intro">Great news! Someone has replied to your question on the <span class="intro-bold">Ask the Host</span> section.</p>
                @endif

                <div class="section-box">
                    <p class="section-heading">Original Question</p>
                    <p class="section-content">{{ e(preg_replace('/<br\s*\/?>/i', "\n", $questionText)) }}</p>
                </div>

                @if(!empty($parentReply) && !empty($parentReplyText))
                <div class="section-box">
                    <p class="reply-meta"><span class="replied-by">{{ $parentRepliedByName }}</span> wrote:</p>
                    <p class="section-content">{{ e(preg_replace('/<br\s*\/?>/i', "\n", $parentReplyText)) }}</p>
                </div>
                @endif

                <div class="section-box">
                    <p class="reply-meta"><span class="replied-by">{{ $repliedByName }}</span> replied on {{ $repliedAt }}</p>
                    <p class="section-heading">{{ !empty($parentReply) ? 'New Reply' : 'Answer' }}</p>
                    <p class="section-content">{{ e(preg_replace('/<br\s*\/?>/i', "\n", $replyText)) }}</p>
                </div>

                <div class="email-cta-row">
                    <span class="cta-label">View the full conversation</span>
                    <a href="{{ $viewUrl }}" class="email-cta-btn">View on Ask the Host</a>
                </div>

                <p class="note-text">You can log in at any time to see all replies and add more questions.</p>
            </div>
        </div>

        <div class="email-footer">
            <p class="signature"><span class="signature-intro">With Love,</span><br><span class="signature-names">Vickram & Nisha</span></p>
            <p class="save-the-date">Save The Date: <span class="save-the-date-value">{{ $saveTheDate }}</span></p>
        </div>
    </div>
</body>
</html>
