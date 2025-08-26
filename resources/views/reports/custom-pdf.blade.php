<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Membership Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header .subtitle {
            font-size: 16px;
            color: #666;
        }
        .filters {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .filters h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        .filter-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 5px;
        }
        .filter-item {
            display: flex;
        }
        .filter-label {
            font-weight: bold;
            margin-right: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        .summary {
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Membership Information Management System</h1>
        <div class="subtitle">Custom Membership Report</div>
        <div>Generated on: {{ now()->format('F j, Y g:i A') }}</div>
    </div>

    @if(!empty($filters) && count(array_filter($filters)) > 0)
    <div class="filters">
        <h3>Applied Filters:</h3>
        <div class="filter-list">
            @if(!empty($filters['status']))
            <div class="filter-item">
                <span class="filter-label">Status:</span>
                <span class="filter-value">{{ ucfirst($filters['status']) }}</span>
            </div>
            @endif
            
            @if(!empty($filters['bureau_id']))
            <div class="filter-item">
                <span class="filter-label">Bureau:</span>
                <span class="filter-value">
                    @php
                        $bureau = App\Models\Bureau::find($filters['bureau_id']);
                        echo $bureau ? $bureau->bureau_name : 'N/A';
                    @endphp
                </span>
            </div>
            @endif
            
            @if(!empty($filters['section_id']))
            <div class="filter-item">
                <span class="filter-label">Section:</span>
                <span class="filter-value">
                    @php
                        $section = App\Models\Section::find($filters['section_id']);
                        echo $section ? $section->section_name : 'N/A';
                    @endphp
                </span>
            </div>
            @endif
            
            @if(!empty($filters['membership_type_id']))
            <div class="filter-item">
                <span class="filter-label">Membership Type:</span>
                <span class="filter-value">
                    @php
                        $type = App\Models\MembershipType::find($filters['membership_type_id']);
                        echo $type ? $type->type_name : 'N/A';
                    @endphp
                </span>
            </div>
            @endif
            
            @if(!empty($filters['license_class']))
            <div class="filter-item">
                <span class="filter-label">License Class:</span>
                <span class="filter-value">{{ $filters['license_class'] }}</span>
            </div>
            @endif
            
            @if(!empty($filters['sex']))
            <div class="filter-item">
                <span class="filter-label">Gender:</span>
                <span class="filter-value">{{ ucfirst($filters['sex']) }}</span>
            </div>
            @endif
            
            @if(!empty($filters['civil_status']))
            <div class="filter-item">
                <span class="filter-label">Civil Status:</span>
                <span class="filter-value">{{ ucfirst($filters['civil_status']) }}</span>
            </div>
            @endif
            
            @if(isset($filters['is_lifetime_member']) && $filters['is_lifetime_member'] !== '')
            <div class="filter-item">
                <span class="filter-label">Lifetime Member:</span>
                <span class="filter-value">{{ $filters['is_lifetime_member'] ? 'Yes' : 'No' }}</span>
            </div>
            @endif
            
            @if(!empty($filters['date_from']))
            <div class="filter-item">
                <span class="filter-label">From Date:</span>
                <span class="filter-value">{{ \Carbon\Carbon::parse($filters['date_from'])->format('M j, Y') }}</span>
            </div>
            @endif
            
            @if(!empty($filters['date_to']))
            <div class="filter-item">
                <span class="filter-label">To Date:</span>
                <span class="filter-value">{{ \Carbon\Carbon::parse($filters['date_to'])->format('M j, Y') }}</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <div class="summary">
        Total Members: {{ $members->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Bureau</th>
                <th>Section</th>
                <th>Membership Type</th>
                <th>License Class</th>
                <th>License Expiration</th>
                <th>Contact Info</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $member->rec_number ?? 'N/A' }}</td>
                <td>{{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name }} {{ $member->suffix }}</td>
                <td>{{ ucfirst($member->status) }}</td>
                <td>{{ $member->section && $member->section->bureau ? $member->section->bureau->bureau_name : 'N/A' }}</td>
                <td>{{ $member->section ? $member->section->section_name : 'N/A' }}</td>
                <td>{{ $member->membershipType ? $member->membershipType->type_name : 'N/A' }}</td>
                <td>{{ $member->license_class ?? 'N/A' }}</td>
                <td>
                    @if($member->license_expiration_date)
                        {{ \Carbon\Carbon::parse($member->license_expiration_date)->format('M j, Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    {{ $member->email_address }}<br>
                    {{ $member->cellphone_no ?? ($member->telephone_no ?? 'No contact info') }}
                </td>
            </tr>
            @endforeach
            @if($members->count() === 0)
            <tr>
                <td colspan="10" style="text-align: center;">No members found with the selected filters</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Generated by MIMS on {{ now()->format('F j, Y') }}
    </div>
</body>
</html>