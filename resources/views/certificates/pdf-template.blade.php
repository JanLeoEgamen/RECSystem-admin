<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $certificate->title }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background-color: #f0f0f0;
        }
        .certificate-container {
            width: 29.7cm;
            height: 21cm;
            padding: 1.5cm;
            background: #ffffff;
            border: 10px solid #0C4B33;
            box-sizing: border-box;
            position: relative;
        }
        .certificate-border {
            border: 2px solid #0C4B33;
            height: 100%;
            padding: 1cm;
            box-sizing: border-box;
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 1cm;
        }
        .header h1 {
            font-size: 28pt;
            color: #0C4B33;
            margin: 0;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 14pt;
            color: #555555;
            margin-top: 0.5cm;
        }
        .content {
            text-align: center;
            margin: 1.5cm 0;
            font-size: 12pt;
            line-height: 1.5;
        }
        .recipient {
            font-size: 18pt;
            font-weight: bold;
            color: #0C4B33;
            margin: 1cm 0;
        }
        .signatures {
            display: flex;
            justify-content: space-around;
            margin-top: 2cm;
        }
        .signature {
            text-align: center;
            width: 30%;
        }
        .signature-line {
            border-top: 1px solid #000000;
            margin: 0 auto 0.5cm;
            width: 80%;
            padding-top: 1cm;
        }
        .signature-name {
            font-weight: bold;
            font-size: 12pt;
        }
        .signature-title {
            font-size: 10pt;
            color: #555555;
        }
        .footer {
            position: absolute;
            bottom: 1cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10pt;
            color: #555555;
        }
        .certificate-id {
            position: absolute;
            bottom: 0.5cm;
            right: 1.5cm;
            font-size: 8pt;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-border">
            <div class="header">
                <h1>{{ $certificate->title }}</h1>
                <div class="subtitle">This Certificate is Proudly Presented To</div>
            </div>
            <div class="content">
                @if($member)
                    <div class="recipient">{{ $member->first_name }} {{ $member->last_name }}</div>
                @endif
                {!! $certificate->content !!}
            </div>
            <div class="signatures">
                @foreach($certificate->signatories as $signatory)   
                    <div class="signature">
                        <div class="signature-line"></div>
                        <div class="signature-name">{{ $signatory->name }}</div>
                        @if($signatory->position)
                            <div class="signature-title">{{ $signatory->position }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="footer">
                Issued on: {{ $issueDate }}
            </div>
            <div class="certificate-id">
                Certificate ID: {{ $certificate->id }}@if($member)-{{ $member->id }}@endif
            </div>
        </div>
    </div>
</body>
</html>
