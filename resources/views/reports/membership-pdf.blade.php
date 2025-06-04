<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Report - {{ now()->format('m/d/Y') }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            color: #2c3e50;
            line-height: 1.5;
            font-size: 10px;
            background-color: #fff;
            margin: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ccc;
        }
        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #1a1a1a;
        }
        .header .subtitle {
            font-size: 10px;
            color: #777;
        }
        .section-title {
            font-size: 12px;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            margin: 20px 0 10px;
            padding-bottom: 4px;
            color: #2c3e50;
        }
        .summary-cards {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .summary-card {
            flex: 1 1 18%;
            background: #f9fafb;
            border-left: 4px solid #3498db;
            border-radius: 6px;
            padding: 10px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .summary-card .title {
            font-size: 8px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 2px;
        }
        .summary-card .value {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 9px;
        }
        th, td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f3f6f9;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 8px;
            color: #34495e;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        .bureau-row {
            background-color: #ecf0f1;
            font-weight: bold;
        }
        .section-row td:first-child {
            padding-left: 20px;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 600;
        }
        .badge-active {
            background-color: #eafaf1;
            color: #27ae60;
        }
        .badge-inactive {
            background-color: #fdecea;
            color: #e74c3c;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            text-align: center;
            font-size: 8px;
            color: #aaa;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Membership Report</h1>
        <div class="subtitle">Generated on {{ now()->format('F j, Y g:i A') }}</div>
    </div>

    <div class="section-title">Summary Statistics</div>
    <div class="summary-cards">
        <div class="summary-card">
            <div class="title">Total Members</div>
            <div class="value">{{ number_format($totalMembers) }}</div>
        </div>
        <div class="summary-card">
            <div class="title">Active Members</div>
            <div class="value">{{ number_format($activeMembers) }}</div>
        </div>
        <div class="summary-card">
            <div class="title">Inactive Members</div>
            <div class="value">{{ number_format($inactiveMembers) }}</div>
        </div>
        <div class="summary-card">
            <div class="title">Total Bureaus</div>
            <div class="value">{{ number_format($bureaus->count()) }}</div>
        </div>
        <div class="summary-card">
            <div class="title">Total Sections</div>
            <div class="value">{{ number_format($bureaus->sum('sections_count')) }}</div>
        </div>
    </div>

    <div class="section-title">Membership Distribution</div>
    <table>
        <thead>
            <tr>
                <th>Bureau/Section</th>
                <th class="text-center">Active</th>
                <th class="text-center">Inactive</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bureaus as $bureau)
            <tr class="bureau-row">
                <td>{{ $bureau->bureau_name }}</td>
                <td class="text-center">{{ number_format($bureau->active_members_count) }}</td>
                <td class="text-center">{{ number_format($bureau->inactive_members_count) }}</td>
                <td class="text-center">{{ number_format($bureau->total_members_count) }}</td>
            </tr>
            @foreach($bureau->sections as $section)
            <tr class="section-row">
                <td>{{ $section->section_name }}</td>
                <td class="text-center">{{ number_format($section->active_members_count) }}</td>
                <td class="text-center">{{ number_format($section->inactive_members_count) }}</td>
                <td class="text-center">{{ number_format($section->total_members_count) }}</td>
            </tr>
            @endforeach
            @endforeach
            <tr class="bureau-row">
                <td><strong>Grand Total</strong></td>
                <td class="text-center"><strong>{{ number_format($activeMembers) }}</strong></td>
                <td class="text-center"><strong>{{ number_format($inactiveMembers) }}</strong></td>
                <td class="text-center"><strong>{{ number_format($totalMembers) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

    <div class="section-title">Member Details ({{ $members->count() }} records)</div>
    <table>
        <thead>
            <tr>
                <th>Rec #</th>
                <th>Name</th>
                <th>Callsign</th>
                <th>Status</th>
                <th>Validity</th>
                <th>Membership Type</th>
                <th>Bureau</th>
                <th>Section</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $member->rec_number }}</td>
                <td>{{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name ? $member->middle_name[0].'.' : '' }}</td>
                <td>{{ $member->callsign ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge badge-{{ $member->status }}">
                        {{ ucfirst($member->status) }}
                    </span>
                </td>
                <td>
                    @if($member->is_lifetime_member)
                        Lifetime
                    @elseif($member->membership_end)
                        {{ \Carbon\Carbon::parse($member->membership_end)->format('m/d/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $member->membershipType->type_name ?? '-' }}</td>
                <td>{{ $member->section->bureau->bureau_name ?? '-' }}</td>
                <td>{{ $member->section->section_name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        {{ config('app.name') }} | Page {PAGENO} of {nbpg} | Generated on {{ now()->format('M j, Y g:i A') }}
    </div>
</body>
</html>
