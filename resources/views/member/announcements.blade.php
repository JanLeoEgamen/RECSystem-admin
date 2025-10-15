<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        My Announcements
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Stay updated with the latest news and updates</p>
                </div>
            </div>
        </div>
    </x-slot>

    @vite('resources/css/announcements.css')

    <div class="py-8 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @php
                $totalAnnouncements = $announcements->total();
                $unreadAnnouncements = $announcements->where('pivot.is_read', false)->count();
                $readAnnouncements = $announcements->where('pivot.is_read', true)->count();
                $todayAnnouncements = $announcements->filter(function($announcement) {
                    return $announcement->created_at->isToday();
                })->count();
            @endphp

            <!-- Announcements Overview -->
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden mb-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-800 dark:via-gray-900 dark:to-black p-6 sm:p-8 text-white">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between space-y-4 sm:space-y-0 mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">Announcements Overview</h3>
                                <p class="text-blue-100 dark:text-gray-300">Stay informed with the latest updates</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="card-overview-item transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-500/40 relative animate-slide-up" style="animation-delay: 0.1s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $totalAnnouncements }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Total</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-500/40 relative animate-slide-up" style="animation-delay: 0.2s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-red-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold text-red-200">{{ $unreadAnnouncements }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Unread</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-500/40 relative animate-slide-up" style="animation-delay: 0.3s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-green-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $readAnnouncements }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Read</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-500/40 relative animate-slide-up" style="animation-delay: 0.4s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-yellow-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $todayAnnouncements }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Today</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcements List -->
            <div class="space-y-6 animate-slide-up" style="animation-delay: 0.3s">
                @forelse($announcements as $index => $announcement)
                    <div class="group relative overflow-hidden bg-blue-100 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-xl border border-blue-700 dark:border-gray-600/30 hover:transform hover:-translate-y-2 hover:shadow-2xl dark:hover:shadow-gray-900/20 transition-all duration-300 cursor-pointer {{ !$announcement->pivot->is_read ? 'border-l-4 border-l-red-500 dark:border-l-red-400' : '' }} animate-slide-up" 
                         style="animation-delay: {{ ($index * 0.1) + 0.4 }}s"
                         onclick="window.location.href='{{ route('member.view-announcement', $announcement->id) }}'">
                        
                        <div class="p-6 sm:p-8">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                                <!-- Content Section -->
                                <div class="flex-1">
                                    <div class="flex items-start space-x-4">
                                        <!-- Icon -->
                                        <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl transform transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                            </svg>
                                        </div>
                                        
                                        <!-- Title and Meta -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2 line-clamp-2 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors duration-300">
                                                {{ $announcement->title }}
                                            </h3>
                                            
                                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span>{{ $announcement->created_at->format('M d, Y h:i A') }}</span>
                                                </div>
                                                
                                                @if($announcement->created_at->isToday())
                                                    <span class="inline-flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 rounded-full text-xs font-medium">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                        </svg>
                                                        Today
                                                    </span>
                                                @elseif($announcement->created_at->isYesterday())
                                                    <span class="inline-flex items-center px-2 py-1 bg-orange-100 dark:bg-orange-900/50 text-orange-700 dark:text-orange-300 rounded-full text-xs font-medium">
                                                        Yesterday
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <!-- Preview Content -->
                                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed line-clamp-3">
                                                {{ Str::limit(strip_tags($announcement->content), 180) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Status and Action Section -->
                                <div class="flex-shrink-0 flex flex-col items-center sm:items-end space-y-3">
                                    @if(!$announcement->pivot->is_read)
                                        <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-full text-xs font-bold shadow-lg pulse-glow">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            New
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 rounded-full text-xs font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Read
                                        </span>
                                    @endif
                                    
                                    <!-- Read More Button -->
                                    <div class="shimmer-button inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg text-sm group">
                                        <span>Read More</span>
                                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-slide-up">
                        <div class="p-12 text-center">
                            <div class="w-24 h-24 mx-auto mb-6">
                                <svg class="w-full h-full text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">No Announcements Found</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">
                                There are no announcements available at this time. Check back later for updates!
                            </p>
                            <div class="shimmer-button inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Refresh Page
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($announcements->hasPages())
                <div class="mt-8 animate-slide-up" style="animation-delay: 0.6s">
                    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-lg p-6 border border-white/20 dark:border-gray-600/30">
                        {{ $announcements->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Floating Help Button -->
    <div class="floating-btn">
        <button onclick="showHelpModal()" class="interactive-btn p-4 bg-gradient-to-r from-[#101966] to-blue-600 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </button>
    </div>

    <!-- Include required libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Help modal function
        window.showHelpModal = function() {
            Swal.fire({
                title: 'Announcements Help',
                html: `
                    <div class="text-left space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">📢 Stay Updated</h4>
                            <p class="text-sm text-blue-800 dark:text-blue-300">This page shows all announcements relevant to your membership. Check regularly for important updates and news.</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-900 dark:text-green-200 mb-2">🔴 Unread Notifications</h4>
                            <p class="text-sm text-green-800 dark:text-green-300">Announcements with a red border on the left are unread. Click on any announcement to view its full content.</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-200 mb-2">📱 Mobile Friendly</h4>
                            <p class="text-sm text-purple-800 dark:text-purple-300">This page is optimized for mobile devices. You can access announcements from anywhere, anytime.</p>
                        </div>
                    </div>
                `,
                background: '#ffffff',
                color: '#374151',
                confirmButtonColor: '#101966',
                confirmButtonText: 'Got it!'
            });
        };
    </script>

    <style>
        /* Floating Help Button */
        .floating-btn {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            z-index: 50;
        }
        
        .interactive-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .interactive-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .interactive-btn:active {
            transform: scale(0.95);
        }
    </style>
</x-app-layout>