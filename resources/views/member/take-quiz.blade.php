<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        {{ $quiz->title }}
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Complete the quiz to test your knowledge</p>
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
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        
        @keyframes checkmark {
            0% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: 0; }
        }
        
        .animate-slide-in-up {
            animation: slideInUp 0.6s ease-out forwards;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.5s ease-out forwards;
        }
        
        .quiz-form-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .dark .quiz-form-card {
            background: rgba(31, 41, 55, 0.95);
        }
        
        .gradient-bg-blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .gradient-bg-purple {
            background: linear-gradient(135deg, #a855f7 0%, #e879f9 100%);
        }
        
        .question-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .question-card:hover {
            border-left-color: #667eea;
            transform: translateX(4px);
        }
        
        .form-radio:checked + label,
        .form-checkbox:checked + label {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: scale(1.02);
        }
        
        .form-input {
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.3);
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(102, 126, 234, 0.4);
        }
        
        .completed-checkmark {
            stroke-dasharray: 100;
            stroke-dashoffset: 100;
            animation: checkmark 1s ease-in-out forwards;
        }
    </style>

    <div class="py-8 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($quiz->responses->where('member_id', auth()->user()->member->id)->count() > 0)
                <!-- Already Completed Section -->
                <div class="bg-gradient-to-br from-green-200 to-green-50 dark:from-gray-800 dark:via-gray-900 dark:to-black rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-scale-in">
                    <div class="p-8 sm:p-12 text-center">
                        <div class="mx-auto w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mb-6 shadow-lg">
                            <svg class="w-12 h-12 text-white completed-checkmark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-4">Quiz Completed Successfully!</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-6">You have already completed this quiz. View your results below.</p>
                        
                        @php
                            $response = $quiz->responses->where('member_id', auth()->user()->member->id)->first();
                            $totalPossible = $quiz->questions->sum('points');
                            $percentage = $totalPossible > 0 ? ($response->total_score / $totalPossible) * 100 : 0;
                        @endphp
                        
                        <!-- Score Display -->
                        <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-green-900/20 dark:to-blue-900/20 border border-green-600 rounded-2xl p-6 mb-8">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Your Score</p>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $response->total_score }} / {{ $totalPossible }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Percentage</p>
                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ number_format($percentage, 1) }}%</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Performance</p>
                                    <p class="text-lg font-bold text-blue-600 dark:text-blue-400">
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
                        
                        <a href="{{ route('member.quiz-result', $response->id) }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            View Detailed Results
                        </a>
                    </div>
                </div>
            @else
                <!-- Quiz Form Section -->
                <div class="quiz-form-card rounded-3xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700 animate-slide-in-up">
                    
                    <!-- Quiz Header -->
                    <div class="p-6 sm:p-8 gradient-bg-blue text-white">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{ $quiz->title }}</h3>
                                @if($quiz->description)
                                    <p class="text-blue-100 mt-2">{{ $quiz->description }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Quiz Stats -->
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="bg-white/10 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold">{{ $quiz->questions->count() }}</p>
                                <p class="text-sm text-blue-100">Questions</p>
                            </div>
                            <div class="bg-white/10 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold">{{ $quiz->questions->sum('points') }}</p>
                                <p class="text-sm text-blue-100">Total Points</p>
                            </div>
                            <div class="bg-white/10 rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold">~{{ $quiz->questions->count() * 2 }}</p>
                                <p class="text-sm text-blue-100">Est. Minutes</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Form -->
                    <div class="p-6 sm:p-8">
                        <form action="{{ route('member.submit-quiz', $quiz->id) }}" method="post" class="space-y-8">
                            @csrf
                            
                            @foreach($quiz->questions as $index => $question)
                                <div class="question-card p-6 bg-gray-50 dark:bg-gray-700 rounded-2xl animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                                    <div class="flex items-start space-x-4 mb-4">
                                        <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                                {{ $question->question }}
                                            </h4>
                                            <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full">
                                                    {{ ucfirst(str_replace('-', ' ', $question->type)) }}
                                                </span>
                                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full">
                                                    {{ $question->points }} {{ $question->points == 1 ? 'Point' : 'Points' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="ml-12">
                                        @if($question->type === 'identification')
                                            <input type="text" 
                                                   name="answers[{{ $question->id }}]" 
                                                   class="form-input w-full rounded-xl border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 p-4" 
                                                   placeholder="Enter your answer here..." 
                                                   required>
                                        
                                        @elseif($question->type === 'true-false')
                                            <div class="space-y-3">
                                                @foreach(['true' => 'True', 'false' => 'False'] as $value => $label)
                                                    <label class="flex items-center p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-200">
                                                        <input type="radio" 
                                                               name="answers[{{ $question->id }}]" 
                                                               value="{{ $value }}" 
                                                               class="form-radio h-5 w-5 text-blue-600 sr-only" 
                                                               required>
                                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 mr-4 flex items-center justify-center">
                                                            <div class="w-2 h-2 rounded-full bg-blue-600 hidden"></div>
                                                        </div>
                                                        <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $label }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        
                                        @elseif($question->type === 'multiple-choice')
                                            <div class="space-y-3">
                                                @foreach($question->options as $option)
                                                    <label class="flex items-center p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-200">
                                                        <input type="radio" 
                                                               name="answers[{{ $question->id }}]" 
                                                               value="{{ $option }}" 
                                                               class="form-radio h-5 w-5 text-blue-600 sr-only" 
                                                               required>
                                                        <div class="w-5 h-5 rounded-full border-2 border-gray-300 dark:border-gray-600 mr-4 flex items-center justify-center">
                                                            <div class="w-2 h-2 rounded-full bg-blue-600 hidden"></div>
                                                        </div>
                                                        <span class="text-gray-900 dark:text-gray-100">{{ $option }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        
                                        @elseif($question->type === 'checkbox')
                                            <div class="space-y-3">
                                                @foreach($question->options as $option)
                                                    <label class="flex items-center p-4 rounded-xl border-2 border-gray-200 dark:border-gray-600 cursor-pointer hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-200">
                                                        <input type="checkbox" 
                                                               name="answers[{{ $question->id }}][]" 
                                                               value="{{ $option }}" 
                                                               class="form-checkbox h-5 w-5 text-blue-600 sr-only">
                                                        <div class="w-5 h-5 rounded border-2 border-gray-300 dark:border-gray-600 mr-4 flex items-center justify-center">
                                                            <svg class="w-3 h-3 text-blue-600 hidden" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="text-gray-900 dark:text-gray-100">{{ $option }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Submit Button -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-600">
                                <button type="submit" class="submit-btn w-full sm:w-auto px-8 py-4 text-white rounded-xl font-semibold shadow-lg flex items-center justify-center space-x-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Submit Quiz</span>
                                </button>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">
                                    Make sure to review your answers before submitting. You can only take this quiz once.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Enhanced radio button interactions
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove checked state from siblings
                const name = this.name;
                document.querySelectorAll(`input[name="${name}"]`).forEach(sibling => {
                    const dot = sibling.parentElement.querySelector('.w-2');
                    if (dot) dot.classList.add('hidden');
                    sibling.parentElement.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30');
                });
                
                // Add checked state to current
                const dot = this.parentElement.querySelector('.w-2');
                if (dot) dot.classList.remove('hidden');
                this.parentElement.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30');
            });
        });

        // Enhanced checkbox interactions
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkmark = this.parentElement.querySelector('svg');
                if (this.checked) {
                    checkmark.classList.remove('hidden');
                    this.parentElement.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30');
                } else {
                    checkmark.classList.add('hidden');
                    this.parentElement.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/30');
                }
            });
        });

        // Form submission with loading state
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Submitting...</span>
            `;
            submitBtn.disabled = true;
        });
    </script>
</x-app-layout>