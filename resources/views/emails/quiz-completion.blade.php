<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Completion</title>
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
        .quiz-results {
            background-color: #1a2d52;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .quiz-results p {
            margin: 8px 0;
        }
        .quiz-results strong {
            color: #cfe4ff;
        }
        .grade {
            font-size: 24px;
            font-weight: bold;
            color: @if($percentage >= 80) #4ade80 @elseif($percentage >= 60) #fbbf24 @else #f87171 @endif;
        }
        .email-content .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #3b82f6;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
        }
        .email-content .button:hover {
            background-color: #2563eb;
        }
        .footer {
            background-color: #0f172a;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="{{ asset('images/rec.png') }}" alt="Radio Engineering Circle">
        </div>

        <div class="email-content">
            <h1>Quiz Submission Confirmation</h1>
            <p>Dear {{ $name }},</p>
            
            <p>Thank you for completing the <strong>{{ $quizTitle }}</strong> quiz. Here are your results:</p>

            <div class="quiz-results">
                <p><strong>Score:</strong> {{ $score }} out of {{ $totalPoints }}</p>
                <p><strong>Percentage:</strong> {{ number_format($percentage, 2) }}%</p>
                <p><strong>Grade:</strong> <span class="grade">{{ $grade }}</span></p>
                <p><strong>Completion Date:</strong> {{ $completionDate }}</p>
            </div>

            <p>You can view your detailed results by clicking the button below:</p>

            <a href="{{ $resultLink }}" class="button">View Quiz Results</a>

            <p>If you have any questions about your results, please contact our support team.</p>

            <p>Best regards,<br /><strong>The REC Quiz Team</strong></p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Radio Engineering Circle. All rights reserved.</p>
        </div>
    </div>
</body>
</html>