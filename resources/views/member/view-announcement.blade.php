@vite('resources/css/announcements.css')

<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        Announcement Details
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Stay informed with important updates</p>
                </div>

                <div class="flex justify-center sm:justify-end">
                    <a href="{{ route('member.announcements') }}" class="group interactive-btn inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border border-white/30 hover:bg-white hover:text-[#101966] transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Announcements
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Announcement Header Card -->
            <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-800 dark:via-gray-900 dark:to-black backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden mb-8 animate-slide-in-up border border-gray-200 dark:border-gray-200" style="animation-delay: 0.2s;">
                <div class="p-6 sm:p-8 text-white">
                    <div class="flex items-start space-x-6">
                        <div class="p-4 bg-white/20 rounded-2xl">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h1 class="text-3xl sm:text-4xl font-bold mb-4 leading-tight">{{ $announcement->title }}</h1>
                            
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <div class="flex items-center bg-white/20 dark:bg-blue-500/20 dark:border-blue-700/30 backdrop-blur-sm border border-white/30 rounded-full px-4 py-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Posted: {{ $announcement->created_at->format('M d, Y h:i A') }}
                                </div>
                                
                                @if($announcement->pivot->read_at)
                                    <div class="flex items-center bg-green-500/20 backdrop-blur-sm border border-green-400/30 rounded-full px-4 py-2">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Read: {{ \Carbon\Carbon::parse($announcement->pivot->read_at)->format('M d, Y h:i A') }}
                                    </div>
                                @else
                                    <div class="flex items-center bg-red-500/20 backdrop-blur-sm border border-red-400/30 rounded-full px-4 py-2 animate-pulse">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        First time reading
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="max-w-4xl mx-auto">
                
                <!-- Content Section -->
                <div class="bg-white dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-xl p-6 sm:p-8 border border-gray-200 dark:border-gray-400 animate-scale-in" style="animation-delay: 0.4s;">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 gradient-bg-purple rounded-xl shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Announcement Content</h2>
                            <p class="text-gray-600 dark:text-gray-400">Important information for you</p>
                        </div>
                    </div>
                    
                    <div class="prose prose-lg max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
                        {!! $announcement->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>