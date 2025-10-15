@vite('resources/css/quizzes.css')

<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        Knowledge Hub
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Test your skills and expand your expertise</p>
                </div>
                <div class="flex items-center space-x-3 justify-center sm:justify-start">
                    <div class="px-4 py-2 bg-[#101966] dark:bg-white/20 backdrop-blur-sm rounded-lg">
                        <span class="text-white text-sm font-medium">{{ $quizzes->count() }} Quizzes</span>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Stats Section -->
            @if(!$quizzes->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="stats-card bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl border border-gray-100 dark:border-gray-400 animate-slide-in-up" 
                     style="animation-delay: 0.2s">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 gradient-bg-primary rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Quizzes</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $quizzes->count() }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Available for you</p>
                        </div>
                    </div>
                </div>
                
                <div class="stats-card bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl border border-gray-100 dark:border-gray-400 animate-slide-in-up" 
                     style="animation-delay: 0.4s">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 gradient-bg-success rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Completed</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $quizzes->filter(function($quiz) { return $quiz->responses->where('member_id', auth()->user()->member->id)->count() > 0; })->count() }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Successfully finished</p>
                        </div>
                    </div>
                </div>
                
                <div class="stats-card bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl border border-gray-100 dark:border-gray-400 animate-slide-in-up" 
                     style="animation-delay: 0.6s">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 gradient-bg-warning rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pending</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $quizzes->filter(function($quiz) { return $quiz->responses->where('member_id', auth()->user()->member->id)->count() == 0; })->count() }}
                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Waiting for you</p>
                        </div>
                    </div>
                </div>

                @php
                    $completedQuizzes = $quizzes->filter(function($quiz) { 
                        return $quiz->responses->where('member_id', auth()->user()->member->id)->count() > 0; 
                    });
                    $totalPossibleScore = $quizzes->sum(function($quiz) { 
                        return $quiz->questions->sum('points'); 
                    });
                    $totalUserScore = $completedQuizzes->sum(function($quiz) { 
                        $response = $quiz->responses->where('member_id', auth()->user()->member->id)->first();
                        return $response ? $response->total_score : 0;
                    });
                    $averageScore = $completedQuizzes->count() > 0 && $totalPossibleScore > 0 ? 
                        ($totalUserScore / ($completedQuizzes->count() * ($totalPossibleScore / $quizzes->count()))) * 100 : 0;
                @endphp
                
                <div class="stats-card bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-xl border border-gray-100 dark:border-gray-400 animate-slide-in-up performance-indicator" 
                     style="animation-delay: 0.8s">
                    <div class="flex items-center space-x-4">
                        <div class="p-4 gradient-bg-info rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Avg. Score</h3>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($averageScore, 1) }}%</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                @if($averageScore >= 90)
                                    Excellent performance!
                                @elseif($averageScore >= 80)
                                    Great work!
                                @elseif($averageScore >= 70)
                                    Good progress!
                                @elseif($averageScore >= 60)
                                    Keep improving!
                                @else
                                    Start your journey!
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($quizzes->isEmpty())
                <div class="col-span-full">
                    <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-3xl shadow-2xl p-16 text-center border border-gray-200 dark:border-gray-700 animate-scale-in empty-state">
                        <div class="mx-auto w-32 h-32 bg-gradient-to-br from-blue-100 via-purple-50 to-pink-100 dark:from-gray-600 dark:to-gray-700 rounded-full flex items-center justify-center mb-8 animate-bounce-gentle shadow-xl">
                            <div class="relative">
                                <svg class="w-16 h-16 text-blue-500 dark:text-blue-400 animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center animate-pulse">
                                    <span class="text-white text-xs font-bold">!</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-3 animate-fade-in">No Quizzes Available Yet</h3>
                                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-md mx-auto leading-relaxed animate-fade-in" style="animation-delay: 0.2s">
                                    Your learning journey is about to begin! Check back soon for exciting quizzes and assessments.
                                </p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6 animate-fade-in" style="animation-delay: 0.4s">
                                <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400">
                                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                    <span class="text-sm font-medium">New content coming soon</span>
                                </div>
                                <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400">
                                    <div class="w-3 h-3 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
                                    <span class="text-sm font-medium">Interactive learning experience</span>
                                </div>
                            </div>
                            
                            <div class="pt-6 animate-fade-in" style="animation-delay: 0.6s">
                                <button onclick="window.location.reload()" 
                                        class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white rounded-2xl hover:from-blue-700 hover:via-purple-700 hover:to-pink-700 transition-all duration-500 transform hover:scale-105 shadow-xl hover:shadow-2xl">
                                    <svg class="w-6 h-6 mr-3 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <span class="font-semibold">Refresh & Check Again</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Decorative elements -->
                        <div class="absolute top-8 left-8 w-4 h-4 bg-blue-400 rounded-full opacity-30 animate-bounce" style="animation-delay: 1s"></div>
                        <div class="absolute top-12 right-12 w-3 h-3 bg-purple-400 rounded-full opacity-40 animate-bounce" style="animation-delay: 1.5s"></div>
                        <div class="absolute bottom-16 left-16 w-5 h-5 bg-pink-400 rounded-full opacity-20 animate-bounce" style="animation-delay: 2s"></div>
                    </div>
                </div>
            @else
                <!-- Quizzes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($quizzes as $index => $quiz)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden cursor-pointer quiz-card border border-gray-100 dark:border-gray-700 group animate-slide-up"
                             style="animation-delay: {{ 1.0 + ($index * 0.2) }}s"
                             onclick="window.location.href='{{ route('member.take-quiz', $quiz->id) }}'">
                            
                            <!-- Header with gradient -->
                            <div class="h-2 gradient-bg-{{ ($index % 4) == 0 ? 'blue' : (($index % 4) == 1 ? 'green' : (($index % 4) == 2 ? 'purple' : 'orange')) }}"></div>
                            
                            <!-- Card Content -->
                            <div class="p-6">
                                <!-- Title and Badge Row -->
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 line-clamp-2">
                                            {{ $quiz->title }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $quiz->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    @if($quiz->responses->where('member_id', auth()->user()->member->id)->count() > 0)
                                        <span class="completed-badge text-white text-xs px-3 py-1 rounded-full font-semibold shadow-lg">
                                            Completed
                                        </span>
                                    @else
                                        <span class="new-badge text-white text-xs px-3 py-1 rounded-full font-semibold shadow-lg">
                                            New
                                        </span>
                                    @endif
                                </div>

                                <!-- Quiz Info -->
                                <div class="mb-4 p-4 bg-blue-100 border border-blue-700 dark:bg-gray-700 dark:border-gray-400 rounded-xl">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-blue-300 dark:bg-blue-900 rounded-lg">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $quiz->questions->count() }} Questions</span>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Total Points: {{ $quiz->questions->sum('points') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 dark:text-gray-300 line-clamp-3">
                                        {{ Str::limit($quiz->description, 120) }}
                                    </p>
                                </div>

                                <!-- Score Display (if completed) -->
                                @if($quiz->responses->where('member_id', auth()->user()->member->id)->count() > 0)
                                    @php
                                        $userResponse = $quiz->responses->where('member_id', auth()->user()->member->id)->first();
                                        $totalPossible = $quiz->questions->sum('points');
                                        $percentage = $totalPossible > 0 ? ($userResponse->total_score / $totalPossible) * 100 : 0;
                                    @endphp
                                    <div class="mb-4 p-4 score-display rounded-xl text-white">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium opacity-90">Your Score</p>
                                                <p class="text-lg font-bold">{{ $userResponse->total_score }} / {{ $totalPossible }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-2xl font-bold">{{ number_format($percentage, 1) }}%</p>
                                                <p class="text-xs opacity-90">
                                                    @if($percentage >= 90)
                                                        Excellent!
                                                    @elseif($percentage >= 80)
                                                        Great Job!
                                                    @elseif($percentage >= 70)
                                                        Good Work!
                                                    @elseif($percentage >= 60)
                                                        Well Done!
                                                    @else
                                                        Keep Learning!
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Button -->
                                <div class="flex items-center justify-between">
                                    @if($quiz->responses->where('member_id', auth()->user()->member->id)->count() > 0)
                                        <div class="flex items-center text-green-600 dark:text-green-400 group-hover:text-green-700 dark:group-hover:text-green-300 transition-colors duration-300">
                                            <span class="text-sm font-medium">View Results</span>
                                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex items-center text-green-600 dark:text-green-400">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-xs">Completed</span>
                                        </div>
                                    @else
                                        <div class="flex items-center text-blue-600 dark:text-blue-400 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors duration-300">
                                            <span class="text-sm font-medium">Take Quiz</span>
                                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                        <div class="flex items-center text-orange-600 dark:text-orange-400">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-xs">Pending</span>
                                        </div>
                                    @endif
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
                title: 'Knowledge Hub Help',
                html: `
                    <div class="text-left space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-900 dark:text-blue-200 mb-2">🧠 Test Your Knowledge</h4>
                            <p class="text-sm text-blue-800 dark:text-blue-300">Take quizzes to test your professional knowledge and skills. Each quiz is designed to enhance your expertise in your field.</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-900 dark:text-green-200 mb-2">📊 Performance Tracking</h4>
                            <p class="text-sm text-green-800 dark:text-green-300">Track your performance with detailed statistics including completion rates, scores, and progress over time.</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-900 dark:text-purple-200 mb-2">🎯 Quiz Status</h4>
                            <p class="text-sm text-purple-800 dark:text-purple-300">Quizzes show different statuses: Available (blue), In Progress (yellow), Completed (green). Click on any quiz to start or continue.</p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-4 rounded-lg">
                            <h4 class="font-semibold text-amber-900 dark:text-amber-200 mb-2">⏰ Time Management</h4>
                            <p class="text-sm text-amber-800 dark:text-amber-300">Some quizzes may have time limits. Plan accordingly and ensure you have enough time to complete the quiz before starting.</p>
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