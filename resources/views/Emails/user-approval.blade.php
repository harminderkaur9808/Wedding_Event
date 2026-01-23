<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Approved - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            font-size: 32px;
            font-weight: 400;
            margin-bottom: 10px;
            font-family: 'Vibur', cursive;
            letter-spacing: 2px;
        }
        .email-header p {
            font-size: 16px;
            opacity: 0.9;
        }
        .success-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }
        .decorative-divider {
            text-align: center;
            padding: 20px 0;
            color: #28a745;
        }
        .email-body {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.8;
        }
        .greeting {
            font-size: 20px;
            color: #28a745;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .content-text {
            font-size: 16px;
            color: #555555;
            margin-bottom: 25px;
        }
        .success-box {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 25px;
            margin: 30px 0;
            border-radius: 6px;
        }
        .success-box h3 {
            color: #155724;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .cta-button {
            display: inline-block;
            background: #28a745;
            color: #ffffff !important;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            margin: 25px 0;
            text-align: center;
        }
        .email-footer {
            background: #f9f9f9;
            padding: 30px;
            text-align: center;
            color: #666666;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
        }
        .footer-love {
            color: #2F4F75;
            font-style: italic;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="success-icon">✓</div>
            <h1>Account Approved!</h1>
            <p>Welcome to {{ config('app.name') }}</p>
        </div>
        
        <div class="decorative-divider">
            <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#28a745" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>

        <div class="email-body">
            <div class="greeting">Dear {{ $user->first_name }} {{ $user->last_name }},</div>
            
            <div class="success-box">
                <h3>🎉 Great News!</h3>
                <p style="color: #155724; margin: 0;">Your account has been approved by the administrator. You can now log in and access all features of the Wedding Event platform!</p>
            </div>

            <div class="content-text">
                We're excited to have you join us in celebrating this special occasion. You can now:
            </div>

            <ul style="color: #555555; font-size: 16px; margin-left: 20px; margin-bottom: 25px;">
                <li style="margin: 10px 0;">View and upload pictures and videos</li>
                <li style="margin: 10px 0;">Access all wedding event features</li>
                <li style="margin: 10px 0;">Connect with family and friends</li>
                <li style="margin: 10px 0;">Stay updated with event information</li>
            </ul>

            <div class="content-text">
                <strong>Note:</strong> Please use the login credentials that were sent to you in your welcome email.
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="cta-button">Login to Your Account</a>
            </div>

            <div class="content-text" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                We look forward to sharing this beautiful journey with you!
            </div>
        </div>

        <div class="email-footer">
            <div>
                <strong>{{ config('app.name') }}</strong><br>
                Wedding Event - Vickram & Nisha
            </div>
            <div style="margin-top: 15px;">
                Save The Date: 12-31-2026
            </div>
            <div class="footer-love">
                With Love & Joy ❤️
            </div>
        </div>
    </div>
</body>
</html>
