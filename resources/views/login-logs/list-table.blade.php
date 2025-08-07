<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-100 leading-tight text-center sm:text-left">
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
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">IP Address</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($logs as $log)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="@if($log->description == 'user_login') text-green-600 dark:text-green-400 @else text-blue-600 dark:text-blue-400 @endif font-medium">
                                                @if($log->description == 'user_login')
                                                    Login
                                                @else
                                                    Logout
                                                @endif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($log->causer)
                                                <div class="flex items-center">
                                                    <div class="flex-shrink-0 h-10 w-10">
                                                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ $log->causer->first_name }} {{ $log->causer->last_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $log->causer->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-500 dark:text-gray-400">System</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $log->formatted_properties[0]['value'] ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $log->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $log->created_at->format('g:i A') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                    {{ $log->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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