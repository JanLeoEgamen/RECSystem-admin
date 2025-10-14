<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Membership</title>
    <!-- Embedded FS Elliot Pro font using link method -->
    <link href="https://fonts.cdnfonts.com/css/fs-elliot-pro" rel="stylesheet">
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'FS Elliot Pro', sans-serif;
        }
        
        .certificate-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .certificate-container.standalone {
            min-height: 100vh;
            padding: 2rem;
            margin: 0;
            box-sizing: border-box;
        }
        
        .certificate-container.embedded {
            min-height: auto;
            padding: 2rem 0;
            margin-top: 0;
        }

        /* NEW: Recipient section styles */
        .recipient-section {
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .certifies-text {
            font-size: 1.25rem;
            margin-bottom: 3mm;
        }

        .name-container {
            display: inline-block;
            width: 70%;
            margin: 0 auto;
        }

        .recipient-name {
            font-size: 2.5rem;
            font-weight: 800;
            color: #041c5c;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1;
            margin-bottom: 0;
            padding-bottom: 2mm; /* Space between name and line */
        }

        .name-line {
            border-bottom: 2px solid black;
            width: 100%;
            height: 2mm;
            margin-top: 0;
            margin-bottom: 5mm;
        }

        /* Embedded styles for image generation */
        .certificate-container.embedded .recipient-section {
            margin-bottom: 0.5rem !important;
        }

        .certificate-container.embedded .certifies-text {
            font-size: 1.25rem !important;
            margin-bottom: 3mm !important;
        }

        .certificate-container.embedded .name-container {
            display: inline-block !important;
            width: 70% !important;
            margin: 0 auto !important;
        }

        .certificate-container.embedded .recipient-name {
            font-size: 2.5rem !important;
            font-weight: 800 !important;
            color: #041c5c !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            line-height: 1 !important;
            margin-bottom: 0 !important;
            padding-bottom: 2mm !important;
        }

        .certificate-container.embedded .name-line {
            border-bottom: 2px solid black !important;
            width: 100% !important;
            height: 2mm !important;
            margin-top: 0 !important;
            margin-bottom: 5mm !important;
        }
        
        .certificate-container.embedded .certificate {
            max-width: 100%;
            width: 100%;
            height: auto;
            min-height: 60vh;
        }
        
        /* Ensure consistent spacing between embedded and standalone modes */
        .certificate-container.standalone .header-image {
            margin-bottom: 0.5rem;
        }
        
        .certificate-container.standalone .certificate-title span {
            padding-bottom: 1mm;
            margin-bottom: 5mm;
        }

        /* Ensure consistent rendering for image generation */
        .certificate-container.embedded .certificate {
            width: 297mm !important;
            height: 210mm !important;
            margin: 0 !important;
            padding: 15mm !important;
            box-shadow: none !important;
        }

        /* Force specific heights for image generation */
        .certificate-container.embedded .certificate-content {
            height: 180mm !important;
            overflow: visible !important;
        }

        /* Ensure consistent spacing for image generation */
        .certificate-container.embedded .certificate-title span {
            padding-bottom: 1mm !important;
            margin-bottom: 5mm !important;
        }

        /* Disable responsive behavior for image generation */
        @media all {
            .certificate-container.embedded .certificate {
                width: 297mm !important;
                height: 210mm !important;
            }
            
            .certificate-container.embedded .certificate-title h2 {
                font-size: 3.75rem !important;
            }
        }
        
        .certificate {
            page-break-inside: avoid;
            page-break-after: avoid;
            page-break-before: avoid;
            width: 297mm;
            height: 210mm;
            padding: 15mm; /* Fixed: was 100mm, now 15mm */
            background-color: white;
            position: relative;
            margin: 0 auto;
            margin-bottom: 20px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background-image: url('https://static.vecteezy.com/system/resources/thumbnails/006/513/062/small_2x/abstract-clean-white-soft-cloth-background-with-soft-waves-luxury-gray-curved-smooth-curtain-background-illustration-free-vector.jpg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }
        
        .border-outer {
            position: absolute;
            top: 5mm;
            left: 5mm;
            right: 5mm;
            bottom: 5mm;
            border: 3px solid #0c044c;
            pointer-events: none;
        }
        
        .border-inner {
            position: absolute;
            top: 10mm;
            left: 10mm;
            right: 10mm;
            bottom: 10mm;
            border: 2px solid #5898b0;
            pointer-events: none;
        }
        
        .certificate-content {
            height: 180mm;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        .header-image {
            display: flex;
            justify-content: center;
            margin-bottom: 0.5rem;
        }
        
        .header-image img {
            max-height: 80px;
            width: auto;
        }
        
        .certificate-title {
            text-align: center;
            position: relative;
        }
        
        .certificate-title h2 {
            font-size: 3.75rem;
            font-weight: 800;
            position: relative;
            color: #041c5c;
        }
        
        .certificate-title span {
            display: inline-block;
            padding-bottom: 1mm;
            margin-bottom: 5mm;
        }
        
        .membership-text {
            text-align: center;
            font-size: 1.125rem;
            line-height: 1.6;
            margin-top: 5mm;
            margin-bottom: 5mm;
        }
        
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 1.5rem;
        }
        
        .signature {
            text-align: center;
            width: 45%;
        }
        
        .signature-line {
            border-top: 2px solid black;
            width: 50mm;
            margin: 0 auto;
        }
        
        .signature-name {
            font-size: 1.125rem;
            margin-top: 0.5rem;
            font-weight: 800;
            color: #041c5c;
        }
        
        .signature-title {
            font-weight: bold;
            font-size: 1.2rem;
            margin-top: 0.25rem;
        }
        
        .logo-bottom {
            position: absolute;
            bottom: 0.5rem;
            right: 0.5rem;
        }
        
        .logo-bottom img {
            max-height: 50px;
            width: auto;
        }
        
        .wave-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            z-index: 20;
        }
        
        .wave-bottom img {
            max-height: 300px;
            width: 800px;
        }
        
        .wave-top {
            position: absolute;
            top: 0;
            right: 0;
            z-index: 20;
        }
        
        .wave-top img {
            max-height: 300px;
            width: 800px;
            
        }
        
        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }
            .certificate-container {
                padding: 0;
                margin-top: 0;
            }
            .certificate {
                box-shadow: none;
                margin: 0;
            }
        }
        
        @media (max-width: 768px) {
            .certificate-container {
                margin-top: 4rem;
                padding: 1rem;
            }
            
            .certificate {
                width: 100%;
                height: auto;
                padding: 10mm;
            }
            
            .certificate-title h2 {
                font-size: 2.5rem;
            }
            
            .name-container {
                width: 90% !important;
            }
            
            .recipient-name {
                font-size: 2rem !important;
            }
            
            .membership-text div {
                margin-left: 0 !important;
            }
            
            .signature-line {
                width: 100%;
            }
            
            .wave-bottom img,
            .wave-top img {
                max-height: 150px;
                width: 400px;
            }
        }
        
        @media (max-width: 480px) {
            .certificate-title h2 {
                font-size: 1.8rem;
            }
            
            .recipient-name {
                font-size: 1.5rem !important;
            }
            
            .membership-text {
                font-size: 1rem;
            }
            
            .signatures {
                flex-direction: column;
                align-items: center;
            }
            
            .signature {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .wave-bottom img,
            .wave-top img {
                display: none;
            }
        }
        
    </style>
</head>
<body>
    <div class="certificate-container {{ isset($embedded) && $embedded ? 'embedded' : 'standalone' }}">
        <div class="certificate">
            <div class="border-outer"></div>
            <div class="border-inner"></div>
            
            <div class="certificate-content">
                <br>
                <div class="header-image">
                    <img src="{{ asset('images/rec.png') }}" alt="Header Image">
                </div>
                <div class="certificate-title">
                    <h2>
                        <span>{{ $certificate->title}}</span>
                    </h2>
                </div>
                <div class="recipient-section">
                    <p class="certifies-text">This certifies that</p>
                    @if($member)
                        <div class="name-container">
                            <div class="recipient-name">{{ $member->first_name }} {{ $member->last_name }}</div>
                            <div class="name-line"></div>
                        </div>
                    @endif
                    <div class="membership-text">
                        {!! $certificate->content !!}
                    </div>
                </div>
                <div class="signatures">
                @foreach($certificate->signatories as $signatory)
                    <div class="signature">
                        <div class="signature-name">{{ $signatory->name }}</div>
                        <div class="signature-line"></div>
                        @if($signatory->position)
                            <div class="signature-title">{{ $signatory->position }}</div>
                        @endif
                    </div>
                @endforeach
            </div>      
                <div class="logo-bottom">
                    <img src="{{ asset('images/propagate.png') }}" alt="Propagate Image">
                </div>
            </div>
            <div class="wave-bottom">
                <img src="{{ asset('images/bot.png') }}" alt="Left Bottom Image">
            </div>
            <div class="wave-top">
                <img src="{{ asset('images/top.png') }}" alt="Right Top Image">
            </div>  
        </div>
    </div>
</body>
</html>