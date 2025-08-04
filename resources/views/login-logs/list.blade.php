<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Login Logs') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Search Form -->
                    <div class="mb-6">
                        <form method="GET" action="{{ route('login-logs.index') }}">
                            <div class="flex">
                                <input 
                                    type="text" 
                                    name="search" 
                                    placeholder="Search by name or email..." 
                                    value="{{ request('search') }}"
                                    class="w-full px-4 py-2 rounded-l-lg border border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white"
                                >
                                <button 
                                    type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg transition duration-200"
                                >
                                    Search
                                </button>
                                @if(request('search'))
                                    <a 
                                        href="{{ route('login-logs.index') }}" 
                                        class="ml-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-800 dark:text-white px-4 py-2 rounded-lg transition duration-200"
                                    >
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="flex justify-end mb-6">
                        <form method="GET" action="{{ route('login-logs.export') }}">
                            <input type="hidden" name="export" value="pdf">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('login_type'))
                                <input type="hidden" name="login_type" value="{{ request('login_type') }}">
                            @endif
                            <button 
                                type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Export to PDF
                            </button>
                        </form>
                    </div>

                    @if($logs->isEmpty())
                        <p class="text-center py-4">No login logs found.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($logs as $log)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow activity-card">
                                    <div class="border-b border-gray-200 dark:border-gray-600 pb-2 mb-2">
                                        <div class="flex justify-between items-center">
                                            <h3 class="font-bold text-lg @if($log->description == 'user_login') text-green-600 dark:text-green-400 @else text-blue-600 dark:text-blue-400 @endif">
                                                @if($log->description == 'user_login')
                                                    User Login
                                                @else
                                                    User Logout
                                                @endif
                                            </h3>
                                            <span class="text-xs text-gray-400">
                                                {{ $log->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold">
                                                @if($log->causer)
                                                    {{ $log->causer->first_name }} {{ $log->causer->last_name }}
                                                    <span class="block text-sm text-gray-500 dark:text-gray-400">{{ $log->causer->email }}</span>
                                                @else
                                                    System generated
                                                @endif
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                IP: {{ $log->formatted_properties[0]['value'] ?? 'N/A' }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ $log->created_at->format('Y-m-d H:i:s') }}
                                            </p>
                                        </div>
                                    </div>
                                    
                                    @if($log->properties->isNotEmpty())
                                        <div class="mt-3 p-3 bg-gray-100 dark:bg-gray-600 rounded text-sm">
                                            <details>
                                                <summary class="cursor-pointer font-medium">Login Details</summary>
                                                <div class="mt-2 overflow-x-auto p-2 bg-white dark:bg-gray-800 rounded">
                                                    <div class="overflow-x-auto">
                                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                            <thead class="bg-gray-50 dark:bg-gray-700">
                                                                <tr>
                                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Property</th>
                                                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Value</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                                @foreach($log->formatted_properties as $property)
                                                                    <tr>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $property['field'] }}</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $property['value'] }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </details>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $logs->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>