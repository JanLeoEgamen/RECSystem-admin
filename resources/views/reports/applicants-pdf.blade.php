<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Applicant Report - {{ now()->format('m/d/Y') }}</title>
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
        .summary-card.approved { border-left-color: #2ecc71; }
        .summary-card.pending { border-left-color: #f39c12; }
        .summary-card.rejected { border-left-color: #e74c3c; }
        
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
        .badge-approved {
            background-color: #eafaf1;
            color: #27ae60;
        }
        .badge-pending {
            background-color: #fdebd0;
            color: #f39c12;
        }
        .badge-rejected {
            background-color: #fadbd8;
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
        .empty-row {
            color: #777;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Applicant Report</h1>
        <div class="subtitle">Generated on {{ now()->format('F j, Y g:i A') }}</div>
    </div>

    <div class="section-title">Summary Overview</div>
    <div class="summary-cards">
        <div class="summary-card">
            <div class="title">Total Applicants</div>
            <div class="value">{{ number_format($totalApplicants) }}</div>
        </div>
        <div class="summary-card approved">
            <div class="title">Approved</div>
            <div class="value">{{ number_format($approvedApplicants) }}</div>
        </div>
        <div class="summary-card pending">
            <div class="title">Pending</div>
            <div class="value">{{ number_format($pendingApplicants) }}</div>
        </div>
        <div class="summary-card rejected">
            <div class="title">Rejected</div>
            <div class="value">{{ number_format($rejectedApplicants) }}</div>
        </div>
    </div>

    <!-- Approved Applicants -->
    <div class="section-title">Approved Applicants ({{ number_format($approvedApplicants) }})</div>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Date Applied</th>
                <th>Date Approved</th>
                <th>Section</th>
                <th>Bureau</th>
                <th>Membership Type</th>
            </tr>
        </thead>
        <tbody>
            @forelse($approved as $applicant)
            <tr>
                <td>{{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }}</td>
                <td>{{ ucfirst($applicant->sex) }}</td>
                <td>
                    @if($applicant->birthdate)
                        {{ \Carbon\Carbon::parse($applicant->birthdate)->age }}
                    @else
                        -
                    @endif
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
                <td colspan="8" class="empty-row">No approved applicants found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pending Applicants -->
    <div class="section-title">Pending Applicants ({{ number_format($pendingApplicants) }})</div>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Date Applied</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pending as $applicant)
            <tr>
                <td>{{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }}</td>
                <td>{{ ucfirst($applicant->sex) }}</td>
                <td>
                    @if($applicant->birthdate)
                        {{ \Carbon\Carbon::parse($applicant->birthdate)->age }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $applicant->created_at->format('m/d/Y') }}</td>
                <td class="text-center"><span class="badge badge-pending">Pending</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="empty-row">No pending applicants found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Rejected Applicants -->
    <div class="section-title">Rejected Applicants ({{ number_format($rejectedApplicants) }})</div>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Sex</th>
                <th>Age</th>
                <th>Date Applied</th>
                <th>Date Rejected</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rejected as $applicant)
            <tr>
                <td>{{ $applicant->last_name }}, {{ $applicant->first_name }} {{ $applicant->middle_name ? $applicant->middle_name[0].'.' : '' }}</td>
                <td>{{ ucfirst($applicant->sex) }}</td>
                <td>
                    @if($applicant->birthdate)
                        {{ \Carbon\Carbon::parse($applicant->birthdate)->age }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $applicant->created_at->format('m/d/Y') }}</td>
                <td>{{ $applicant->updated_at->format('m/d/Y') }}</td>
                <td class="text-center"><span class="badge badge-rejected">Rejected</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="empty-row">No rejected applicants found</td>
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