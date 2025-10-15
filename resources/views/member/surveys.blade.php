@vite('resources/css/surveys.css')

<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        Available Surveys
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Share your valuable feedback and insights</p>
                </div>
                <div class="flex items-center space-x-3 justify-center sm:justify-start">
                    <div class="px-4 py-2 bg-[#101966] dark:bg-white/20 backdrop-blur-sm rounded-lg">
                        <span class="text-white text-sm font-medium">{{ $surveys->count() }} Surveys</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @php
                $totalSurveys = $surveys->count();
                $completedSurveys = $surveys->filter(function($survey) {
                    return $survey->responses->where('member_id', auth()->user()->member->id)->count() > 0;
                })->count();
                $pendingSurveys = $totalSurveys - $completedSurveys;
                $todaySurveys = $surveys->filter(function($survey) {
                    return $survey->created_at->isToday();
                })->count();
            @endphp

            <!-- Surveys Statistics -->
            <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden mb-8 border border-gray-200 dark:border-gray-700 transition-all duration-300 animate-slide-up" style="animation-delay: 0.1s;">
                <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-800 dark:via-gray-900 dark:to-black p-6 sm:p-8 text-white">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center sm:justify-between space-y-4 sm:space-y-0 mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">Surveys Overview</h3>
                                <p class="text-blue-100 dark:text-gray-300">Share your valuable feedback and insights</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-400 relative animate-slide-up" style="animation-delay: 0.1s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-blue-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $totalSurveys }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Total Surveys</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-400 relative animate-slide-up" style="animation-delay: 0.2s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-green-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $completedSurveys }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Completed</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-400 relative animate-slide-up" style="animation-delay: 0.3s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-orange-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $pendingSurveys }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">Pending</p>
                                </div>
                            </div>
                        </div>
                        <div class="transition-all duration-300 hover:-translate-y-1 bg-white/10 dark:bg-white/5 rounded-xl p-4 border border-blue-200 dark:border-gray-400 hover:dark:bg-white/8 hover:dark:border-blue-400 relative animate-slide-up" style="animation-delay: 0.4s">
                            <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent rounded-xl"></div>
                            <div class="relative flex items-center space-x-3">
                                <div class="p-2 bg-purple-500/20 rounded-lg">
                                    <svg class="w-5 h-5 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-2xl font-bold">{{ $todaySurveys }}</p>
                                    <p class="text-xs text-blue-100 dark:text-gray-300">New Today</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($surveys->isEmpty())
                <!-- Empty State -->
                <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-slide-up">
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 mx-auto mb-6">
                            <svg class="w-full h-full text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">No Surveys Available</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">
                            There are no surveys available at this time. Check back later for new survey opportunities!
                        </p>
                        <button onclick="window.location.reload()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Refresh
                        </button>
                    </div>
                </div>
            @else
                <!-- Surveys Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 0.3s">
                    @foreach($surveys as $index => $survey)
                        @php
                            $isCompleted = $survey->responses->where('member_id', auth()->user()->member->id)->count() > 0;
                        @endphp

                        <div class="bg-gray-100 dark:bg-gray-600 rounded-3xl shadow-xl overflow-hidden animate-slide-up" style="animation-delay: {{ ($index * 0.1) + 0.4 }}s"
                             onclick="window.location.href='{{ route('member.take-survey', $survey->id) }}'">
                            
                            <!-- Survey Header -->
                            <div class="relative p-6 bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:bg-gradient-to-br dark:from-gray-700 dark:via-gray-800 dark:to-gray-900 text-white">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-xl font-bold mb-2 pr-4">{{ $survey->title }}</h3>
                                        <div class="flex items-center space-x-2 text-sm opacity-90">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $survey->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div class="flex-shrink-0">
                                        @if($isCompleted)
                                            <span class="status-completed inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white shadow-lg">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Completed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white shadow-lg bg-gradient-to-r from-red-500 to-red-600">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                New
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($survey->created_at->isToday())
                                    <div class="inline-flex items-center px-2 py-1 bg-white/20 rounded-lg text-xs font-medium">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        Today's Survey
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Survey Content -->
                            <div class="p-6">
                                <!-- Description -->
                                <div class="mb-6">
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                        {{ Str::limit($survey->description, 120) }}
                                    </p>
                                </div>
                                
                                <!-- Action Button -->
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        @if($isCompleted)
                                            <div class="flex items-center space-x-1">
                                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="text-green-600 dark:text-green-400 font-medium">Survey completed</span>
                                            </div>
                                        @else
                                            <span>Click to participate</span>
                                        @endif
                                    </div>
                                    
                                    <div class="shimmer-button inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg text-sm">
                                        @if($isCompleted)
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Survey
                                        @else
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                            </svg>
                                            Take Survey
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                title: 'Surveys Help',
                html: `
                    <div class="text-left space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">📝 Share Your Feedback</h4>
                            <p class="text-sm text-blue-800 dark:text-blue-300">Participate in surveys to share your valuable feedback and insights. Your responses help improve our services and programs.</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-900 dark:text-green-200 mb-2">📊 Survey Statistics</h4>
                            <p class="text-sm text-green-800 dark:text-green-300">Track your survey participation with statistics showing total surveys, completed surveys, and pending surveys.</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-200 mb-2">✅ Completion Status</h4>
                            <p class="text-sm text-purple-800 dark:text-purple-300">Surveys show completion status: Available surveys have a "Take Survey" button, completed surveys are marked accordingly.</p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-amber-900 dark:text-amber-200 mb-2">🔒 Anonymous & Secure</h4>
                            <p class="text-sm text-amber-800 dark:text-amber-300">Your survey responses are kept confidential and may be anonymized for analysis. Help us improve by providing honest feedback.</p>
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