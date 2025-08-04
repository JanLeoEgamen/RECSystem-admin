<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Logs Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { color: #2d3748; text-align: center; margin-bottom: 5px; }
        .header-info { margin-bottom: 15px; text-align: center; }
        .log-card { margin-bottom: 10px; border: 1px solid #e2e8f0; border-radius: 3px; padding: 8px; page-break-inside: avoid; }
        .log-header { border-bottom: 1px solid #e2e8f0; padding-bottom: 3px; margin-bottom: 3px; }
        .log-title { font-weight: bold; color: #4a5568; font-size: 13px; }
        .log-details { display: flex; justify-content: space-between; margin-top: 3px; }
        .log-user { font-size: 11px; color: #718096; }
        .log-time { font-size: 10px; color: #a0aec0; }
        .properties-table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 11px; }
        .properties-table th, .properties-table td { border: 1px solid #e2e8f0; padding: 5px; text-align: left; }
        .properties-table th { background-color: #f7fafc; }
        .footer { margin-top: 15px; text-align: right; font-size: 10px; color: #718096; }
        .page-break { page-break-after: always; }
        .badge-success { background-color: #d4edda; color: #155724; padding: 2px 5px; border-radius: 3px; }
        .badge-info { background-color: #d1ecf1; color: #0c5460; padding: 2px 5px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>User Login Logs Report</h1>
    
    <div class="header-info">
        <p>Generated on: {{ $currentDate }}</p>
        @if($searchTerm)
            <p>Search term: "{{ $searchTerm }}"</p>
        @endif
        <p>Total logs: {{ $totalLogs }}</p>
    </div>

    @foreach($logs as $index => $log)
        <div class="log-card">
            <div class="log-header">
                <div class="log-title">
                    @if($log->description == 'user_login')
                        <span class="badge-success">Login</span>
                    @else
                        <span class="badge-info">Logout</span>
                    @endif
                    - {{ $log->causer ? $log->causer->first_name.' '.$log->causer->last_name : 'System' }}
                </div>
            </div>
            
            <div class="log-details">
                <div class="log-user">
                    @if($log->causer)
                        User: {{ $log->causer->email }}
                    @else
                        System generated
                    @endif
                </div>
                <div class="log-time">
                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                </div>
            </div>
            
            <table class="properties-table">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($log->formatted_properties as $property)
                        <tr>
                            <td>{{ $property['field'] }}</td>
                            <td>{{ $property['value'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if(($index + 1) % 15 === 0 && ($index + 1) < count($logs))
            <div class="page-break"></div>
        @endif
    @endforeach

    <div class="footer">
        Page {{ ceil(($index + 1) / 15) }} of {{ ceil(count($logs) / 15) }}
    </div>
</body>
</html>