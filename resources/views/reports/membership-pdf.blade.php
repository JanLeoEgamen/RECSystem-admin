<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Membership Report - {{ now()->format('m/d/Y') }}</title>
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
            padding-top: 60px; /* Added to make space for the logo */
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
        
        /* Legend styles */
        .legend-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        
        .legend {
            display: inline-block;
            font-size: 9pt;
            padding: 5px 10px;
            background-color:rgb(255, 255, 255);
            border-radius: 5px;
            text-align: center;
            line-height: 1.6;
        }
        
        .legend-title {
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .legend-item {
            display: inline-block;
            margin: 0 10px;
            white-space: nowrap;
        }
        
        .legend-color {
            width: 10px;
            height: 10px;
            border-radius: 3px;
            margin-right: 5px;
            display: inline-block;
            vertical-align: middle;
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
        
        .badge-active {
            background-color: #4CAF50;
            color: white;
        }
        
        .badge-inactive {
            background-color: #F44336;
            color: white;
        }
        
        .badge-lifetime {
            background-color: #FFC107;
            color: #000;
        }
        
        .badge-type-regular {
            background-color: #2196F3;
            color: white;
        }
        
        .badge-type-associate {
            background-color: #9C27B0;
            color: white;
        }
        
        .badge-type-student {
            background-color: #607D8B;
            color: white;
        }
        
        /* Totals styling */
        .total-row {
            background-color: #99f580;
            font-weight: bold;
        }
        
        .grand-total-row {
            background-color: #4CAF50;
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
        
        /* Bureau row styling */
        .bureau-row {
            background-color: #e0e5ff;
            font-weight: bold;
        }
        
        /* Section row styling */
        .section-row {
            padding-left: 15px;
        }

        .footer {
            font-size: 12px;
            color: #555;
            text-align: center;
            margin-top: 30px;
            padding-top: 5px;
            border-top: 3px solid #ddd;
        }
        
        /* Member details table title divider */
        .member-details-divider {
            border-top: 2px solid #101966;
            margin: 40px 0 20px 0;
            width: 100%;
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
    
    <h2 class="report-title">MEMBERSHIP REPORT</h2>
    <p class="report-date">Printed on: {{ now()->format('F j, Y h:i A') }}</p>
    
    <center>
    <div class="legend-container">
        <div class="legend">
            <div class="legend-title">Legends</div>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #4CAF50;"></span>
                <span>Active</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #F44336;"></span>
                <span>Inactive</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #FFC107;"></span>
                <span>Lifetime</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #2196F3;"></span>
                <span>Regular</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #9C27B0;"></span>
                <span>Associate</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #607D8B;"></span>
                <span>Student</span>
            </span>
        </div>
    </div>
    </center>
    
    <div class="section-title">SUMMARY STATISTICS</div>
    <table>
        <tr>
            <th>Total Members</th>
            <th>Active Members</th>
            <th>Inactive Members</th>
            <th>Total Bureaus</th>
            <th>Total Sections</th>
        </tr>
        <tr>
            <td>{{ number_format($totalMembers) }}</td>
            <td>{{ number_format($activeMembers) }}</td>
            <td>{{ number_format($inactiveMembers) }}</td>
            <td>{{ number_format($bureaus->count()) }}</td>
            <td>{{ number_format($bureaus->sum('sections_count')) }}</td>
        </tr>
    </table>

    <div class="section-title" style="margin-top: 30px;">MEMBERSHIP DISTRIBUTION</div>
    <table>
        <thead>
            <tr>
                <th style="width: 50%">Bureau/Section</th>
                <th>Active</th>
                <th>Inactive</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bureaus as $bureau)
            <tr class="bureau-row">
                <td class="align-left">{{ $bureau->bureau_name }}</td>
                <td>{{ number_format($bureau->active_members_count) }}</td>
                <td>{{ number_format($bureau->inactive_members_count) }}</td>
                <td>{{ number_format($bureau->total_members_count) }}</td>
            </tr>
            @foreach($bureau->sections as $section)
            <tr>
                <td class="align-left section-row">{{ $section->section_name }}</td>
                <td>{{ number_format($section->active_members_count) }}</td>
                <td>{{ number_format($section->inactive_members_count) }}</td>
                <td>{{ number_format($section->total_members_count) }}</td>
            </tr>
            @endforeach
            @endforeach
            <tr class="grand-total-row">
                <td class="align-left">GRAND TOTAL</td>
                <td>{{ number_format($activeMembers) }}</td>
                <td>{{ number_format($inactiveMembers) }}</td>
                <td>{{ number_format($totalMembers) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="member-details-divider"></div>
    <div class="section-title" style="margin-bottom: 10px;">MEMBER DETAILS ({{ $members->count() }} RECORDS)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 12%">Rec #</th>
                <th style="width: 26%">Name</th>
                <th style="width: 12%">Callsign</th>
                <th style="width: 12%">Status</th>
                <th style="width: 12%">Validity</th>
                <th style="width: 18%">Membership Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
            <tr>
                <td>{{ $member->rec_number }}</td>
                <td class="align-left">{{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name ? $member->middle_name[0].'.' : '' }}</td>
                <td>{{ $member->callsign ?? '-' }}</td>
                <td>
                    @if($member->is_lifetime_member)
                        <span class="badge badge-lifetime">Lifetime</span>
                    @elseif($member->status == 'active' || ($member->membership_end && \Carbon\Carbon::parse($member->membership_end)->isFuture()))
                        <span class="badge badge-active">Active</span>
                    @else
                        <span class="badge badge-inactive">Inactive</span>
                    @endif
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
                <td>
                    @if($member->membershipType)
                        @php
                            $typeClass = 'badge-type-';
                            if(str_contains(strtolower($member->membershipType->type_name), 'regular')) $typeClass .= 'regular';
                            elseif(str_contains(strtolower($member->membershipType->type_name), 'associate')) $typeClass .= 'associate';
                            elseif(str_contains(strtolower($member->membershipType->type_name), 'student')) $typeClass .= 'student';
                            else $typeClass .= 'regular';
                        @endphp
                        <span class="badge {{ $typeClass }}">{{ $member->membershipType->type_name }}</span>
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Confidential Report</strong> - Generated by {{ config('app.name') }}</p>
    </div>
</body>
</html>