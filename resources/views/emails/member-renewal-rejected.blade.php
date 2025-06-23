<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renewal Rejected</title>
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
            color: #cfe4ff;
        }

        .email-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #e0e6f0;
            margin-bottom: 16px;
        }

        .email-content .message {
            font-size: 16px;
            line-height: 1.6;
            color: #e0e6f0;
            margin-bottom: 20px;
        }

        .custom-message {
            background-color: #1c2a47;
            padding: 12px 16px;
            border-left: 4px solid #ef4444;
            font-style: italic;
            font-size: 16px;
            color: #fecaca;
            margin-top: 20px;
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
        <!-- Header with Logo -->
        <div class="header">
            <img src="{{ asset('images/rec.png') }}" alt="Radio Engineering Circle">
        </div>

        <!-- Main Content -->
        <div class="email-content">
            <h1>Renewal Rejected</h1>
            <p>Hello {{ $memberName }},</p>

            <div class="message">
                <p>We're sorry to inform you that your renewal request has been <strong>rejected</strong>.</p>
                @if($remarks)
                    <p><strong>Remarks:</strong> {{ $remarks }}</p>
                @endif
            </div>

            <div class="custom-message">
                You may contact our support team if you have questions or need clarification.
            </div>

            <p>Best regards,<br /><strong>REC ON</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="social-icons">
                <a href="https://www.facebook.com/REC.org.ph">Facebook</a> | 
                <a href="mailto:support@rec.org.ph">Email</a>
            </div>
            <p>&copy; 2025 Radio Engineering Circle. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
