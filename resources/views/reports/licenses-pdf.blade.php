<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>License Report - {{ now()->format('m/d/Y') }}</title>
    <style>
        @page {
            size: A4 landscape;
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
        .summary-card.licensed { border-left-color: #2ecc71; }
        .summary-card.unlicensed { border-left-color: #e74c3c; }
        .summary-card.active { border-left-color: #27ae60; }
        .summary-card.expired { border-left-color: #f39c12; }
        .summary-card.near-expiry { border-left-color: #e67e22; }
        
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
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 600;
        }
        .badge-licensed {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-unlicensed {
            background-color: #f8d7da;
            color: #721c24;
        }
        .badge-expired {
            background-color: #fff3cd;
            color: #856404;
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
        .empty-row {
            color: #777;
            text-align: center;
            padding: 10px;
        }
        .bureau-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        .section-row {
            background-color: #f8f9fa !important;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>License Status Report</h1>
        <div class="subtitle">Generated on {{ now()->format('F j, Y g:i A') }}</div>
    </div>

    <div class="section-title">Summary Overview</div>
    <div class="summary-cards">
        <div class="summary-card">
            <div class="title">Total Members</div>
            <div class="value">{{ number_format($totalMembers) }}</div>
        </div>
        <div class="summary-card licensed">
            <div class="title">Licensed Members</div>
            <div class="value">{{ number_format($licensedMembers) }}</div>
        </div>
        <div class="summary-card unlicensed">
            <div class="title">Unlicensed Members</div>
            <div class="value">{{ number_format($unlicensedMembers) }}</div>
        </div>
        <div class="summary-card active">
            <div class="title">Active Licenses</div>
            <div class="value">{{ number_format($activeLicenses) }}</div>
        </div>
        <div class="summary-card expired">
            <div class="title">Expired Licenses</div>
            <div class="value">{{ number_format($expiredLicenses) }}</div>
        </div>
        <div class="summary-card near-expiry">
            <div class="title">Near Expiry (60 days)</div>
            <div class="value">{{ number_format($nearExpiry) }}</div>
        </div>
    </div>

    <!-- License Summary by Bureau -->
    <div class="section-title">License Summary by Bureau</div>
    <table>
        <thead>
            <tr>
                <th>Bureau/Section</th>
                <th>Licensed Members</th>
                <th>Unlicensed Members</th>
                <th>Total Members</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bureaus as $bureau)
            <tr class="bureau-row">
                <td>{{ $bureau->bureau_name }}</td>
                <td>{{ $bureau->bureau_licensed_count }}</td>
                <td>{{ $bureau->bureau_unlicensed_count }}</td>
                <td>{{ $bureau->bureau_members_count }}</td>
            </tr>
            @foreach($bureau->sections as $section)
            <tr class="section-row">
                <td style="padding-left: 20px;">{{ $section->section_name }}</td>
                <td>{{ $section->licensed_members_count }}</td>
                <td>{{ $section->unlicensed_members_count }}</td>
                <td>{{ $section->total_members_count }}</td>
            </tr>
            @endforeach
            @endforeach
            <tr class="bureau-row">
                <td>Grand Total</td>
                <td>{{ $licensedMembers }}</td>
                <td>{{ $unlicensedMembers }}</td>
                <td>{{ $totalMembers }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Licensed Members -->
    <div class="section-title">Licensed Members ({{ number_format($licensedMembers) }})</div>
    <table>
        <thead>
            <tr>
                <th>Rec #</th>
                <th>Name</th>
                <th>Callsign</th>
                <th>Membership Type</th>
                <th>Bureau</th>
                <th>Section</th>
                <th>License Expiration</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bureaus as $bureau)
                @foreach($bureau->sections as $section)
                    @foreach($section->members->whereNotNull('license_number') as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->last_name }}, {{ $member->first_name }}</td>
                        <td>{{ $member->callsign ?? '-' }}</td>
                        <td>{{ $member->membershipType->type_name ?? '-' }}</td>
                        <td>{{ $bureau->bureau_name }}</td>
                        <td>{{ $section->section_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($member->license_expiration_date)->format('m/d/Y') }}</td>
                        <td>
                            @if($member->license_expiration_date > now())
                                <span class="badge badge-licensed">Active</span>
                            @elseif($member->license_expiration_date > now()->subDays(60))
                                <span class="badge badge-expired">Expired</span>
                            @else
                                <span class="badge badge-expired">Expired</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            @empty
            <tr>
                <td colspan="8" class="empty-row">No licensed members found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Unlicensed Members -->
    <div class="section-title">Unlicensed Members ({{ number_format($unlicensedMembers) }})</div>
    <table>
        <thead>
            <tr>
                <th>Rec #</th>
                <th>Name</th>
                <th>Callsign</th>
                <th>Membership Type</th>
                <th>Bureau</th>
                <th>Section</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bureaus as $bureau)
                @foreach($bureau->sections as $section)
                    @foreach($section->members->whereNull('license_number') as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td>{{ $member->last_name }}, {{ $member->first_name }}</td>
                        <td>{{ $member->callsign ?? '-' }}</td>
                        <td>{{ $member->membershipType->type_name ?? '-' }}</td>
                        <td>{{ $bureau->bureau_name }}</td>
                        <td>{{ $section->section_name }}</td>
                        <td><span class="badge badge-unlicensed">Unlicensed</span></td>
                    </tr>
                    @endforeach
                @endforeach
            @empty
            <tr>
                <td colspan="7" class="empty-row">No unlicensed members found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Footer -->
    <div class="footer">
        {{ config('app.name') }} | Page {PAGENO} of {nbpg} | Generated on {{ now()->format('M j, Y g:i A') }}
    </div>
</body>
</html>