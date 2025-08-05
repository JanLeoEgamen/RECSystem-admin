<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                    {{ __('Audit Trail') }}
                </h2>
                <p class="text-indigo-200 dark:text-indigo-300 mt-1">
                    Track all system activities and user actions
                </p>
            </div>
            <div class="flex space-x-3">
                <!-- Date Filter Dropdown -->
                <div class="relative">
                    <button id="dateFilterBtn" class="flex items-center space-x-1 bg-gray-700 hover:bg-gray-600 text-white px-3 py-2 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Filter</span>
                    </button>
                    <div id="dateFilterDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white dark:bg-gray-700 rounded-lg shadow-xl z-10 p-4 border border-gray-200 dark:border-gray-600">
                        <form method="GET" action="{{ route('activity-logs.index') }}">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 shadow-sm">
                                </div>
                                <div class="flex justify-between pt-2">
                                    <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded-md text-sm">Apply</button>
                                    <a href="{{ route('activity-logs.index') }}" class="text-gray-500 dark:text-gray-400 text-sm hover:underline">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Export Dropdown -->
                <div class="relative">
                    <button id="exportBtn" class="flex items-center space-x-1 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Export</span>
                    </button>
                    <div id="exportDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-lg shadow-xl z-10 py-1 border border-gray-200 dark:border-gray-600">
                        <form method="GET" action="{{ route('activity-logs.index') }}">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('start_date'))
                                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                            @endif
                            @if(request('end_date'))
                                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                            @endif
                            <button type="submit" name="export" value="pdf" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 w-full text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                                PDF
                            </button>
                            <button type="submit" name="export" value="csv" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 w-full text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <!-- Filters Bar -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-3 md:space-y-0">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('activity-logs.index') }}" class="w-full md:w-auto">
                            <div class="flex">
                                <input 
                                    type="text" 
                                    name="search" 
                                    placeholder="Search logs..." 
                                    value="{{ request('search') }}"
                                    class="w-full md:w-64 px-4 py-2 rounded-l-lg border border-gray-300 dark:border-gray-600 
                                           focus:outline-none focus:ring-2 focus:ring-indigo-500 
                                           dark:bg-gray-700 dark:text-white"
                                >
                                <button 
                                    type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg transition duration-200 flex items-center"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    Search
                                </button>
                                @if(request('search') || request('start_date') || request('end_date'))
                                    <a 
                                        href="{{ route('activity-logs.index') }}" 
                                        class="ml-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 
                                               dark:hover:bg-gray-500 text-gray-800 dark:text-white 
                                               px-4 py-2 rounded-lg transition duration-200 flex items-center"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>

                        <!-- Summary Stats -->
                        <div class="flex space-x-4 text-sm">
                            <div class="bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 px-3 py-1 rounded-full">
                                Total: {{ $activities->total() }}
                            </div>
                            @if(request('start_date') || request('end_date'))
                            <div class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1 rounded-full">
                                Filtered: {{ $activities->count() }}
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($activities->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-700 dark:text-gray-300">No activity logs found</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria</p>
                        </div>
                    @else
                        <!-- Timeline with Tabs -->
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap -mb-px" id="logTabs" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="all-tab" data-tabs-target="#all" type="button" role="tab" aria-controls="all" aria-selected="true">All Activities</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="user-tab" data-tabs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="false">User Actions</button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="system-tab" data-tabs-target="#system" type="button" role="tab" aria-controls="system" aria-selected="false">System Events</button>
                                </li>
                            </ul>
                        </div>

                        <!-- Vertical Timeline -->
                        <div class="relative border-l-2 border-indigo-400 ml-4 space-y-8">
                            @foreach($activities as $activity)
                                <div class="relative pl-8 group">

                                    <!-- Timeline Dot with Icon -->
                                    <div class="absolute left-0 top-1/2 -translate-x-1/2 -translate-y-1/2
                                                w-5 h-5 bg-indigo-500 rounded-full
                                                border-4 border-white dark:border-gray-800
                                                flex items-center justify-center text-white text-xs
                                                group-hover:bg-indigo-600 group-hover:scale-110 transition-transform">
                                        @if($activity->description == 'created')
                                            +
                                        @elseif($activity->description == 'updated')
                                            ↻
                                        @elseif($activity->description == 'deleted')
                                            ×
                                        @else
                                            !
                                        @endif
                                    </div>

                                    <!-- Log Card -->
                                    <div class="bg-white dark:bg-gray-700 shadow rounded-lg p-4 transition hover:shadow-lg hover:border-l-2 hover:border-indigo-300">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-2 py-1 text-xs rounded-full 
                                                        @if($activity->description == 'created') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                        @elseif($activity->description == 'updated') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                        @elseif($activity->description == 'deleted') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                        @else bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200 @endif">
                                                        {{ ucfirst($activity->description) }}
                                                    </span>
                                                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
                                                        {{ ucfirst($activity->log_name) }}
                                                    </span>
                                                </div>
                                                <h3 class="font-semibold mt-1">
                                                    {{ $activity->event ?? 'Action performed' }}
                                                </h3>
                                                
                                                <div class="flex flex-wrap items-center gap-2 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                    @if($activity->causer)
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            {{ $activity->causer->first_name }} {{ $activity->causer->last_name }}
                                                        </div>
                                                    @else
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                                                            </svg>
                                                            System Generated
                                                        </div>
                                                    @endif
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        {{ $activity->created_at->format('M j, Y g:i A') }}
                                                        <span class="ml-1">({{ $activity->created_at->diffForHumans() }})</span>
                                                    </div>
                                                    @if($activity->properties->isNotEmpty())
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                            </svg>
                                                            {{ count($activity->formatted_properties) }} changes
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition" title="Copy ID">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Activity Details -->
                                        @if($activity->properties->isNotEmpty())
                                            <div class="mt-3">
                                                <details class="group">
                                                    <summary class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-600 rounded cursor-pointer">
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500 group-open:rotate-90 transform transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                            <span class="font-medium">View Details</span>
                                                        </div>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ count($activity->formatted_properties) }} changes
                                                        </span>
                                                    </summary>
                                                    <div class="mt-2 p-3 bg-gray-50 dark:bg-gray-600 rounded">
                                                        @if(is_array($activity->formatted_properties) && !isset($activity->formatted_properties['raw']))
                                                            <div class="overflow-x-auto">
                                                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                                                        <tr>
                                                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Field</th>
                                                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Before</th>
                                                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">After</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                                        @foreach($activity->formatted_properties as $property)
                                                                            <tr>
                                                                                <td class="px-4 py-2 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                                                                    {{ $property['field'] }}
                                                                                </td>
                                                                                <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                                                                                    @if(is_array($property['old']))
                                                                                        <pre class="text-xs">{{ json_encode($property['old'], JSON_PRETTY_PRINT) }}</pre>
                                                                                    @else
                                                                                        {{ $property['old'] ?? '<empty>' }}
                                                                                    @endif
                                                                                </td>
                                                                                <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">
                                                                                    @if(is_array($property['new']))
                                                                                        <pre class="text-xs">{{ json_encode($property['new'], JSON_PRETTY_PRINT) }}</pre>
                                                                                    @else
                                                                                        {{ $property['new'] ?? '<empty>' }}
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @else
                                                            <div class="p-3 bg-white dark:bg-gray-800 rounded">
                                                                <pre class="text-sm overflow-x-auto">{{ json_encode($activity->formatted_properties['raw'] ?? $activity->properties, JSON_PRETTY_PRINT) }}</pre>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </details>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination with Summary -->
                        <div class="mt-6 flex flex-col md:flex-row items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-4 md:mb-0">
                                Showing <span class="font-medium">{{ $activities->firstItem() }}</span> to <span class="font-medium">{{ $activities->lastItem() }}</span> of <span class="font-medium">{{ $activities->total() }}</span> results
                            </div>
                            <div class="flex items-center space-x-1">
                                {{ $activities->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle dropdown menus
        document.getElementById('dateFilterBtn').addEventListener('click', function() {
            document.getElementById('dateFilterDropdown').classList.toggle('hidden');
            document.getElementById('exportDropdown').classList.add('hidden');
        });

        document.getElementById('exportBtn').addEventListener('click', function() {
            document.getElementById('exportDropdown').classList.toggle('hidden');
            document.getElementById('dateFilterDropdown').classList.add('hidden');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#dateFilterBtn') && !event.target.closest('#dateFilterDropdown')) {
                document.getElementById('dateFilterDropdown').classList.add('hidden');
            }
            if (!event.target.closest('#exportBtn') && !event.target.closest('#exportDropdown')) {
                document.getElementById('exportDropdown').classList.add('hidden');
            }
        });

        // Tab functionality
        const tabs = document.querySelectorAll('[data-tabs-target]');
        const tabContents = document.querySelectorAll('[data-tabs-content]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = document.querySelector(tab.dataset.tabsTarget);
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                target.classList.remove('hidden');
                
                tabs.forEach(t => {
                    t.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-500');
                    t.classList.add('border-transparent', 'hover:text-gray-600', 'dark:hover:text-gray-300');
                });
                
                tab.classList.remove('border-transparent', 'hover:text-gray-600', 'dark:hover:text-gray-300');
                tab.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-500');
            });
        });
    </script>
</x-app-layout>