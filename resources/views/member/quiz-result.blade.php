<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        Quiz Results: {{ $response->quiz->title }}
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Review your performance and answers</p>
                </div>

                <div class="flex justify-center sm:justify-end">
                    <a href="{{ route('member.quizzes') }}" class="group inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border border-white/30 hover:bg-white hover:text-[#101966] transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Quizzes
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <style>
        @keyframes slideInUp {
            from { 
                opacity: 0; 
                transform: translateY(60px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }
        
        @keyframes fadeIn {
            from { 
                opacity: 0; 
                transform: translateY(30px);
            }
            to { 
                opacity: 1; 
                transform: translateY(0);
            }
        }
        
        @keyframes scaleIn {
            from { 
                opacity: 0; 
                transform: scale(0.9) translateY(20px); 
            }
            to { 
                opacity: 1; 
                transform: scale(1) translateY(0); 
            }
        }
        
        @keyframes countUp {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .animate-slide-in-up {
            opacity: 0;
            animation: slideInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
        
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
        
        .animate-scale-in {
            opacity: 0;
            animation: scaleIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
        
        .animate-count-up {
            opacity: 0;
            animation: countUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }
        
        .results-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .dark .results-card {
            background: rgba(31, 41, 55, 0.95);
        }
        
        .gradient-bg-blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .gradient-bg-red {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        }
        
        .gradient-bg-orange {
            background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
        }
        
        .correct-answer {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border-left: 4px solid #22c55e;
        }
        
        .dark .correct-answer {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.2) 100%);
        }
        
        .incorrect-answer {
            background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
            border-left: 4px solid #ef4444;
        }
        
        .dark .incorrect-answer {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.2) 100%);
        }
        
        .question-card {
            transition: all 0.3s ease;
        }
        
        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .score-circle {
            background: conic-gradient(
                from 0deg,
                #22c55e 0deg,
                #22c55e calc(var(--percentage) * 3.6deg),
                #e5e7eb calc(var(--percentage) * 3.6deg),
                #e5e7eb 360deg
            );
        }
    </style>

    <div class="py-8 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Results Summary -->
            <div class="bg-gradient-to-br from-green-600 to-green-200 dark:from-gray-800 dark:via-gray-900 dark:to-black rounded-3xl shadow-2xl overflow-hidden mb-8 animate-slide-in-up border border-gray-200 dark:border-gray-700">
                <div class=" p-6 sm:p-8 text-white">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl text-gray-200 dark:text-gray-100 font-bold">Quiz Results Summary</h3>
                            <p class="text-gray-200 dark:text-gray-400">{{ $response->quiz->title }}</p>
                        </div>
                    </div>
                    
                    @php
                        $totalPossible = $response->quiz->questions->sum('points');
                        $percentage = $totalPossible > 0 ? ($response->total_score / $totalPossible) * 100 : 0;
                        $correctAnswers = $response->answers->where('is_correct', true)->count();
                        $totalQuestions = $response->quiz->questions->count();
                    @endphp
                    
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white/10 rounded-xl p-4 text-center animate-count-up border border-green-200" style="animation-delay: 0.1s">
                            <p class="text-3xl text-gray-700 dark:text-gray-100 font-bold">{{ $response->total_score }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Score</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 text-center animate-count-up border border-green-200" style="animation-delay: 0.2s">
                            <p class="text-3xl text-gray-700 dark:text-gray-100 font-bold">{{ number_format($percentage, 1) }}%</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Percentage</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 text-center animate-count-up border border-green-200" style="animation-delay: 0.3s">
                            <p class="text-3xl text-gray-700 dark:text-gray-100 font-bold">{{ $correctAnswers }}/{{ $totalQuestions }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Correct Answers</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 text-center animate-count-up border border-green-200" style="animation-delay: 0.4s">
                            <p class="text-3xl text-gray-700 dark:text-gray-100 font-bold">{{ $response->created_at->format('M d') }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Completed Date</p>
                        </div>
                    </div>
                </div>

                <!-- Performance Badge -->
                <div class="p-6 bg-gray-50 dark:bg-gray-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Performance Rating</h4>
                            <p class="text-gray-600 dark:text-gray-400">Based on your quiz results</p>
                        </div>
                        <div class="text-right">
                            <div class="inline-flex items-center px-6 py-3 rounded-xl font-bold text-lg shadow-lg
                                @if($percentage >= 90) bg-gradient-to-r from-green-500 to-emerald-500 text-white
                                @elseif($percentage >= 80) bg-gradient-to-r from-blue-500 to-cyan-500 text-white
                                @elseif($percentage >= 70) bg-gradient-to-r from-orange-500 to-amber-500 text-white
                                @elseif($percentage >= 60) bg-gradient-to-r from-yellow-500 to-orange-500 text-white
                                @else bg-gradient-to-r from-red-500 to-pink-500 text-white
                                @endif">
                                @if($percentage >= 90)
                                    🏆 Excellent!
                                @elseif($percentage >= 80)
                                    🎉 Great Job!
                                @elseif($percentage >= 70)
                                    👍 Good Work!
                                @elseif($percentage >= 60)
                                    ✅ Well Done!
                                @else
                                    📚 Keep Learning!
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Results -->
            <div class="bg-gradient-to-br from-blue-200 to-purple-300 dark:from-gray-800 dark:via-gray-900 dark:to-black rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-fade-in" style="animation-delay: 0.2s">
                <div class="p-6 sm:p-8">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="p-3 gradient-bg-blue rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Question by Question Review</h3>
                            <p class="text-gray-600 dark:text-gray-400">Detailed breakdown of your answers</p>
                        </div>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($response->quiz->questions as $index => $question)
                            @php
                                $answer = $response->answers->where('question_id', $question->id)->first();
                                $isCorrect = $answer && $answer->is_correct;
                            @endphp
                            
                            <div class="question-card p-6 rounded-2xl border-2 {{ $isCorrect ? 'correct-answer border-green-200 dark:border-green-800' : 'incorrect-answer border-red-200 dark:border-red-800' }} animate-scale-in" style="animation-delay: {{ $index * 0.1 }}s">
                                
                                <!-- Question Header -->
                                <div class="flex items-start space-x-4 mb-6">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-white font-bold {{ $isCorrect ? 'bg-green-500' : 'bg-red-500' }}">
                                        @if($isCorrect)
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Question {{ $index + 1 }}</span>
                                            <div class="flex items-center space-x-2">
                                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                                                    {{ ucfirst(str_replace('-', ' ', $question->type)) }}
                                                </span>
                                                <span class="px-3 py-1 {{ $isCorrect ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' }} rounded-full text-sm font-semibold">
                                                    {{ $answer ? $answer->score : 0 }} / {{ $question->points }} pts
                                                </span>
                                            </div>
                                        </div>
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $question->question }}
                                        </h4>
                                    </div>
                                </div>
                                
                                @if($answer)
                                    <!-- Your Answer Section -->
                                    <div class="mb-6">
                                        <div class="flex items-center space-x-2 mb-3">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                            <h5 class="font-semibold text-gray-900 dark:text-gray-100">Your Answer:</h5>
                                        </div>
                                        <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 ml-4">
                                            @if($question->type === 'checkbox')
                                                <div class="space-y-2">
                                                    @foreach(json_decode($answer->answer, true) ?? [] as $selectedOption)
                                                        <div class="flex items-center space-x-2">
                                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                                            <span class="text-gray-900 dark:text-gray-100">{{ $selectedOption }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $answer->answer }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Correct Answer Section -->
                                    <div class="mb-4">
                                        <div class="flex items-center space-x-2 mb-3">
                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                            <h5 class="font-semibold text-gray-900 dark:text-gray-100">Correct Answer(s):</h5>
                                        </div>
                                        <div class="bg-green-50 dark:bg-green-900/30 rounded-xl p-4 ml-4">
                                            @if($question->type === 'checkbox')
                                                <div class="space-y-2">
                                                    @foreach($question->correct_answers ?? [] as $correctAnswer)
                                                        <div class="flex items-center space-x-2">
                                                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                            <span class="text-gray-900 dark:text-gray-100">{{ $correctAnswer }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $question->correct_answers[0] ?? '' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <!-- No Response -->
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 text-center">
                                        <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400 font-medium">No response provided</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>