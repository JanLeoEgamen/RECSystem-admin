<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activity Logs Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { color: #2d3748; text-align: center; margin-bottom: 5px; }
        .header-info { margin-bottom: 15px; text-align: center; }
        .activity-card { margin-bottom: 10px; border: 1px solid #e2e8f0; border-radius: 3px; padding: 8px; page-break-inside: avoid; }
        .activity-header { border-bottom: 1px solid #e2e8f0; padding-bottom: 3px; margin-bottom: 3px; }
        .activity-title { font-weight: bold; color: #4a5568; font-size: 13px; }
        .activity-details { display: flex; justify-content: space-between; margin-top: 3px; }
        .activity-user { font-size: 11px; color: #718096; }
        .activity-time { font-size: 10px; color: #a0aec0; }
        .properties-table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 11px; }
        .properties-table th, .properties-table td { border: 1px solid #e2e8f0; padding: 5px; text-align: left; }
        .properties-table th { background-color: #f7fafc; }
        .footer { margin-top: 15px; text-align: right; font-size: 10px; color: #718096; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <h1>Activity Logs Report</h1>
    
    <div class="header-info">
        <p>Generated on: {{ $currentDate }}</p>
        @if($searchTerm)
            <p>Search term: "{{ $searchTerm }}"</p>
        @endif
        <p>Total activities: {{ $totalActivities }}</p>
    </div>

    @foreach($activities as $index => $activity)
        <div class="activity-card">
            <div class="activity-header">
                <div class="activity-title">{{ ucfirst($activity->log_name) }} - {{ $activity->description }}</div>
            </div>
            
            <div class="activity-details">
                <div class="activity-user">
                    @if($activity->causer)
                        Performed by: {{ $activity->causer->first_name }} {{ $activity->causer->last_name }}
                    @else
                        System generated
                    @endif
                </div>
                <div class="activity-time">
                    {{ $activity->created_at->format('Y-m-d H:i:s') }}
                </div>
            </div>
            
            @if($activity->formatted_properties)
                @if(is_array($activity->formatted_properties) && !isset($activity->formatted_properties['raw']))
                    <table class="properties-table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activity->formatted_properties as $property)
                                <tr>
                                    <td>{{ $property['field'] }}</td>
                                    <td>{{ $property['old'] }}</td>
                                    <td>{{ $property['new'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="margin-top: 8px;">
                        <pre style="font-size: 10px; white-space: pre-wrap;">{{ $activity->formatted_properties['raw'] ?? '' }}</pre>
                    </div>
                @endif
            @endif
        </div>

        @if(($index + 1) % 15 === 0 && ($index + 1) < count($activities))
            <div class="page-break"></div>
        @endif
    @endforeach

    <div class="footer">
        Page {{ ceil(($index + 1) / 15) }} of {{ ceil(count($activities) / 15) }}
    </div>
</body>
</html>