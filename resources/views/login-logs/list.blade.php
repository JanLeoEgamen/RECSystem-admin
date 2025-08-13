<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('User Login Logs') }}
            </h2>
        </div>
    </x-slot>

    <!-- Navigation Tabs -->
    <div class="flex border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('login-logs.index', ['view' => 'timeline']) }}" 
           class="@if(request('view', 'timeline') === 'timeline') border-indigo-500 text-indigo-600 dark:text-indigo-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif flex-1 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors">
            <div class="flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Timeline View
            </div>
        </a>
        <a href="{{ route('login-logs.indexTable', ['view' => 'table']) }}" 
           class="@if(request('view') === 'table') border-indigo-500 text-indigo-600 dark:text-indigo-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif flex-1 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors">
            <div class="flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                Table View
            </div>
        </a>
    </div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Filters Bar -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                        <!-- Summary Stats - Left Side -->
                        <div class="flex gap-2 text-sm items-center order-2 md:order-1">
                            <div class="bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 px-3 py-1.5 rounded-full shadow-sm">
                                <span class="font-medium">Total:</span> {{ $logs->total() }}
                            </div>
                            @if(request()->anyFilled(['search', 'login_type']))
                            <div class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1.5 rounded-full shadow-sm">
                                <span class="font-medium">Filtered:</span> {{ $logs->count() }}
                            </div>
                            @endif
                        </div>

                        <!-- Search and Export - Right Side -->
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto order-1 md:order-2">
                            <!-- Search Form -->
                            <form method="GET" action="{{ route('login-logs.index') }}" class="flex-1 min-w-[250px]">
                                <div class="flex shadow-sm">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        placeholder="Search by name or email..." 
                                        value="{{ request('search') }}"
                                        class="flex-1 min-w-0 px-4 py-2 rounded-l-lg border border-gray-300 dark:border-gray-600 
                                               focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                               dark:bg-gray-700 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                                    >
                                    <button 
                                        type="submit" 
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 border border-indigo-600 border-l-0 rounded-r-lg transition flex items-center gap-1"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <span class="hidden sm:inline">Search</span>
                                    </button>
                                </div>
                                <div class="flex mt-3">
                                    <select 
                                        name="login_type" 
                                        class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                                    >
                                        <option value="">All Login Types</option>
                                        <option value="user_login" {{ request('login_type') == 'user_login' ? 'selected' : '' }}>Logins</option>
                                        <option value="user_logout" {{ request('login_type') == 'user_logout' ? 'selected' : '' }}>Logouts</option>
                                    </select>
                                </div>
                            </form>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                @if(request()->anyFilled(['search', 'login_type']))
                                    <a 
                                        href="{{ route('login-logs.index') }}" 
                                        class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-600 
                                               dark:hover:bg-gray-500 text-gray-700 dark:text-white 
                                               px-4 py-2 rounded-lg transition flex items-center gap-1 border border-gray-200 dark:border-gray-600"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span class="hidden sm:inline">Reset</span>
                                    </a>
                                @endif

                                <!-- Export Button -->
                                <form method="GET" action="{{ route('login-logs.export') }}">
                                    <input type="hidden" name="export" value="pdf">
                                    <input type="hidden" name="view" value="{{ request('view', 'timeline') }}">
                                    @if(request()->has('search'))
                                        <input type="hidden" name="search" value="{{ request('search') }}">
                                    @endif
                                    @if(request()->has('login_type'))
                                        <input type="hidden" name="login_type" value="{{ request('login_type') }}">
                                    @endif
                                    <button 
                                        type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition flex items-center justify-center gap-1 border border-green-600 shadow-sm"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span class="hidden sm:inline">Export</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if($logs->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-700 dark:text-gray-300">No login logs found</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria</p>
                        </div>
                    @else
                        <!-- Timeline Container -->
                        <div class="relative">
                            <!-- Timeline Line -->
                            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-indigo-200 dark:bg-gray-600"></div>

                            <!-- Start Marker -->
                            <div class="absolute left-8 top-0 transform -translate-x-1/2 -translate-y-1/2 w-4 h-4 rounded-full bg-indigo-500 border-2 border-white dark:border-gray-800"></div>

                            <!-- End Marker -->
                            <div class="absolute left-8 bottom-0 transform -translate-x-1/2 translate-y-1/2 w-4 h-4 rounded-full bg-indigo-500 border-2 border-white dark:border-gray-800"></div>
                            
                            <!-- Log Cards -->
                            <div class="space-y-8 pl-12">
                                @foreach($logs as $log)
                                <div class="relative">
                                    <!-- Timeline Dot -->
                                    <div class="absolute left-0 top-1/2 transform -translate-x-full -translate-y-1/2 w-4 h-4 rounded-full bg-indigo-500 border-2 border-white dark:border-gray-800"></div>
                                        
                                    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4 transition hover:shadow-lg">
                                        <div class="flex flex-col sm:flex-row justify-between gap-4">
                                            <!-- Left Side -->
                                            <div class="flex-1 space-y-2">
                                                <h3 class="font-bold @if($log->description == 'user_login') text-green-600 dark:text-green-400 @else text-blue-600 dark:text-blue-400 @endif">
                                                    @if($log->description == 'user_login')
                                                        User Login
                                                    @else
                                                        User Logout
                                                    @endif
                                                </h3>

                                                <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <span>
                                                        @if($log->causer)
                                                            {{ $log->causer->first_name }} {{ $log->causer->last_name }}
                                                            <span class="text-gray-400">({{ $log->causer->email }})</span>
                                                        @else
                                                            System generated
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Right Side - Date -->
                                            <div class="sm:text-right">
                                                <div class="flex items-center justify-end gap-1 text-sm text-gray-500 dark:text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{ $log->created_at->format('M j, Y g:i A') }}</span>
                                                </div>
                                                <div class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                    {{ $log->created_at->diffForHumans() }}
                                                </div>
                                                <div class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                    IP: {{ $log->formatted_properties[0]['value'] ?? 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6">
                            {{ $logs->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>