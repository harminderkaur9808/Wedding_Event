<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your account has been created – {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Georgia', 'Times New Roman', serif; background-color: #f5f5f5; padding: 20px; }
        .email-container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); }
        .email-header { background: linear-gradient(135deg, #2F4F75 0%, #1e3a52 100%); padding: 40px 30px; text-align: center; color: #ffffff; }
        .email-header h1 { font-size: 32px; font-weight: 400; margin-bottom: 10px; font-family: 'Vibur', cursive; letter-spacing: 2px; }
        .email-header p { font-size: 16px; opacity: 0.9; }
        .decorative-divider { text-align: center; padding: 20px 0; color: #2F4F75; }
        .email-body { padding: 40px 30px; color: #333333; line-height: 1.8; }
        .greeting { font-size: 20px; color: #2F4F75; margin-bottom: 20px; font-weight: 600; }
        .content-text { font-size: 16px; color: #555555; margin-bottom: 25px; }
        .admin-badge { display: inline-block; background: #E6F3FF; color: #2F4F75; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 20px; }
        .credentials-box { background: #f9f9f9; border-left: 4px solid #2F4F75; padding: 25px; margin: 30px 0; border-radius: 6px; }
        .credentials-box h3 { color: #2F4F75; font-size: 18px; margin-bottom: 15px; font-weight: 600; }
        .credential-item { margin: 12px 0; font-size: 15px; }
        .credential-label { font-weight: 600; color: #333; display: inline-block; width: 100px; }
        .credential-value { color: #2F4F75; font-family: 'Courier New', monospace; font-weight: 600; }
        .cta-button { display: inline-block; background: #2F4F75; color: #ffffff !important; padding: 15px 40px; text-decoration: none; border-radius: 6px; font-size: 16px; font-weight: 600; margin: 25px 0; text-align: center; }
        .email-footer { background: #f9f9f9; padding: 30px; text-align: center; color: #666666; font-size: 14px; border-top: 1px solid #e0e0e0; }
        .footer-text { margin-bottom: 10px; }
        .footer-love { color: #2F4F75; font-style: italic; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Wedding Event</h1>
            <p>Vickram & Nisha</p>
        </div>
        <div class="decorative-divider">
            <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#2F4F75" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="email-body">
            <div class="greeting">Dear {{ $user->first_name }} {{ $user->last_name }},</div>
            <div class="admin-badge">Account created by administrator</div>
            <div class="content-text">
                An administrator has created an account for you on our Wedding Event platform. Your account is ready and you can log in now.
            </div>
            <div class="content-text">
                Please use the following credentials to sign in:
            </div>
            <div class="credentials-box">
                <h3>Your login details</h3>
                <div class="credential-item">
                    <span class="credential-label">Email:</span>
                    <span class="credential-value">{{ $user->email }}</span>
                </div>
                <div class="credential-item">
                    <span class="credential-label">Password:</span>
                    <span class="credential-value">{{ $password }}</span>
                </div>
            </div>
            <div class="content-text">
                <strong>You can access your account now.</strong> Use the button below to log in.
            </div>
            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="cta-button">Log in to your account</a>
            </div>
            <div class="content-text" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                If you did not expect this email or have any questions, please contact the administrator.
            </div>
        </div>
        <div class="email-footer">
            <div class="footer-text"><strong>{{ config('app.name') }}</strong><br>Wedding Event – Vickram & Nisha</div>
            <div class="footer-text" style="margin-top: 15px;">Save The Date: 12-31-2026</div>
            <div class="footer-love">With Love & Joy ❤️</div>
        </div>
    </div>
</body>
</html>
