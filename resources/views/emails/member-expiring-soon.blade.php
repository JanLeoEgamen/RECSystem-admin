<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Renewal Reminder</title>
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
            background-color: #1a472a;
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
            color: #86efac;
        }

        .email-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #e0e6f0;
            margin-bottom: 16px;
        }

        .urgency-high {
            background-color: #7f1d1d;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #ef4444;
        }

        .urgency-medium {
            background-color: #854d0e;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #eab308;
        }

        .urgency-low {
            background-color: #1e3a8a;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #3b82f6;
        }

        .renew-button {
            display: inline-block;
            background-color: #16a34a;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0;
        }

        .renew-button:hover {
            background-color: #15803d;
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
            <h1>Membership Renewal Reminder</h1>
            <p>Hello {{ $user->first_name }} {{ $user->last_name }},</p>
            
            <p>This is a friendly reminder that your <strong>Radio Engineering Circle</strong> membership will expire soon.</p>

            <!-- Dynamic urgency message based on days left -->
            @if($daysLeft === 1)
            <div class="urgency-high">
                <strong>URGENT:</strong> Your membership expires in <strong>24 hours</strong>!
            </div>
            @elseif($daysLeft <= 3)
            <div class="urgency-medium">
                <strong>Important:</strong> Your membership expires in <strong>{{ $daysLeft }} days</strong>.
            </div>
            @else
            <div class="urgency-low">
                <strong>Reminder:</strong> Your membership expires in <strong>{{ $daysLeft }} days</strong>.
            </div>
            @endif

            <p>To continue enjoying all the benefits of your REC membership, please renew your membership before it expires.</p>

            @if($renewalUrl)
            <a href="{{ $renewalUrl }}" class="renew-button">Renew Your Membership</a>
            @endif

            <p>If you have any questions or need assistance with the renewal process, please don't hesitate to contact us.</p>

            <p>Thank you for being a valued member!<br /><strong>REC ON</strong></p>
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