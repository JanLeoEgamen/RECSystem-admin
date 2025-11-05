<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>License Report - {{ now()->format('m/d/Y') }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm;
            @bottom-center {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 10px;
                color: #555;
            }
            @bottom-right {
                content: url('path/to/your/image.png');
                width: 20mm;
                height: auto;
            }
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.3;
            font-size: 10pt;
        }
        
        /* Header styles */
        .header {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
            padding-top: 60px;
        }
        
        .org-subtitle {
            margin: 0 0 2px 0;
            font-size: 12px;
        }
        
        .org-name {
            color: #101966;
            font-size: 30px;
            font-weight: bold;
            margin: 0;
        }
        
        .org-details, .org-contact {
            margin: 3px 0;
            font-size: 9pt;
        }
        
        .title-divider {
            border-top: 2px solid #101966;
            margin: 5px auto 10px auto;
            width: 100%;
        }
        
        /* Report title */
        .report-title {
            color: #101966;
            font-size: 24px;
            text-align: center;
            margin: 5px 0;
        }
        
        .report-date {
            text-align: center;
            font-size: 10pt;
            margin-top: 10px;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            font-size: 9pt;
            table-layout: fixed;
            border-left: none;
            border-right: none;
        }
        
        th {
            background-color: #101966;
            color: white;
            padding: 5px;
            text-align: center;
            border-right: 1px solid white;
        }
        
        th:last-child {
            border-right: none;
        }
        
        td {
            padding: 3px 4px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #000;
            text-align: center;
        }
        
        td:last-child {
            border-right: none;
        }
        
        /* Add black border to bottom of tables */
        table tbody tr:last-child td {
            border-bottom: 1px solid #000;
        }
        
        /* Row coloring */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        /* Badge styles */
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
            font-size: 8px;
            text-align: center;
            min-width: 55px;
        }
        
        .badge-licensed {
            background-color: #4CAF50;
            color: white;
        }
        
        .badge-unlicensed {
            background-color: #F44336;
            color: white;
        }
        
        .badge-expired {
            background-color: #FFC107;
            color: #000;
        }
        
        /* Status indicator circle */
        .status-indicator {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
            vertical-align: middle;
        }
        
        .status-licensed {
            background-color: #4CAF50;
        }
        
        .status-unlicensed {
            background-color: #F44336;
        }
        
        .status-expired {
            background-color: #FFC107;
        }
        
        /* Totals styling */
        .total-row {
            background-color: #4CAF50 !important;
            color: white;
            font-weight: bold;
        }
        
        /* Section headers */
        .section-title {
            font-weight: bold;
            color: #101966;
            margin: 15px 0 5px 0;
            font-size: 16px;
            text-align: center;
        }
        
        /* Align left for specific columns */
        .align-left {
            text-align: left !important;
        }
        
        /* Bureau and section rows */
        .bureau-row {
            background-color: #5e6ffb !important;
            color: white;
            font-weight: bold;
        }
        
        .section-row {
            background-color: #f2f2f2 !important;
        }
        
        .section-row td:first-child {
            padding-left: 20px;
        }
        
        .member-details-divider {
            border-top: 2px solid #101966;
            margin: 40px 0 20px 0;
            width: 100%;
        }
        
        .empty-row {
            color: #777;
            text-align: center;
            padding: 10px;
        }
        
        .footer {
            font-size: 12px;
            color: #555;
            text-align: center;
            margin-top: 30px;
            padding-top: 5px;
            border-top: 3px solid #ddd;
        }
        
        /* Name cell with centered indicator */
        .name-cell {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('images/Logo.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }
    @endphp

    <div class="header">
        @if($logoBase64)
            <div style="text-align: center; margin-bottom: 10px;">
                <img src="{{ $logoBase64 }}" alt="Logo" style="height: 60px; width: auto;">
            </div>
        @endif
        <p class="org-subtitle">Non-profit organization</p>
        <h1 class="org-name">RADIO ENGINEERING CIRCLE INC.</h1>
        <p class="org-details">Room 407 Building A, Polytechnic University of the Philippines-Taguig Campus,<br>
        General Santos Avenue, Lower Bicutan, Taguig, Philippines</p>
        <p class="org-contact">0917 541 883 | radio@rec.org.ph | rec.org.ph</p>
    </div>
    
    <div class="title-divider"></div>
    
    <h2 class="report-title">LICENSE STATUS REPORT</h2>
    <p class="report-date">Printed on: {{ now()->format('F j, Y h:i A') }}</p>
    
    
    <div class="section-title">SUMMARY OVERVIEW</div>
    <table>
        <thead>
            <tr>
                <th style="width: 30%">Category</th>
                <th style="width: 20%">Count</th>
                <th style="width: 20%">Percentage</th>
                <th style="width: 30%">Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="align-left">Total Members</td>
                <td>{{ number_format($totalMembers) }}</td>
                <td>100%</td>
                <td class="align-left">All organization members</td>
            </tr>
            <tr>
                <td class="align-left">
                    <span class="status-indicator status-licensed"></span>
                    Licensed Members
                </td>
                <td>{{ number_format($licensedMembers) }}</td>
                <td>{{ $totalMembers > 0 ? round(($licensedMembers/$totalMembers)*100, 1) : 0 }}%</td>
                <td class="align-left">Members with valid licenses</td>
            </tr>
            <tr>
                <td class="align-left">
                    <span class="status-indicator status-unlicensed"></span>
                    Unlicensed Members
                </td>
                <td>{{ number_format($unlicensedMembers) }}</td>
                <td>{{ $totalMembers > 0 ? round(($unlicensedMembers/$totalMembers)*100, 1) : 0 }}%</td>
                <td class="align-left">Members without licenses</td>
            </tr>
            <tr>
                <td class="align-left">
                    <span class="status-indicator status-licensed"></span>
                    Active Licenses
                </td>
                <td>{{ number_format($activeLicenses) }}</td>
                <td>{{ $licensedMembers > 0 ? round(($activeLicenses/$licensedMembers)*100, 1) : 0 }}%</td>
                <td class="align-left">Licenses not yet expired</td>
            </tr>
            <tr>
                <td class="align-left">
                    <span class="status-indicator status-expired"></span>
                    Expired Licenses
                </td>
                <td>{{ number_format($expiredLicenses) }}</td>
                <td>{{ $licensedMembers > 0 ? round(($expiredLicenses/$licensedMembers)*100, 1) : 0 }}%</td>
                <td class="align-left">Licenses past expiration date</td>
            </tr>
            <tr>
                <td class="align-left">
                    <span class="status-indicator status-expired"></span>
                    Near Expiry (60 days)
                </td>
                <td>{{ number_format($nearExpiry) }}</td>
                <td>{{ $licensedMembers > 0 ? round(($nearExpiry/$licensedMembers)*100, 1) : 0 }}%</td>
                <td class="align-left">Licenses expiring within 60 days</td>
            </tr>
        </tbody>
    </table>

    <div class="member-details-divider"></div>
    
    <!-- License Summary by Bureau -->
    <div class="section-title">LICENSE SUMMARY BY BUREAU</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40%">Bureau/Section</th>
                <th style="width: 15%">Licensed Members</th>
                <th style="width: 15%">Unlicensed Members</th>
                <th style="width: 15%">Total Members</th>
                <th style="width: 15%">License Rate</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bureaus as $bureau)
            <tr class="bureau-row">
                <td class="align-left">{{ $bureau->bureau_name }}</td>
                <td>{{ $bureau->bureau_licensed_count }}</td>
                <td>{{ $bureau->bureau_unlicensed_count }}</td>
                <td>{{ $bureau->bureau_members_count }}</td>
                <td>{{ $bureau->bureau_members_count > 0 ? round(($bureau->bureau_licensed_count/$bureau->bureau_members_count)*100, 1) : 0 }}%</td>
            </tr>
            @foreach($bureau->sections as $section)
            <tr class="section-row">
                <td class="align-left" style="padding-left: 20px;">{{ $section->section_name }}</td>
                <td>{{ $section->licensed_members_count }}</td>
                <td>{{ $section->unlicensed_members_count }}</td>
                <td>{{ $section->total_members_count }}</td>
                <td>{{ $section->total_members_count > 0 ? round(($section->licensed_members_count/$section->total_members_count)*100, 1) : 0 }}%</td>
            </tr>
            @endforeach
            @endforeach
            <tr class="total-row">
                <td class="align-left">GRAND TOTAL</td>
                <td>{{ $licensedMembers }}</td>
                <td>{{ $unlicensedMembers }}</td>
                <td>{{ $totalMembers }}</td>
                <td>{{ $totalMembers > 0 ? round(($licensedMembers/$totalMembers)*100, 1) : 0 }}%</td>
            </tr>
        </tbody>
    </table>

    <div class="member-details-divider"></div>
    
    <!-- Licensed Members -->
    <div class="section-title">LICENSED MEMBERS ({{ number_format($licensedMembers) }})</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">Rec #</th>
                <th style="width: 20%">Name</th>
                <th style="width: 10%">Callsign</th>
                <th style="width: 15%">Membership Type</th>
                <th style="width: 15%">Bureau</th>
                <th style="width: 15%">Section</th>
                <th style="width: 10%">License Expiration</th>
                <th style="width: 10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bureaus as $bureau)
                @foreach($bureau->sections as $section)
                    @foreach($section->members->whereNotNull('license_number') as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td class="align-left">
                            <div class="name-cell">
                                <span class="status-indicator status-licensed"></span>
                                {{ $member->last_name }}, {{ $member->first_name }}
                            </div>
                        </td>
                        <td>{{ $member->callsign ?? '-' }}</td>
                        <td>{{ $member->membershipType->type_name ?? '-' }}</td>
                        <td>{{ $bureau->bureau_name }}</td>
                        <td>{{ $section->section_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($member->license_expiration_date)->format('m/d/Y') }}</td>
                        <td>
                            @if($member->license_expiration_date > now())
                                <span class="badge badge-licensed">Active</span>
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
            <tr class="total-row">
                <td class="align-left" colspan="7">TOTAL LICENSED MEMBERS</td>
                <td>{{ number_format($licensedMembers) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="member-details-divider"></div>
    
    <!-- Unlicensed Members -->
    <div class="section-title">UNLICENSED MEMBERS ({{ number_format($unlicensedMembers) }})</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">Rec #</th>
                <th style="width: 25%">Name</th>
                <th style="width: 15%">Callsign</th>
                <th style="width: 15%">Membership Type</th>
                <th style="width: 15%">Bureau</th>
                <th style="width: 15%">Section</th>
                <th style="width: 10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bureaus as $bureau)
                @foreach($bureau->sections as $section)
                    @foreach($section->members->whereNull('license_number') as $member)
                    <tr>
                        <td>{{ $member->id }}</td>
                        <td class="align-left">
                            <div class="name-cell">
                                <span class="status-indicator status-unlicensed"></span>
                                {{ $member->last_name }}, {{ $member->first_name }}
                            </div>
                        </td>
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
            <tr class="total-row">
                <td class="align-left" colspan="6">TOTAL UNLICENSED MEMBERS</td>
                <td>{{ number_format($unlicensedMembers) }}</td>
            </tr>
        </tbody>
    </table>
    
    <div class="footer">
        <p><strong>Confidential Report</strong> - Generated by {{ config('app.name') }}</p>
    </div>
</body>
</html>