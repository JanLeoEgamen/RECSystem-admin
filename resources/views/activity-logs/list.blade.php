<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between;"> 
            <h2 style="font-weight: 600; font-size: 2.25rem; color: white; line-height: 1.2;">
                {{ __('Activity Logs') }}
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
            background: linear-gradient(135deg, #4338ca 0%, #4f46e5 100%);
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

        .card {
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            border-radius: 1rem;
            padding: 1.5rem;
            transition: all 0.3s;
            border: 1px solid #e5e7eb;
        }

        .card:hover {
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            transform: scale(1.02);
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

        details[open] .arrow-icon {
            transform: rotate(90deg);
        }

        .arrow-icon {
            transition: transform 0.2s;
        }

        .property-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .property-old {
            background: linear-gradient(135deg, #fee2e2 0%, #fca5a5 100%);
            color: #7f1d1d;
        }

        .property-new {
            background: linear-gradient(135deg, #d1fae5 0%, #6ee7b7 100%);
            color: #064e3b;
        }

        .property-card {
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border: 1px solid #d1d5db;
        }

        .dark .property-card {
            background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%) !important;
            border-color: #6b7280 !important;
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
            background: white;
            color: #374151;
            border: 1px solid #d1d5db;
            text-decoration: none;
            min-width: 2.5rem;
        }

        .dark .pagination a,
        .dark .pagination span {
            background: #374151;
            color: #f3f4f6;
            border-color: #4b5563;
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
            background: white;
            color: #374151;
        }

        .dark .pagination a:hover {
            background: #4b5563;
            border-color: #6b7280;
            color: #4f46e5;
        }

        .dark .pagination .disabled span:hover {
            background: #374151;
            color: #f3f4f6;
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
        }
    </style>


    <!-- Navigation Tabs -->
    <div class="bg-white dark:bg-gray-800" style="display: flex; border-bottom: 1px solid #e5e7eb; max-width: 1000px; margin: 0 auto 2rem auto; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <a href="{{ route('activity-logs.index', ['view' => 'timeline']) }}" 
           class="tab-link {{ request('view', 'timeline') === 'timeline' ? 'active' : '' }}">
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="full-text">Timeline View</span>
                <span class="short-text">Timeline</span>
            </div>
        </a>
        <a href="{{ route('activity-logs.indexTable', ['view' => 'table']) }}" 
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
                <div style="padding: 1.5rem;" class="text-gray-900 dark:text-gray-100">

                <!-- Filters Bar -->
                <div style="margin-bottom: 1.5rem;">
                    <!-- Desktop Layout -->
                    <div class="desktop-filters" style="display: none; align-items: center; gap: 1rem; justify-content: space-between;">
                        <!-- Summary Stats (Left) -->
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <div class="badge badge-primary" style="font-weight: 600;">
                                <span style="font-weight: 700;">Total of Activity Logs:</span>&nbsp;{{ $activities->total() }}
                            </div>
                            @if(request()->anyFilled(['start_date', 'end_date']))
                            <div class="badge" style="background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%); color: #6b21a8; font-weight: 600;">
                                <span style="font-weight: 700;">Filtered:</span>&nbsp;{{ $activities->count() }}
                            </div>
                            @endif
                        </div>

                        <!-- Search Form (Center) -->
                        <form method="GET" action="{{ route('activity-logs.index') }}" style="flex: 0 0 500px;">
                            <div style="display: flex; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 0.5rem; overflow: hidden;">
                                <input 
                                    type="text" 
                                    name="search" 
                                    placeholder="Search..." 
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

                        <!-- Action Buttons (Right) -->
                        <div style="display: flex; gap: 0.5rem;">
                            @if(request()->anyFilled(['search', 'start_date', 'end_date']))
                                <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <span class="btn-text">Reset</span>
                                </a>
                            @endif

                            <!-- Export Button -->
                            <form method="GET" action="{{ route('activity-logs.index') }}" style="display: inline;">
                                <input type="hidden" name="export" value="pdf">
                                <input type="hidden" name="view" value="{{ request('view', 'timeline') }}">
                                @if(request()->has('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
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

                    <!-- Mobile Layout -->
                    <div class="mobile-filters" style="display: flex; flex-direction: column; gap: 1rem;">
                        <!-- Top Row: Summary Stats + Export -->
                        <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                            <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                                <div class="badge badge-primary" style="font-weight: 600;">
                                    <span style="font-weight: 700;">Total:</span>&nbsp;{{ $activities->total() }}
                                </div>
                                @if(request()->anyFilled(['start_date', 'end_date']))
                                <div class="badge" style="background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%); color: #6b21a8; font-weight: 600;">
                                    <span style="font-weight: 700;">Filtered:</span>&nbsp;{{ $activities->count() }}
                                </div>
                                @endif
                            </div>
                            
                            <!-- Export Button -->
                            <div style="display: flex; gap: 0.5rem;">
                                @if(request()->anyFilled(['search', 'start_date', 'end_date']))
                                    <a href="{{ route('activity-logs.index') }}" class="btn btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span class="btn-text">Reset</span>
                                    </a>
                                @endif
                                <form method="GET" action="{{ route('activity-logs.index') }}" style="display: inline;">
                                    <input type="hidden" name="export" value="pdf">
                                    <input type="hidden" name="view" value="{{ request('view', 'timeline') }}">
                                    @if(request()->has('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
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

                        <!-- Bottom Row: Search Form -->
                        <form method="GET" action="{{ route('activity-logs.index') }}" style="width: 100%;">
                            <div style="display: flex; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 0.5rem; overflow: hidden;">
                                <input 
                                    type="text" 
                                    name="search" 
                                    placeholder="Search logs..." 
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
                    </div>
                </div>

                    @if($activities->isEmpty())
                        <div style="text-align: center; padding: 3rem 0;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-400 dark:text-gray-500" style="width: 4rem; height: 4rem; margin: 0 auto;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 style="margin-top: 0.5rem; font-size: 1.125rem; font-weight: 500;" class="text-gray-700 dark:text-gray-300">No activity logs found</h3>
                            <p style="margin-top: 0.25rem;" class="text-gray-600 dark:text-gray-400">Try adjusting your search or filter criteria</p>
                        </div>
                    @else
                        <!-- TIMELINE VIEW -->
                            <div style="position: relative;">
                                <!-- Timeline Line -->
                                <div style="position: absolute; left: 1rem; top: 0; bottom: 0; width: 2px; background: linear-gradient(180deg, #4f46e5 0%, #a5b4fc 50%, #e0e7ff 100%);"></div>

                                <!-- Start Marker -->
                                <div class="bg-indigo-600 border-4 border-white dark:border-gray-800" style="position: absolute; left: 1rem; top: 0; transform: translate(-50%, -50%); width: 1rem; height: 1rem; border-radius: 50%; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);"></div>

                                <!-- End Marker -->
                                <div class="bg-indigo-600 border-4 border-white dark:border-gray-800" style="position: absolute; left: 1rem; bottom: 0; transform: translate(-50%, 50%); width: 1rem; height: 1rem; border-radius: 50%; box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);"></div>
                                
                            <!-- Activity Cards -->
                            <div style="padding-left: 3rem;">
                                @foreach($activities as $activity)
                                    <div style="position: relative; margin-bottom: 1.5rem;" class="activity-item">
                                        <!-- Timeline Dot -->
                                        <div class="bg-indigo-600 border-4 border-white dark:border-gray-800" style="position: absolute; left: -2rem; top: 50%; transform: translate(-50%, -50%); width: 1rem; height: 1rem; border-radius: 50%; box-shadow: 0 2px 4px rgba(79, 70, 229, 0.2);"></div>
                                            
                                        <div class="card bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600" style="box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 1rem; padding: 1.5rem; transition: all 0.3s;">
                                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                                <!-- Header Section -->
                                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 1rem;">
                                                    <div style="flex: 1; min-width: 200px;">
                                                        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                                                            <h3 style="font-weight: 700; font-size: 1.125rem; margin: 0;" class="text-indigo-600 dark:text-white">
                                                                {{ ucfirst($activity->log_name) }}
                                                            </h3>
                                                            <span class="badge 
                                                                @if($activity->description === 'created') badge-success
                                                                @elseif($activity->description === 'updated') badge-info
                                                                @elseif($activity->description === 'deleted') badge-danger
                                                                @else badge-gray @endif">
                                                                {{ ucfirst($activity->description) }}
                                                            </span>
                                                        </div>

                                                        <div style="display: flex; align-items: center; gap: 0.5rem; color: #6b7280; font-size: 0.875rem;" class="text-gray-600 dark:text-gray-400">
                                                            @if($activity->causer)
                                                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" class="text-indigo-600 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                                </svg>
                                                                <span class="badge badge-user" style="font-weight: 500;">
                                                                    {{ $activity->causer->first_name.' '.$activity->causer->last_name }}
                                                                </span>
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;" class="text-indigo-600 dark:text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                </svg>
                                                                <span class="badge badge-system" style="font-weight: 500;">
                                                                    System
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Date Section -->
                                                    <div style="text-align: left;">
                                                        <div style="display: flex; align-items: center; gap: 0.25rem; font-size: 0.875rem; margin-bottom: 0.5rem;" class="text-gray-600 dark:text-gray-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 1rem; height: 1rem;"  class="text-indigo-600 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                            <span style="font-weight: 500;">{{ $activity->created_at->format('M j, Y g:i A') }}</span>
                                                        </div>
                                                        <div class="badge badge-primary" style="font-weight: 600;">
                                                            {{ $activity->created_at->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Properties Section -->
                                                @if($activity->properties->isNotEmpty())
                                                    <details style="margin-top: 0.5rem;">
                                                        <summary 
                                                            class="flex items-center gap-2 cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-900 rounded px-2 py-1"
                                                            style="list-style: none;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" 
                                                                class="arrow-icon text-indigo-600 dark:text-white" 
                                                                style="width: 1.25rem; height: 1.25rem;" 
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                            <span class="font-semibold text-indigo-600 dark:text-white">Properties</span>
                                                            <span class="badge badge-primary font-bold">
                                                                {{ count($activity->formatted_properties) }} {{ Str::plural('change', count($activity->formatted_properties)) }}
                                                            </span>
                                                        </summary>

                                                        <div style="margin-top: 0.75rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                                            @foreach($activity->formatted_properties as $property)
                                                            
                                                                <div class="bg-blue-50 dark:bg-gray-600 border border-blue-500 dark:border-gray-500" style="display: flex; flex-direction: column; border-radius: 0.5rem; padding: 0.75rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); min-width: 200px;">
                                                                    <span style="font-weight: 600; margin-bottom: 0.5rem;" class="text-gray-700 dark:text-gray-200">{{ $property['field'] }}:</span>
                                                                    <span class="text-gray-600 dark:text-gray-300">
                                                                        @if($activity->description === 'updated')
                                                                            <span class="property-old" style="margin-right: 0.25rem;">
                                                                                {{ $property['old'] ?? '(empty)' }}
                                                                            </span>
                                                                            <span style="font-weight: 700; margin: 0 0.25rem;" class="text-indigo-600 dark:text-blue-400">→</span>
                                                                            <span class="property-new">
                                                                                {{ $property['new'] ?? '(empty)' }}
                                                                            </span>
                                                                        @elseif($activity->description === 'created')
                                                                            <span class="property-new">
                                                                                {{ $property['new'] ?? '(empty)' }}
                                                                            </span>
                                                                        @elseif($activity->description === 'deleted')
                                                                            <span class="property-old">
                                                                                {{ $property['old'] ?? '(empty)' }}
                                                                            </span>
                                                                        @else
                                                                            <span class="property-badge" style="background: #f3f4f6; color: #374151;">
                                                                                {{ is_array($property['value']) ? json_encode($property['value']) : ($property['value'] ?? '(empty)') }}
                                                                            </span>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </details>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div style="margin-top: 2rem;" class="[&_.pagination_a]:bg-white [&_.pagination_a]:dark:bg-gray-700 [&_.pagination_a]:text-gray-700 [&_.pagination_a]:dark:text-gray-200 [&_.pagination_a]:border-gray-300 [&_.pagination_a]:dark:border-gray-600 [&_.pagination_span]:bg-white [&_.pagination_span]:dark:bg-gray-700 [&_.pagination_span]:text-gray-700 [&_.pagination_span]:dark:text-gray-200 [&_.pagination_span]:border-gray-300 [&_.pagination_span]:dark:border-gray-600">
                            {{ $activities->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (min-width: 640px) {
            .card {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 639px) {
            .card {
                padding: 1rem;
            }
        }
    </style>
</x-app-layout>