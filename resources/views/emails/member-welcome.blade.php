<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Radio Engineering Circle</title>
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #0b1a33;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #112244;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.5);
            color: #ffffff;
        }

        .header {
            background-color: #1e3a8a;
            height: 115px;
            padding: 0;
            overflow: hidden;
        }

        .header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .email-content {
            padding: 30px;
            text-align: left;
        }

        .email-content h1 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #60a5fa;
        }

        .email-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #e0e6f0;
            margin-bottom: 16px;
        }

        .credentials-box {
            background-color: #1c2a47;
            padding: 16px;
            border-left: 4px solid #3b82f6;
            margin: 20px 0;
            border-radius: 4px;
        }

        .credentials-box strong {
            color: #60a5fa;
        }

        .email-address {
            color: #ffffff !important;
            font-weight: bold;
        }

        .verification-button {
            display: inline-block;
            background-color: #3b82f6;
            color: #ffffff !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }

        .verification-button:hover {
            background-color: #2563eb;
            color: #ffffff !important;
        }

        .security-note {
            background-color: #1e293b;
            padding: 12px 16px;
            border-left: 4px solid #f59e0b;
            font-size: 14px;
            color: #fbbf24;
            margin-top: 10px;
            border-radius: 4px;
        }

        .footer {
            background-color: #0f172a;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
        }

        .social-icons {
            margin: 10px 0;
        }

        .social-icons a {
            margin: 0 10px;
            color: #cbd5e1;
            text-decoration: none;
            font-size: 16px;
        }

        .social-icons a:hover {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('images/rec.png') }}" alt="Radio Engineering Circle">
        </div>

        <!-- Main Content -->
        <div class="email-content">
            <h1>Welcome to Radio Engineering Circle!</h1>

            <p>Hello <strong>{{ $member->first_name }} {{ $member->last_name }}</strong>,</p>

            <p>Your member account has been successfully created. Here are your login credentials:</p>

            <div class="credentials-box">
                <p><strong>Email/Username:</strong> <span class="email-address">{{ $user->email }}</span></p>
                <p><strong>Password:</strong> {{ $plainPassword }}</p>
                <p><strong>Record Number:</strong> {{ $member->rec_number }}</p>
            </div>

            <p>Please verify your email address by clicking the button below:</p>

            <div style="text-align: center;">
                <a href="{{ $verificationUrl }}" class="verification-button">
                    Verify Email Address
                </a>
            </div>

            <div class="security-note">
                <strong>Security Note:</strong> For your security, we recommend changing your password after your first login.
            </div>

            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

            <p>Welcome aboard!<br><strong>REC ON</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-icons">
                <a href="https://www.facebook.com/REC.org.ph">Facebook</a> | 
                <a href="mailto:support@rec.org.ph">Email</a>
            </div>
            <p>&copy; {{ date('Y') }} Radio Engineering Circle. All rights reserved.</p>
        </div>
    </div>
</body>
</html>