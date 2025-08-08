<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] via-[#5E6FFB] to-[#8AA9FF]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Document Details
            </h2>

            <a href="{{ route('member.documents') }}" class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center font-medium border border-white hover:border-white transition">
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
                            @if($document->pivot->viewed_at)
                                <span class="mx-2">•</span>
                                <span>Viewed on: {{ \Carbon\Carbon::parse($document->pivot->viewed_at)->format('M d, Y h:i A') }}</span>
                            @endif
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
                                View External Document
                            </a>
                            <a href="{{ route('member.download-document', $document->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                <i class="fas fa-download mr-2"></i>
                                Download External Link
                            </a>
                        @elseif($document->file_path)
                            <a href="{{ Storage::disk('public')->url($document->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                <i class="fas {{ $document->file_icon }} mr-2"></i>
                                View Document ({{ $document->file_size }})
                            </a>
                            <a href="{{ route('member.download-document', $document->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                <i class="fas fa-download mr-2"></i>
                                Download Document
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>