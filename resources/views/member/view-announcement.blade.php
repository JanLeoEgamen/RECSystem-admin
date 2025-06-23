<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Announcement Details
            </h2>
            <a href="{{ route('member.announcements') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Announcements
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold">{{ $announcement->title }}</h1>
                        <div class="flex items-center mt-2 text-sm text-gray-500">
                            <span>Posted on: {{ $announcement->created_at->format('M d, Y h:i A') }}</span>
                            @if($announcement->pivot->read_at)
                                <span class="mx-2">•</span>
                                <span>Read on: {{ \Carbon\Carbon::parse($announcement->pivot->read_at)->format('M d, Y h:i A') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        {!! $announcement->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>