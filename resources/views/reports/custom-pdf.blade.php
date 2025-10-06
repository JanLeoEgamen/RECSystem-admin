<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Membership Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
            @bottom-center {
                content: "Page " counter(page) " of " counter(pages);
                font-size: 10px;
                color: #555;
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
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #101966;
        }
        .header .subtitle {
            font-size: 16px;
            color: #101966;
            font-weight: bold;
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
            color: #101966;
            font-weight: bold;
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
        
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            font-size: 8pt;
            table-layout: fixed;
            border-left: none;
            border-right: none;
        }
        
        th {
            background-color: #101966;
            color: white;
            padding: 4px 3px;
            text-align: center;
            border-right: 1px solid white;
            font-weight: bold;
            font-size: 8pt;
        }
        
        th:last-child {
            border-right: none;
        }
        
        td {
            padding: 2px 3px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #000;
            text-align: center;
            vertical-align: top;
            font-size: 7pt;
            line-height: 1.2;
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
        
        /* Align left for specific columns */
        .align-left {
            text-align: left !important;
        }
        
        .footer {
            font-size: 12px;
            color: #555;
            text-align: center;
            margin-top: 30px;
            padding-top: 5px;
            border-top: 3px solid #ddd;
        }
        .summary {
            margin-bottom: 15px;
            font-weight: bold;
            color: #101966;
            font-size: 14px;
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
    
    <h2 class="report-title">CUSTOM MEMBERSHIP REPORT</h2>
    <p class="report-date">Generated on: {{ now()->format('F j, Y g:i A') }}</p>

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
                <th style="width: 4%">#</th>
                <th style="width: 10%">Member ID</th>
                <th style="width: 15%">Name</th>
                <th style="width: 7%">Status</th>
                <th style="width: 10%">Bureau</th>
                <th style="width: 10%">Section</th>
                <th style="width: 8%">Membership<br>Type</th>
                <th style="width: 8%">License Class</th>
                <th style="width: 10%">License Expiration</th>
                <th style="width: 18%">Contact Info</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $index => $member)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $member->rec_number ?? 'N/A' }}</td>
                <td class="align-left">{{ $member->last_name }}, {{ $member->first_name }} {{ $member->middle_name }} {{ $member->suffix }}</td>
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
                <td class="align-left" style="font-size: 6pt; line-height: 1.1;">
                    <div style="margin-bottom: 1px;">{{ $member->email_address }}</div>
                    <div>{{ $member->cellphone_no ?? ($member->telephone_no ?? 'No contact') }}</div>
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
        <p><strong>Confidential Report</strong> - Generated by {{ config('app.name') }}</p>
    </div>
</body>
</html>