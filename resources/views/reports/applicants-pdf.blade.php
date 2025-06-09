<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Applicant Report - {{ now()->format('m/d/Y') }}</title>
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
        
        .badge-approved {
            background-color: #4CAF50;
            color: white;
        }
        
        .badge-pending {
            background-color: #FFC107;
            color: #000;
        }
        
        .badge-rejected {
            background-color: #F44336;
            color: white;
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
        
        .status-approved {
            background-color: #4CAF50;
        }
        
        .status-pending {
            background-color: #FFC107;
        }
        
        .status-rejected {
            background-color: #F44336;
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
        
        /* Member details table title divider */
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
    <div class="header">
        <p class="org-subtitle">Non-profit organization</p>
        <h1 class="org-name">RADIO ENGINEERING CIRCLE INC.</h1>
        <p class="org-details">Room 407 Building A, Polytechnic University of the Philippines-Taguig Campus,<br>
        General Santos Avenue, Lower Bicutan, Taguig, Philippines</p>
        <p class="org-contact">0917 541 883 | radio@rec.org.ph | rec.org.ph</p>
    </div>
    
    <div class="title-divider"></div>
    
    <h2 class="report-title">APPLICANT REPORT</h2>
    <p class="report-date">Printed on: {{ now()->format('F j, Y h:i A') }}</p>
    
    <center>
    <div class="legend-container">
        <div class="legend">
            <div class="legend-title">Legends</div>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #4CAF50;"></span>
                <span>Approved</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #FFC107;"></span>
                <span>Pending</span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: #F44336;"></span>
                <span>Rejected</span>
            </span>
        </div>
    </div>
    </center>
    
    <div class="section-title">SUMMARY OVERVIEW</div>
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="align-left">
                    <span class="status-indicator status-approved"></span>
                    Approved
                </td>
                <td>{{ number_format($approvedApplicants) }}</td>
                <td>{{ $totalApplicants > 0 ? round(($approvedApplicants/$totalApplicants)*100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td class="align-left">
                    <span class="status-indicator status-pending"></span>
                    Pending
                </td>
                <td>{{ number_format($pendingApplicants) }}</td>
                <td>{{ $totalApplicants > 0 ? round(($pendingApplicants/$totalApplicants)*100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td class="align-left">
                    <span class="status-indicator status-rejected"></span>
                    Rejected
                </td>
                <td>{{ number_format($rejectedApplicants) }}</td>
                <td>{{ $totalApplicants > 0 ? round(($rejectedApplicants/$totalApplicants)*100, 1) : 0 }}%</td>
            </tr>
            <tr class="total-row">
                <td class="align-left">TOTAL APPLICANTS</td>
                <td>{{ number_format($totalApplicants) }}</td>
                <td>100%</td>
            </tr>
        </tbody>
    </table>

    <div class="member-details-divider"></div>
    
    <!-- Approved Applicants -->
    <div class="section-title">APPROVED APPLICANTS ({{ number_format($approvedApplicants) }})</div>
    <table>
        <thead>
            <tr>
                <th style="width: 25%">Full Name</th>
                <th style="width: 15%">Date Applied</th>
                <th style="width: 15%">Date Approved</th>
                <th style="width: 15%">Section</th>
                <th style="width: 15%">Bureau</th>
                <th style="width: 15%">Membership Type</th>
            </tr>
        </thead>
        <tbody>
            @forelse($approved as $applicant)
            <tr>
                <td class="align-left">
                    <div class="name-cell">
                        <span class="status-indicator status-approved"></span>
                        {{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }}
                    </div>
                </td>
                <td>{{ $applicant->created_at->format('m/d/Y') }}</td>
                <td>
                    @if($applicant->member && $applicant->member->created_at)
                        {{ $applicant->member->created_at->format('m/d/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $applicant->member->section->section_name ?? '-' }}</td>
                <td>{{ $applicant->member->section->bureau->bureau_name ?? '-' }}</td>
                <td>{{ $applicant->member->membershipType->type_name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="empty-row">No approved applicants found</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td class="align-left">TOTAL APPROVED</td>
                <td colspan="5">{{ number_format(count($approved)) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="member-details-divider"></div>
    
    <!-- Pending Applicants -->
    <div class="section-title">PENDING APPLICANTS ({{ number_format($pendingApplicants) }})</div>
    <table>
        <thead>
            <tr>
                <th style="width: 70%">Full Name</th>
                <th style="width: 30%">Date Applied</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pending as $applicant)
            <tr>
                <td class="align-left">
                    <div class="name-cell">
                        <span class="status-indicator status-pending"></span>
                        {{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }}
                    </div>
                </td>
                <td>{{ $applicant->created_at->format('m/d/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" class="empty-row">No pending applicants found</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td class="align-left">TOTAL PENDING</td>
                <td>{{ number_format(count($pending)) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="member-details-divider"></div>
    
    <!-- Rejected Applicants -->
    <div class="section-title">REJECTED APPLICANTS ({{ number_format($rejectedApplicants) }})</div>
    <table>
        <thead>
            <tr>
                <th style="width: 40%">Full Name</th>
                <th style="width: 30%">Date Applied</th>
                <th style="width: 30%">Date Rejected</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rejected as $applicant)
            <tr>
                <td class="align-left">
                    <div class="name-cell">
                        <span class="status-indicator status-rejected"></span>
                        {{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }}
                    </div>
                </td>
                <td>{{ $applicant->created_at->format('m/d/Y') }}</td>
                <td>{{ $applicant->updated_at->format('m/d/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="empty-row">No rejected applicants found</td>
            </tr>
            @endforelse
            <tr class="total-row">
                <td class="align-left">TOTAL REJECTED</td>
                <td colspan="2">{{ number_format(count($rejected)) }}</td>
            </tr>
        </tbody>
    </table>
    
    <div class="footer">
        <p><strong>Confidential Report</strong> - Generated by {{ config('app.name') }}</p>
    </div>
</body>
</html>