<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ __('Create Database Backup') }}">
            <x-slot name="actionButton">
                <a href="{{ route('backups.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md text-sm">
                    Back to List
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="max-w-2xl mx-auto">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-6">
                            <div class="flex items-start">
                                <svg class="h-6 w-6 text-blue-600 dark:text-blue-400 mr-3 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium text-blue-800 dark:text-blue-200">Important Information</h3>
                                    <p class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                        Creating a database backup may take several minutes depending on your database size. 
                                        The backup process will lock certain tables during execution. It's recommended to 
                                        perform backups during off-peak hours.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('backups.store') }}" method="POST">
                            @csrf
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Backup Type
                                    </label>
                                    <div class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md p-4">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">Full Database Backup (MySQL Dump)</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Estimated Size
                                    </label>
                                    <div class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md p-4">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">
                                                @if(is_numeric($dbSize))
                                                    Approximately {{ number_format($dbSize) }} KB
                                                @else
                                                    Size: {{ $dbSize }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <a href="{{ route('backups.index') }}" 
                                       class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-md text-sm">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md text-sm flex items-center">
                                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        Create Backup Now
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>