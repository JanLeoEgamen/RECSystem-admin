<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            My Files
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($files->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($files as $file)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <h3 class="text-lg font-semibold mb-2">{{ $file->title }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                        {{ Str::limit($file->description, 100) }}
                                    </p>
                                    
                                    <div class="space-y-2 text-sm mb-4">
                                        <div class="flex justify-between">
                                            <span class="text-gray-500 dark:text-gray-400">Assigned by:</span>
                                            <span>{{ $file->assigner->full_name ?? 'Unknown' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500 dark:text-gray-400">Due date:</span>
                                            <span>{{ $file->due_date ? $file->due_date->format('M d, Y') : 'No due date' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500 dark:text-gray-400">Required:</span>
                                            <span class="{{ $file->is_required ? 'text-red-600 dark:text-red-400' : 'text-green-600 dark:text-green-400' }}">
                                                {{ $file->is_required ? 'Yes' : 'No' }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-500 dark:text-gray-400">Status:</span>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $file->latestUpload ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $file->latestUpload ? 'Uploaded' : 'Pending' }}
                                            </span>
                                        </div>
                                        @if($file->latestUpload)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500 dark:text-gray-400">Last upload:</span>
                                            <span>{{ \Carbon\Carbon::parse($file->latestUpload->uploaded_at)->format('M d, Y H:i') }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('member.view-file', $file->id) }}" 
                                           class="flex-1 text-center px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $files->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No files assigned</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You don't have any files assigned to you yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>