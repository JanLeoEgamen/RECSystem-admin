<x-app-layout>
    <x-slot name="header">
        <div class="relative"> 
            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:items-center sm:space-y-0 text-center sm:text-left">
                <div>
                    <h2 class="font-semibold text-2xl sm:text-3xl lg:text-4xl text-white dark:text-gray-200 leading-tight">
                        {{ $survey->title }}
                    </h2>
                    <p class="text-blue-100 dark:text-gray-300 mt-2 text-sm sm:text-base">Share your valuable feedback</p>
                </div>

                <div class="flex justify-center sm:justify-end">
                    <a href="{{ route('member.surveys') }}" class="group inline-flex items-center px-6 py-3 bg-white/20 backdrop-blur-sm text-white font-medium rounded-xl border border-white/30 hover:bg-white hover:text-[#101966] transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Surveys
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
        
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% { transform: translate3d(0,0,0); }
            40%, 43% { transform: translate3d(0, -15px, 0); }
            70% { transform: translate3d(0, -7px, 0); }
            90% { transform: translate3d(0, -2px, 0); }
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
        
        .animate-bounce-custom {
            animation: bounce 1s ease-in-out infinite;
        }
        
        .survey-card {
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .dark .survey-card {
            background: rgba(31, 41, 55, 0.95);
        }
        
        .gradient-bg-blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-green {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .question-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.95) 100%);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .question-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.9) 0%, rgba(31, 41, 55, 0.95) 100%);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }
        
        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .form-input {
            transition: all 0.3s ease;
            border: 2px solid rgba(59, 130, 246, 0.2);
            background: rgba(255, 255, 255, 0.9);
        }
        
        .dark .form-input {
            background: rgba(31, 41, 55, 0.9);
            border-color: rgba(59, 130, 246, 0.3);
        }
        
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }
        
        .radio-option, .checkbox-option {
            transition: all 0.3s ease;
            padding: 1rem;
            border-radius: 0.75rem;
            border: 2px solid rgba(59, 130, 246, 0.1);
            background: rgba(59, 130, 246, 0.05);
            cursor: pointer;
        }
        
        .dark .radio-option, .dark .checkbox-option {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.2);
        }
        
        .radio-option:hover, .checkbox-option:hover {
            border-color: rgba(59, 130, 246, 0.3);
            background: rgba(59, 130, 246, 0.1);
            transform: translateY(-1px);
        }
        
        .radio-option.selected, .checkbox-option.selected {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.15);
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
        }
    </style>

    <div class="py-8 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if($survey->responses->where('member_id', auth()->user()->member->id)->count() > 0)
                <!-- Completed State -->
                <div class="survey-card bg-green-100 dark:bg-green-100 rounded-3xl shadow-2xl overflow-hidden animate-slide-in-up border border-green-600 dark:border-green-600">
                    <div class="p-12 text-center">
                        <div class="w-24 h-24 mx-auto mb-6 animate-bounce-custom">
                            <svg class="w-full h-full text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-900 mb-4">Survey Completed!</h3>
                        <p class="text-xl text-gray-600 dark:text-gray-500 mb-8">
                            Thank you for your valuable participation and feedback!
                        </p>
                        <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-semibold rounded-xl hover:from-green-600 hover:to-emerald-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Survey Completed
                        </div>
                    </div>
                </div>
            @else
                <!-- Survey Form -->
                <div class="bg-blue-100 dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden animate-slide-in-up border border-gray-200 dark:border-gray-700">
                    
                    <!-- Survey Header -->
                    <div class="bg-gradient-to-br from-[#101966] via-blue-600 to-[#101966] dark:from-gray-800 dark:via-gray-900 dark:to-black p-6 sm:p-8 text-white">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="p-3 bg-white/20 rounded-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{ $survey->title }}</h3>
                                <p class="text-blue-100">Please complete all questions to submit your response</p>
                            </div>
                        </div>
                        
                        @if($survey->description)
                            <div class="bg-white/10 rounded-xl p-4">
                                <p class="text-blue-100">{{ $survey->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Survey Form -->
                    <div class="p-6 sm:p-8">
                        <form action="{{ route('member.submit-survey', $survey->id) }}" method="post" id="surveyForm">
                            @csrf
                            
                            <div class="space-y-8">
                                @foreach($survey->questions as $index => $question)
                                    <div class="bg-white dark:bg-gray-700 rounded-2xl p-6 border-2 border-gray-200 dark:border-gray-700 animate-fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                                        
                                        <!-- Question Header -->
                                        <div class="flex items-start space-x-4 mb-6">
                                            <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                                    {{ $question->question }}
                                                </h4>
                                                @if(in_array($question->type, ['short-answer', 'long-answer']))
                                                    <span class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium">
                                                        {{ ucfirst(str_replace('-', ' ', $question->type)) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Question Input -->
                                        @if($question->type === 'short-answer')
                                            <input type="text" 
                                                   name="answers[{{ $question->id }}]" 
                                                   class="form-input w-full rounded-xl px-4 py-3 text-gray-900 dark:text-gray-100 focus:outline-none" 
                                                   placeholder="Enter your answer here..."
                                                   required>
                                        @elseif($question->type === 'long-answer')
                                            <textarea name="answers[{{ $question->id }}]" 
                                                      class="form-input w-full rounded-xl px-4 py-3 text-gray-900 dark:text-gray-100 focus:outline-none" 
                                                      rows="4" 
                                                      placeholder="Enter your detailed response here..."
                                                      required></textarea>
                                        @elseif($question->type === 'multiple-choice')
                                            <div class="space-y-3">
                                                @foreach($question->options as $optionIndex => $option)
                                                    <label class="radio-option block cursor-pointer">
                                                        <div class="flex items-center space-x-3">
                                                            <input type="radio" 
                                                                   id="option-{{ $question->id }}-{{ $optionIndex }}" 
                                                                   name="answers[{{ $question->id }}]" 
                                                                   value="{{ $option }}" 
                                                                   class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                                                   onchange="updateSelection(this)"
                                                                   required>
                                                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $option }}</span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif($question->type === 'checkbox')
                                            <div class="space-y-3">
                                                @foreach($question->options as $optionIndex => $option)
                                                    <label class="checkbox-option block cursor-pointer">
                                                        <div class="flex items-center space-x-3">
                                                            <input type="checkbox" 
                                                                   id="option-{{ $question->id }}-{{ $optionIndex }}" 
                                                                   name="answers[{{ $question->id }}][]" 
                                                                   value="{{ $option }}" 
                                                                   class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                                   onchange="updateSelection(this)">
                                                            <span class="text-gray-900 dark:text-gray-100 font-medium">{{ $option }}</span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="mt-8 text-center animate-fade-in" style="animation-delay: {{ count($survey->questions) * 0.1 }}s">
                                <button type="submit" class="submit-btn inline-flex items-center px-8 py-4 text-white font-bold rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105">
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Submit Survey
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function updateSelection(element) {
            // Update visual state for radio/checkbox options
            const container = element.closest('.radio-option, .checkbox-option');
            const allContainers = container.parentElement.querySelectorAll('.radio-option, .checkbox-option');
            
            if (element.type === 'radio') {
                // Remove selected class from all radio options in this group
                allContainers.forEach(cont => cont.classList.remove('selected'));
                // Add selected class to current option
                if (element.checked) {
                    container.classList.add('selected');
                }
            } else if (element.type === 'checkbox') {
                // Toggle selected class for checkbox
                if (element.checked) {
                    container.classList.add('selected');
                } else {
                    container.classList.remove('selected');
                }
            }
        }

        // Form validation feedback
        document.getElementById('surveyForm').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = `
                <svg class="w-6 h-6 mr-3 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Submitting...
            `;
            submitBtn.disabled = true;
        });
    </script>
</x-app-layout>