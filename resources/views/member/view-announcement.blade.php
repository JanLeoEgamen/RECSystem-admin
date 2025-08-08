<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] via-[#5E6FFB] to-[#8AA9FF]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Announcement Details
            </h2>

            <a href="{{ route('member.announcements') }}" class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center font-medium border border-white hover:border-white transition">
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