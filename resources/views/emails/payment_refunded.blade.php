<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Refunded</title>
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
        .refund-receipt {
            background-color: #1c2a47;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #38bdf8;
            margin: 20px 0;
        }
        .email-content {
            padding: 30px;
            text-align: left;
        }
        .email-content h1 {
            font-size: 22px;
            margin-bottom: 20px;
            color: #38bdf8;
        }
        .email-content p {
            font-size: 16px;
            line-height: 1.6;
            color: #e0e6f0;
            margin-bottom: 16px;
        }
        .refund-details {
            background-color: #1c2a47;
            padding: 12px 16px;
            border-left: 4px solid #38bdf8;
            font-style: italic;
            font-size: 16px;
            color: #bae6fd;
            margin-top: 10px;
            margin-bottom: 20px;
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
            <h1>Payment Refunded</h1>
            <p>Hello {{ $applicant->first_name }} {{ $applicant->last_name }},</p>
            <p>We have processed your payment refund. Please see the details below:</p>
            <div class="refund-details">
                Refunded Amount: <strong>₱{{ number_format($refundAmount, 2) }}</strong><br>
                @if($remarks)
                Remarks: {{ $remarks }}<br>
                @endif
            </div>
            @if($refundReceiptPath)
            <div class="refund-receipt">
                <p>Refund Receipt:</p>
                <img src="{{ asset('images/refund_receipts/' . $refundReceiptPath) }}" 
                    alt="Refund Receipt" 
                    style="max-width: 100%; height: auto; border: 1px solid #ccc; margin-top: 10px;">
            </div>
            @endif
            <p>If you have any questions or concerns, please reply to this email or contact our support team.</p>
            <p>Thank you for your patience.<br><strong>REC ON</strong></p>
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
