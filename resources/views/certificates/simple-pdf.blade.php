<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate</title>
    <style>
        @page {
            margin: 10mm;
            size: A4 landscape;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            background: white;
        }
        
        .certificate-container {
            width: 100%;
            height: 180mm;
            position: relative;
            border: 3px solid #1e3a8a;
            background: #ffffff;
            page-break-inside: avoid;
        }
        
        .inner-border {
            position: absolute;
            top: 5mm;
            left: 5mm;
            right: 5mm;
            bottom: 5mm;
            border: 1px solid #3b82f6;
        }
        
        .content {
            padding: 15mm;
            text-align: center;
            height: 150mm;
            position: relative;
        }
        
        .header {
            margin-bottom: 15mm;
        }
        
        .logo-placeholder {
            width: 60px;
            height: 60px;
            border: 2px solid #1e3a8a;
            margin: 0 auto 10mm auto;
            line-height: 56px;
            text-align: center;
            font-size: 10px;
            color: #1e3a8a;
            font-weight: bold;
        }
        
        .title {
            font-size: 28px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 15mm;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .subtitle {
            font-size: 14px;
            margin-bottom: 10mm;
        }
        
        .recipient-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 10mm 0;
            border-bottom: 2px solid #000;
            display: inline-block;
            padding-bottom: 2mm;
            min-width: 120mm;
        }
        
        .content-text {
            font-size: 11px;
            line-height: 1.6;
            margin: 15mm auto;
            max-width: 180mm;
        }
        
        .signatures {
            position: absolute;
            bottom: 15mm;
            left: 15mm;
            right: 15mm;
        }
        
        .signature-row {
            width: 100%;
            display: table;
            table-layout: fixed;
        }
        
        .signature-cell {
            display: table-cell;
            text-align: center;
            vertical-align: top;
            padding: 0 5mm;
            width: 33.33%;
        }
        
        .signature-line {
            border-top: 1px solid #000;
            width: 60mm;
            margin: 0 auto 3mm auto;
        }
        
        .signature-name {
            font-size: 10px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 1mm;
        }
        
        .signature-title {
            font-size: 8px;
            font-weight: normal;
        }
        
        .batch-number {
            position: absolute;
            top: 5mm;
            left: 10mm;
            font-size: 8px;
            font-weight: bold;
        }
        
        .issue-date {
            position: absolute;
            bottom: 3mm;
            right: 10mm;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="inner-border"></div>
        
        <div class="batch-number">
            BATCH NUMBER
        </div>
        
        <div class="content">
            <div class="header">
                <div class="logo-placeholder">LOGO</div>
            </div>
            
            <div class="title">{{ $certificate->title }}</div>
            
            <div class="subtitle">This certifies that</div>
            
            @if($member)
                <div class="recipient-name">{{ $member->first_name }} {{ $member->last_name }}</div>
            @else
                <div class="recipient-name">_________________________</div>
            @endif
            
            <div class="content-text">
                {{ strip_tags($certificate->content) }}
            </div>
        </div>
        
        <div class="signatures">
            <div class="signature-row">
                @php $signatoryCount = min(count($certificate->signatories), 3) @endphp
                @for($i = 0; $i < 3; $i++)
                    <div class="signature-cell">
                        @if($i < $signatoryCount)
                            @php $signatory = $certificate->signatories[$i] @endphp
                            <div class="signature-line"></div>
                            <div class="signature-name">{{ $signatory->name }}</div>
                            @if($signatory->position)
                                <div class="signature-title">{{ $signatory->position }}</div>
                            @endif
                        @endif
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="issue-date">
            Issued: {{ $issueDate }}
        </div>
    </div>
</body>
</html>