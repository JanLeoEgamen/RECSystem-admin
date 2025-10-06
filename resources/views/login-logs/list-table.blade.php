<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between;"> 
            <h2 style="font-weight: 600; font-size: 2.25rem; color: white; line-height: 1.2;">
                {{ __('User Login Logs') }}
            </h2>
        </div>
    </x-slot>

    <style>
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .activity-item {
            animation: slideInLeft 0.5s ease-out forwards;
            opacity: 0;
        }

        .activity-item:nth-child(1) { animation-delay: 0.1s; }
        .activity-item:nth-child(2) { animation-delay: 0.2s; }
        .activity-item:nth-child(3) { animation-delay: 0.3s; }
        .activity-item:nth-child(4) { animation-delay: 0.4s; }
        .activity-item:nth-child(5) { animation-delay: 0.5s; }
        .activity-item:nth-child(n+6) { animation-delay: 0.6s; }

        .tab-link {
            flex: 1;
            white-space: nowrap;
            padding: 1rem;
            border-bottom: 2px solid transparent;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all 0.2s;
            text-decoration: none;
            display: block;
        }

        .tab-link:not(.active) {
            color: #6b7280;
            background: transparent;
        }

        .tab-link:not(.active):hover {
            color: #4f46e5;
            background: #eef2ff;
            border-color: #a5b4fc;
        }

        .tab-link.active {
            border-color: #4f46e5;
            color: #4f46e5;
            background: #eef2ff;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
            border: 1px solid;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            border-color: #4f46e5;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #101966 0%, #4338ca 100%);
        }

        .btn-success {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            border-color: #059669;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #047857 0%, #059669 100%);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #5e6ffb 0%, #4f46e5 100%);
            color: white;
            border-color: #5e6ffb;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #101966 0%, #1e3a8a 100%);
        }

        .badge {
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .badge-primary {
            background: linear-gradient(135deg, #ddd6fe 0%, #c7d2fe 100%);
            color: #4338ca;
        }

        .badge-success {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .badge-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .badge-danger {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #991b1b;
        }

        .badge-gray {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            color: #374151;
        }

        .badge-user {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .badge-system {
            background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
            color: #c2410c;
        }

        .badge-login {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #065f46;
        }

        .badge-logout {
            background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 100%);
            color: #1d4ed8;
        }

        .badge-ip {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #d97706;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
            border-radius: 0.5rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
        }

        .data-table th {
            padding: 1rem;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-right: 2px solid rgba(255, 255, 255, 0.3);
        }

        .data-table th:last-child {
            border-right: none;
        }

        /* Center specific columns */
        .data-table .center-column {
            text-align: center;
        }

        /* Action column stays left-aligned */
        .data-table .action-column {
            text-align: left;
        }

        .data-table td {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            font-size: 0.875rem;
            color: #1f2937;
        }

        .dark .data-table td {
            border-bottom: none;
            color: #f9fafb;
        }

        .data-table tbody tr {
            /* Tailwind classes handle styling */
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            min-width: 2.5rem;
        }

        .pagination a:hover {
            background: #eef2ff;
            border-color: #a5b4fc;
            color: #4f46e5;
        }

        .pagination .active span {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
            border-color: #4f46e5;
        }

        .pagination .disabled span {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination .disabled span:hover {
            color: #374151;
        }

        @media (max-width: 640px) {
            .tab-link span.full-text {
                display: none;
            }
            .tab-link span.short-text {
                display: inline;
            }
            .btn span.btn-text {
                display: none;
            }
        }

        @media (min-width: 641px) {
            .tab-link span.full-text {
                display: inline;
            }
            .tab-link span.short-text {
                display: none;
            }
            .btn span.btn-text {
                display: inline;
            }
        }

        /* Desktop Layout */
        @media (min-width: 768px) {
            .desktop-filters {
                display: flex !important;
            }
            .mobile-filters {
                display: none !important;
            }
        }

        /* Mobile Layout */
        @media (max-width: 767px) {
            .desktop-filters {
                display: none !important;
            }
            .mobile-filters {
                display: flex !important;
            }
            
            /* Ensure table is scrollable on mobile */
            .table-container {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .data-table {
                min-width: 800px; /* Ensure minimum width for all columns */
            }
            
            .data-table th,
            .data-table td {
                white-space: nowrap;
                padding: 0.75rem 0.5rem;
            }
        }
    </style>

   <!-- Navigation Tabs -->
    <div class="bg-white dark:bg-gray-800" style="display: flex; border-bottom: 1px solid #e5e7eb; max-width: 1000px; margin: 0 auto 2rem auto; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <a href="{{ route('login-logs.index', ['view' => 'timeline']) }}" 
           class="tab-link {{ request('view', 'timeline') === 'timeline' ? 'active' : '' }}">
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="full-text">Timeline View</span>
                <span class="short-text">Timeline</span>
            </div>
        </a>
        <a href="{{ route('login-logs.indexTable', ['view' => 'table']) }}" 
           class="tab-link {{ request('view') === 'table' ? 'active' : '' }}">
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                <span class="full-text">Table View</span>
                <span class="short-text">Table</span>
            </div>
        </a>
    </div>

    <div style="padding: 2rem 0;">
        <div style="max-width: 80rem; margin: 0 auto; padding: 0 1rem;">
            <div class="bg-white dark:bg-gray-800" style="overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); border-radius: 1rem; border: 1px solid #e5e7eb;">
                <div style="padding: 1.5rem; color: #111827;">

                <!-- Filters Bar -->
                <div style="margin-bottom: 1.5rem;">
                    <!-- Desktop Layout -->
                    <div class="desktop-filters" style="display: none; align-items: center; gap: 1rem; justify-content: space-between;">
                        <!-- Summary Stats (Left) -->
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <div class="badge badge-primary" style="font-weight: 600;">
                                <span style="font-weight: 700;">Total of Login Logs:</span>&nbsp;{{ $logs->total() }}
                            </div>
                            @if(request()->anyFilled(['search', 'login_type']))
                            <div class="badge" style="background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%); color: #6b21a8; font-weight: 600;">
                                <span style="font-weight: 700;">Filtered:</span>&nbsp;{{ $logs->count() }}
                            </div>
                            @endif
                        </div>

                        <!-- Search Form (Center) -->
                        <form method="GET" action="{{ route('login-logs.indexTable') }}" style="flex: 0 0 500px;">
                            <input type="hidden" name="view" value="table">
                            <div style="display: flex; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 0.5rem; overflow: hidden;">
                                <input 
                                    type="text" 
                                    name="search" 
                                    placeholder="Search by name or email..." 
                                    value="{{ request('search') }}"
                                    class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400"
                                    style="flex: 1; padding: 0.5rem 1rem; border: none; outline: none; font-size: 0.875rem;"
                                >
                                @if(request('login_type'))
                                    <input type="hidden" name="login_type" value="{{ request('login_type') }}">
                                @endif
                                <button 
                                    type="submit" 
                                    class="btn-primary"
                                    style="border: none; padding: 0.5rem 1rem; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <span class="btn-text">Search</span>
                                </button>
                            </div>
                        </form>

                        <!-- Action Buttons (Right) -->
                        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                            <div style="display: flex; gap: 0.5rem;">
                                @if(request()->anyFilled(['search', 'login_type']))
                                    <a href="{{ route('login-logs.indexTable', ['view' => 'table']) }}" class="btn btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span class="btn-text">Reset</span>
                                    </a>
                                @endif

                                <!-- Export Button -->
                                <form method="GET" action="{{ route('login-logs.export') }}" style="display: inline;">
                                    <input type="hidden" name="export" value="pdf">
                                    <input type="hidden" name="view" value="table">
                                    @if(request()->has('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request()->has('login_type'))
                                        <input type="hidden" name="login_type" value="{{ request('login_type') }}">
                                    @endif
                                    <button type="submit" class="btn btn-success" style="width: 130px; justify-content: center;">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="btn-text">Export</span>
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Login Type Filter -->
                            <form method="GET" action="{{ route('login-logs.indexTable') }}" onchange="this.submit()">
                                <input type="hidden" name="view" value="table">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <select 
                                    name="login_type" 
                                    class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700"
                                    style="width: 100%; padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; font-size: 0.875rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                                >
                                    <option value="">All Login Types</option>
                                    <option value="user_login" {{ request('login_type') == 'user_login' ? 'selected' : '' }}>Logins</option>
                                    <option value="user_logout" {{ request('login_type') == 'user_logout' ? 'selected' : '' }}>Logouts</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile Layout -->
                    <div class="mobile-filters" style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Top Row: Summary Stats + Export -->
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                            <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                                <div class="badge badge-primary" style="font-weight: 600;">
                                    <span style="font-weight: 700;">Total:</span>&nbsp;{{ $logs->total() }}
                                </div>
                                @if(request()->anyFilled(['search', 'login_type']))
                                <div class="badge" style="background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%); color: #6b21a8; font-weight: 600;">
                                    <span style="font-weight: 700;">Filtered:</span>&nbsp;{{ $logs->count() }}
                                </div>
                                @endif
                            </div>
                            
                            <!-- Export Button -->
                            <div style="display: flex; gap: 0.5rem;">
                                @if(request()->anyFilled(['search', 'login_type']))
                                    <a href="{{ route('login-logs.indexTable', ['view' => 'table']) }}" class="btn btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span class="btn-text">Reset</span>
                                    </a>
                                @endif
                                <form method="GET" action="{{ route('login-logs.export') }}" style="display: inline;">
                                    <input type="hidden" name="export" value="pdf">
                                    <input type="hidden" name="view" value="table">
                                    @if(request()->has('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request()->has('login_type'))
                                        <input type="hidden" name="login_type" value="{{ request('login_type') }}">
                                    @endif
                                    <button type="submit" class="btn btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="btn-text">Export</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Bottom Row: Search Form and Filter -->
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <form method="GET" action="{{ route('login-logs.indexTable') }}" style="width: 100%;">
                                <input type="hidden" name="view" value="table">
                                @if(request('login_type'))
                                    <input type="hidden" name="login_type" value="{{ request('login_type') }}">
                                @endif
                                <div style="display: flex; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 0.5rem; overflow: hidden;">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        placeholder="Search by name or email..." 
                                        value="{{ request('search') }}"
                                        class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400"
                                        style="flex: 1; padding: 0.5rem 1rem; border: none; outline: none; font-size: 0.875rem;"
                                    >
                                    <button 
                                        type="submit" 
                                        class="btn-primary"
                                        style="border: none; padding: 0.5rem 1rem; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: white; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <span class="btn-text">Search</span>
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Login Type Filter -->
                            <form method="GET" action="{{ route('login-logs.indexTable') }}" onchange="this.submit()">
                                <input type="hidden" name="view" value="table">
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <select 
                                    name="login_type" 
                                    class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-700"
                                    style="width: 100%; padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; font-size: 0.875rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                                >
                                    <option value="">All Login Types</option>
                                    <option value="user_login" {{ request('login_type') == 'user_login' ? 'selected' : '' }}>Logins</option>
                                    <option value="user_logout" {{ request('login_type') == 'user_logout' ? 'selected' : '' }}>Logouts</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                    @if($logs->isEmpty())
                        <div style="text-align: center; padding: 3rem 0;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 4rem; height: 4rem; margin: 0 auto; color: #9ca3af;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 style="margin-top: 0.5rem; font-size: 1.125rem; font-weight: 500; color: #374151;">No login logs found</h3>
                            <p style="margin-top: 0.25rem; color: #6b7280;">Try adjusting your search or filter criteria</p>
                        </div>
                    @else
                        <!-- TABLE VIEW -->
                        <div class="table-container">
                            <table class="data-table bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
                                <thead>
                                    <tr>
                                        <th class="center-column">Type</th>
                                        <th class="center-column">User</th>
                                        <th class="center-column">IP Address</th>
                                        <th class="center-column">Date</th>
                                        <th class="center-column">Time</th>
                                        <th class="center-column">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                    <tr class="activity-item bg-white dark:bg-gray-700 even:bg-gray-50 dark:even:bg-gray-600 hover:bg-blue-50 dark:hover:bg-gray-500 transition-colors duration-200">
                                        <td class="center-column">
                                            @if($log->description == 'user_login')
                                                <span class="badge badge-login">
                                                    Login
                                                </span>
                                            @else
                                                <span class="badge badge-logout">
                                                    Logout
                                                </span>
                                            @endif
                                        </td>
                                        <td class="center-column">
                                            @if($log->causer)
                                                <div style="display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                                                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" class="text-indigo-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        <span class="badge badge-user">
                                                            {{ $log->causer->first_name }} {{ $log->causer->last_name }}
                                                        </span>
                                                    </div>
                                                    <span class="text-xs text-gray-500 dark:text-gray-300 block md:inline mt-3 md:mt-0">{{ $log->causer->email }}</span>
                                                </div>
                                            @else
                                                <div style="display: flex; align-items: center; gap: 0.5rem; justify-content: center;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" class="text-indigo-500 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="badge badge-system">
                                                        System
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="center-column">
                                            <span class="badge badge-ip">
                                                {{ $log->formatted_properties[0]['value'] ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="center-column">
                                            <span class="text-gray-900 dark:text-gray-100" style="font-weight: 600;">{{ $log->created_at->format('M j, Y') }}</span>
                                        </td>
                                        <td class="center-column">
                                            <span class="text-gray-600 dark:text-gray-400" style="font-size: 0.875rem;">{{ $log->created_at->format('g:i A') }}</span>
                                        </td>
                                        <td class="center-column">
                                            <span class="badge badge-info">
                                                {{ $log->created_at->diffForHumans() }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div style="margin-top: 2rem;" class="[&_.pagination_a]:bg-white [&_.pagination_a]:dark:bg-gray-700 [&_.pagination_a]:text-gray-700 [&_.pagination_a]:dark:text-gray-200 [&_.pagination_a]:border-gray-300 [&_.pagination_a]:dark:border-gray-600 [&_.pagination_span]:bg-white [&_.pagination_span]:dark:bg-gray-700 [&_.pagination_span]:text-gray-700 [&_.pagination_span]:dark:text-gray-200 [&_.pagination_span]:border-gray-300 [&_.pagination_span]:dark:border-gray-600">
                            {{ $logs->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>