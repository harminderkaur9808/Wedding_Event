<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration - Approval Required</title>
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
            background: linear-gradient(135deg, #2F4F75 0%, #1e3a52 100%);
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
            color: #2F4F75;
        }
        .email-body {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.8;
        }
        .greeting {
            font-size: 20px;
            color: #2F4F75;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .content-text {
            font-size: 16px;
            color: #555555;
            margin-bottom: 25px;
        }
        .user-info-box {
            background: #f9f9f9;
            border-left: 4px solid #2F4F75;
            padding: 25px;
            margin: 30px 0;
            border-radius: 6px;
        }
        .user-info-box h3 {
            color: #2F4F75;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .info-item {
            margin: 12px 0;
            font-size: 15px;
        }
        .info-label {
            font-weight: 600;
            color: #333;
            display: inline-block;
            width: 140px;
        }
        .info-value {
            color: #2F4F75;
        }
        .cta-button {
            display: inline-block;
            background: #2F4F75;
            color: #ffffff !important;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            margin: 25px 0;
            text-align: center;
        }
        .alert-box {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 20px;
            border-radius: 6px;
            margin: 25px 0;
        }
        .alert-box strong {
            color: #856404;
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
            <h1>Wedding Event</h1>
            <p>Admin Notification</p>
        </div>
        
        <div class="decorative-divider">
            <svg width="60" height="20" viewBox="0 0 60 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5 10 L15 5 L25 10 L35 5 L45 10 L55 5" stroke="#2F4F75" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>

        <div class="email-body">
            <div class="greeting">Hello Administrator,</div>
            
            <div class="content-text">
                A new user has registered on the Wedding Event platform and requires your approval.
            </div>

            <div class="alert-box">
                <strong>Action Required:</strong> Please review the user details below and approve or reject their account from the admin dashboard.
            </div>

            <div class="user-info-box">
                <h3>New User Details</h3>
                <div class="info-item">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value">{{ $user->first_name }} {{ $user->last_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Family Relation:</span>
                    <span class="info-value">{{ $user->family_relation ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Registration Date:</span>
                    <span class="info-value">{{ $user->created_at->format('F d, Y h:i A') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value" style="color: #ff9800; font-weight: 600;">Pending Approval</span>
                </div>
            </div>

            <div class="content-text">
                Please log in to the admin dashboard to review and take action on this registration.
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/admin/dashboard?tab=all-users') }}" class="cta-button">Go to Admin Dashboard</a>
            </div>
        </div>

        <div class="email-footer">
            <div>
                <strong>{{ config('app.name') }}</strong><br>
                Wedding Event - Vickram & Nisha
            </div>
        </div>
    </div>
</body>
</html>
