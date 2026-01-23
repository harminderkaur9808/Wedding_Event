<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Status Update - {{ config('app.name') }}</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .decorative-divider {
            text-align: center;
            padding: 20px 0;
            color: #dc3545;
        }
        .email-body {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.8;
        }
        .greeting {
            font-size: 20px;
            color: #dc3545;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .content-text {
            font-size: 16px;
            color: #555555;
            margin-bottom: 25px;
        }
        .notice-box {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 25px;
            margin: 30px 0;
            border-radius: 6px;
        }
        .notice-box h3 {
            color: #721c24;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .notice-box p {
            color: #721c24;
            margin: 0;
        }
        .email-footer {
            background: #f9f9f9;
            padding: 30px;
            text-align: center;
            color: #666666;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Account Status Update</h1>
            <p>{{ config('app.name') }}</p>
        </div>
        
        <div class="decorative-divider">
            <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#dc3545" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>

        <div class="email-body">
            <div class="greeting">Dear {{ $user->first_name }} {{ $user->last_name }},</div>
            
            <div class="content-text">
                Thank you for your interest in joining our Wedding Event platform.
            </div>

            <div class="notice-box">
                <h3>Account Status Update</h3>
                <p>We regret to inform you that your account registration has not been approved at this time. After careful review, we were unable to approve your account request.</p>
            </div>

            <div class="content-text">
                If you believe this is an error or would like to discuss your registration, please contact us directly. We appreciate your understanding.
            </div>

            <div class="content-text" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                Thank you for your interest in being part of our celebration.
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
        </div>
    </div>
</body>
</html>
