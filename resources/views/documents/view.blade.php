<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Document Details
            </h2>
            <a href="{{ route('documents.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Documents
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold">{{ $document->title }}</h1>
                        <div class="flex items-center mt-2 text-sm text-gray-500">
                            <span>Posted on: {{ $document->created_at->format('M d, Y h:i A') }}</span>
                            <span class="mx-2">•</span>
                            <span>Status: {{ $document->is_published ? 'Published' : 'Draft' }}</span>
                        </div>
                    </div>

                    @if($document->description)
                    <div class="prose max-w-none mb-6">
                        {!! nl2br(e($document->description)) !!}
                    </div>
                    @endif

                    <div class="mb-6">
                        @if($document->url)
                            <a href="{{ $document->url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                View External Link
                            </a>
                        @elseif($document->file_path)
                            <a href="{{ route('documents.download', $document->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                <i class="fas {{ $document->file_icon }} mr-2"></i>
                                Download Document ({{ $document->file_size }})
                            </a>
                        @endif
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-semibold mb-4">Viewers</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            @if($members->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($members as $member)
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                <span class="text-gray-600 dark:text-gray-300 font-medium">
                                                    {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    @if($member->pivot->is_viewed)
                                                        Viewed on {{ \Carbon\Carbon::parse($member->pivot->viewed_at)->format('M d, Y h:i A') }}
                                                    @else
                                                        Not viewed yet
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">No members have viewed this document yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>