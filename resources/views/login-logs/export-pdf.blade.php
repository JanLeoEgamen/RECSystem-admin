<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Logs Report - {{ now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #1f2937;
            background-color: #ffffff;
            margin: 0;
            padding: 40px 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
        }
        
        .org-header {
            text-align: center;
            padding: 0 20px 30px 20px;
            border-bottom: 3px solid #1e3a8a;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px auto;
            display: block;
        }
        
        .org-type {
            font-size: 11px;
            color: #6b7280;
            font-weight: 400;
            margin-bottom: 10px;
        }
        
        .org-name {
            font-size: 28px;
            font-weight: 700;
            color: #1e3a8a;
            margin: 0 0 15px 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .org-details {
            font-size: 11px;
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 3px;
        }
        
        .org-contact {
            font-size: 11px;
            color: #4b5563;
            margin-top: 8px;
        }
        
        .report-title {
            text-align: center;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .report-title h1 {
            margin: 0 0 5px 0;
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1e3a8a;
        }
        
        .report-title .subtitle {
            font-size: 12px;
            font-weight: 600;
            color: #4b5563;
        }
        
        .content {
            padding: 0 20px;
        }
        
        .filters {
            background: #eff6ff;
            padding: 12px 20px;
            margin-bottom: 20px;
            border-left: 4px solid #3b82f6;
        }
        
        .filters p {
            margin: 0;
            color: #1e40af;
            font-weight: 600;
            font-size: 11px;
        }
        
        .filters strong {
            color: #1e3a8a;
        }
        
        .summary {
            padding: 15px;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 13px;
        }
        
        .privacy-notice {
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .privacy-notice h4 {
            margin: 0 0 10px 0;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .privacy-notice p {
            margin: 8px 0;
            font-size: 10px;
            line-height: 1.5;
            font-weight: 200;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border: 2px solid #1e3a8a;
        }
        
        table th, table td {
            padding: 10px 8px;
            text-align: center;
            border: 1px solid #cbd5e1;
        }
        
        table th {
            background: #1e3a8a;
            color: white;
            font-weight: 700;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        table tbody tr:nth-child(odd) {
            background-color: white;
        }
        
        .badge {
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }
        
        .badge-login {
            background: #10b981;
            color: white;
        }
        
        .badge-logout {
            background: #3b82f6;
            color: white;
        }
        
        .user-cell {
            font-weight: 600;
            color: #374151;
        }
        
        .email-cell {
            color: #6b7280;
            font-size: 10px;
        }
        
        .ip-cell {
            font-family: 'Courier New', monospace;
            background: #fef3c7;
            color: #d97706;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
        }
        
        .timestamp-cell {
            color: #4b5563;
            font-size: 10px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            padding: 20px;
            border-top: 2px solid #e5e7eb;
        }
        
        .footer p {
            margin: 3px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="org-header">
            @php
                $logoPath = public_path('images/Logo.png');
                $logoBase64 = '';
                if (file_exists($logoPath)) {
                    $logoData = file_get_contents($logoPath);
                    $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
                }
            @endphp
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" alt="REC Logo" class="logo">
            @endif
            <div class="org-type">Non-profit organization</div>
            <h1 class="org-name">RADIO ENGINEERING CIRCLE INC.</h1>
            <div class="org-details">
                Room 407 Building A, Polytechnic University of the Philippines-Taguig Campus,
            </div>
            <div class="org-details">
                General Santos Avenue, Lower Bicutan, Taguig, Philippines
            </div>
            <div class="org-contact">
                0917 541 883 | radio@rec.org.ph | rec.org.ph
            </div>
        </div>
        
        <div class="report-title">
            <h1>User Login Logs Report</h1>
            <div class="subtitle">Printed on: {{ $currentDate }}</div>
        </div>

        <div class="content">
            @if($searchTerm)
            <div class="filters">
                <p><strong>Applied Filter:</strong> {{ $searchTerm }}</p>
            </div>
            @endif

            <div class="privacy-notice">
                <h4>⚠️ Data Privacy Act Compliance Notice</h4>
                <p>Republic Act No. 10173 - Data Privacy Act of 2012: This report contains sensitive personal and organizational data that is strictly confidential and protected under Philippine law.</p>
            </div>
            
            <div class="summary">
                Total Records Found: {{ $totalLogs }}
            </div>

            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Event Type</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>IP Address</th>
                        <th>Timestamp</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $index => $log)
                    <tr>
                        <td style="font-weight: 600; color: #6b7280;">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge @if($log->description == 'user_login') badge-login @else badge-logout @endif">
                                {{ $log->description == 'user_login' ? 'Login' : 'Logout' }}
                            </span>
                        </td>
                        <td class="user-cell">
                            @if($log->causer)
                                {{ $log->causer->first_name }} {{ $log->causer->last_name }}
                            @else
                                <em style="color: #9ca3af;">System Generated</em>
                            @endif
                        </td>
                        <td class="email-cell">
                            @if($log->causer)
                                {{ $log->causer->email }}
                            @else
                                <span style="color: #9ca3af;">N/A</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $ipAddress = 'N/A';
                                if (!empty($log->formatted_properties)) {
                                    foreach ($log->formatted_properties as $property) {
                                        if ($property['field'] === 'IP Address') {
                                            $ipAddress = $property['value'];
                                            break;
                                        }
                                    }
                                }
                            @endphp
                            @if($ipAddress !== 'N/A')
                                <span class="ip-cell">{{ $ipAddress }}</span>
                            @else
                                <span style="color: #9ca3af;">{{ $ipAddress }}</span>
                            @endif
                        </td>
                        <td class="timestamp-cell">{{ $log->created_at->format('M j, Y g:i A') }}</td>
                        <td class="timestamp-cell">{{ $log->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer">
                <p>Report generated by Radio Engineering Circle Inc. </p>
                <p>Generated on {{ $currentDate }} • User Login Activity Report</p>
            </div>
        </div>
    </div>
</body>
</html>