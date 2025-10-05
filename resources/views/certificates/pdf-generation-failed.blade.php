<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Generation Failed</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        
        .icon {
            font-size: 64px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 28px;
        }
        
        .message {
            color: #7f8c8d;
            margin-bottom: 30px;
            line-height: 1.6;
            font-size: 16px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin: 10px;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }
        
        .error-details {
            background: #ecf0f1;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 12px;
            color: #7f8c8d;
            text-align: left;
        }
        
        .recommendation {
            background: #e8f5e8;
            border-left: 4px solid #27ae60;
            padding: 15px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .recommendation h3 {
            color: #27ae60;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        
        .recommendation p {
            margin: 0;
            color: #2c3e50;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">📄❌</div>
        
        <h1>PDF Generation Failed</h1>
        
        <p class="message">
            We're sorry, but there was an issue generating the PDF certificate. 
            This might be due to complex formatting or temporary server issues.
        </p>
        
        <div class="recommendation">
            <h3>💡 Recommended Alternative</h3>
            <p>Download as a high-quality image instead! It preserves the exact design and prints beautifully.</p>
        </div>
        
        <div style="margin: 30px 0;">
            <a href="{{ $image_download_url }}" class="btn btn-primary">
                📸 Download as Image (Recommended)
            </a>
            
            <a href="javascript:history.back()" class="btn btn-secondary">
                ← Go Back
            </a>
        </div>
        
        @if(config('app.debug') && isset($error_message))
        <details class="error-details">
            <summary style="cursor: pointer; font-weight: bold;">Technical Details (for developers)</summary>
            <pre style="margin: 10px 0; white-space: pre-wrap;">{{ $error_message }}</pre>
        </details>
        @endif
        
        <p style="font-size: 12px; color: #bdc3c7; margin-top: 30px;">
            Certificate ID: {{ $certificate_id }}{{ isset($member_id) && $member_id ? ' | Member ID: ' . $member_id : '' }}
        </p>
    </div>

    <script>
        // Auto-redirect to image download after 5 seconds
        setTimeout(function() {
            if (confirm('Would you like to automatically download the certificate as an image?')) {
                window.location.href = '{{ $image_download_url }}';
            }
        }, 3000);
    </script>
</body>
</html>