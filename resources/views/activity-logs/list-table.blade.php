<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Activity Logs') }}
            </h2>
        </div>
    </x-slot>

        <!-- Navigation Tabs -->
    <div class="flex border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('activity-logs.index', ['view' => 'timeline']) }}" 
           class="@if(request('view', 'timeline') === 'timeline') border-indigo-500 text-indigo-600 dark:text-indigo-400 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 @endif flex-1 whitespace-nowrap py-4 px-4 border-b-2 font-medium text-sm transition-colors">
            <div class="flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Timeline View
            </div>
        </a>
        <a href="{{ route('activity-logs.indexTable', ['view' => 'table']) }}" 
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
                            <span class="font-medium">Total:</span> {{ $activities->total() }}
                        </div>
                        @if(request()->anyFilled(['start_date', 'end_date']))
                        <div class="bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 px-3 py-1.5 rounded-full shadow-sm">
                            <span class="font-medium">Filtered:</span> {{ $activities->count() }}
                        </div>
                        @endif
                    </div>

                    <!-- Search and Export - Right Side -->
                    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto order-1 md:order-2">
                        <!-- Search Form -->
                        <form method="GET" action="{{ route('activity-logs.index') }}" class="flex-1 min-w-[250px]">
                            <div class="flex shadow-sm">
                                <input 
                                    type="text" 
                                    name="search" 
                                    placeholder="Search logs..." 
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
                        </form>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            @if(request()->anyFilled(['search', 'start_date', 'end_date']))
                                <a 
                                    href="{{ route('activity-logs.index') }}" 
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
                            <form method="GET" action="{{ route('activity-logs.index') }}">
                                <input type="hidden" name="export" value="pdf">
                                <input type="hidden" name="view" value="{{ request('view', 'timeline') }}">
                                @if(request()->has('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
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

                    @if($activities->isEmpty())
                        <div class="text-center py-12">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-700 dark:text-gray-300">No activity logs found</h3>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">Try adjusting your search or filter criteria</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Changes</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($activities as $activity)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-medium text-indigo-600 dark:text-indigo-400">
                                                {{ ucfirst($activity->log_name) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-gray-700 dark:text-gray-300">
                                                {{ ucfirst($activity->description) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                <span>{{ $activity->causer ? $activity->causer->first_name.' '.$activity->causer->last_name : 'System' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($activity->properties->isNotEmpty())
                                                <details class="group">
                                                    <summary class="flex items-center justify-between p-1 -mx-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer transition-colors">
                                                        <div class="flex items-center space-x-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500 group-open:rotate-90 transform transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg>
                                                            <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">View Changes</span>
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                                {{ count($activity->formatted_properties) }} {{ Str::plural('change', count($activity->formatted_properties)) }}
                                                            </span>
                                                        </div>
                                                    </summary>
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        @foreach($activity->formatted_properties as $property)
                                                            <div class="flex items-start bg-gray-100 dark:bg-gray-700 rounded-lg p-2 text-sm">
                                                                <span class="font-medium text-gray-700 dark:text-gray-300 mr-2">{{ $property['field'] }}:</span>
                                                                <span class="text-gray-600 dark:text-gray-400 break-words">
                                                                    @if($activity->description === 'updated')
                                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 mr-1">
                                                                            {{ $property['old'] ?? '(empty)' }}
                                                                        </span>
                                                                        <span class="text-gray-400 dark:text-gray-500 mx-1">→</span>
                                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                                            {{ $property['new'] ?? '(empty)' }}
                                                                        </span>
                                                                    @elseif($activity->description === 'created')
                                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                                            {{ $property['new'] ?? '(empty)' }}
                                                                        </span>
                                                                    @elseif($activity->description === 'deleted')
                                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                                            {{ $property['old'] ?? '(empty)' }}
                                                                        </span>
                                                                    @else
                                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                                                            {{ is_array($property['value']) ? json_encode($property['value']) : ($property['value'] ?? '(empty)') }}
                                                                        </span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </details>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <div class="flex items-center gap-1 text-sm text-gray-500 dark:text-gray-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>{{ $activity->created_at->format('M j, Y g:i A') }}</span>
                                                </div>
                                                <div class="mt-1 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $activities->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>