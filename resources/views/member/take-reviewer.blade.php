<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ $reviewer->title }}
            </h2>

            <a href="{{ route('member.reviewers') }}" class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center font-medium border border-white hover:border-white transition">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Reviewers
            </a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($reviewer->responses->where('member_id', auth()->user()->member->id)->count() > 0)
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-xl font-medium mb-2">You've already completed this reviewer</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">
                                Your score: {{ $reviewer->responses->where('member_id', auth()->user()->member->id)->first()->score }}/{{ $reviewer->responses->where('member_id', auth()->user()->member->id)->first()->total_points }}
                            </p>
                            <a href="{{ route('member.reviewer-result', $reviewer->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md">
                                View Results
                            </a>
                        </div>
                    @else
                        <form action="{{ route('member.submit-reviewer', $reviewer->id) }}" method="post" id="reviewer-form">
                            @csrf
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-medium">{{ $reviewer->title }}</h3>
                                @if($reviewer->description)
                                    <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $reviewer->description }}</p>
                                @endif
                                @if($reviewer->time_limit)
                                    <p class="text-sm text-gray-500 mt-2">
                                        Time limit: {{ $reviewer->time_limit }} minutes
                                    </p>
                                @endif
                                @if($reviewer->passing_score)
                                    <p class="text-sm text-gray-500">
                                        Passing score: {{ $reviewer->passing_score }} points
                                    </p>
                                @endif
                            </div>
                            
                            <div class="space-y-8">
                                @foreach($reviewer->questions as $index => $question)
                                    <div class="p-4 border rounded-lg">
                                        <div class="mb-4">
                                            <h4 class="font-medium">{{ $index + 1 }}. {{ $question->question }}</h4>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ ucfirst(str_replace('_', ' ', $question->type)) }} ({{ $question->points }} point(s))
                                            </p>
                                        </div>
                                        
                                        @if($question->type === 'identification')
                                            <input type="text" name="answers[{{ $question->id }}]" 
                                                   class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                        @elseif($question->type === 'true_false')
                                            <div class="space-y-2 mt-2">
                                                <div class="flex items-center">
                                                    <input type="radio" id="answer-{{ $question->id }}-true" 
                                                           name="answers[{{ $question->id }}]" value="true" 
                                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                                                    <label for="answer-{{ $question->id }}-true" class="ml-3 block text-sm">True</label>
                                                </div>
                                                <div class="flex items-center">
                                                    <input type="radio" id="answer-{{ $question->id }}-false" 
                                                           name="answers[{{ $question->id }}]" value="false" 
                                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                    <label for="answer-{{ $question->id }}-false" class="ml-3 block text-sm">False</label>
                                                </div>
                                            </div>
                                        @elseif($question->type === 'multiple_choice')
                                            <div class="space-y-2 mt-2">
                                                @foreach($question->options as $option)
                                                    <div class="flex items-center">
                                                        <input type="radio" id="answer-{{ $question->id }}-{{ $loop->index }}" 
                                                               name="answers[{{ $question->id }}]" value="{{ $option }}" 
                                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                                                        <label for="answer-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif($question->type === 'checkbox')
                                            <div class="space-y-2 mt-2">
                                                @foreach($question->options as $option)
                                                    <div class="flex items-center">
                                                        <input type="checkbox" id="answer-{{ $question->id }}-{{ $loop->index }}" 
                                                               name="answers[{{ $question->id }}][]" value="{{ $option }}" 
                                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                        <label for="answer-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-white bg-indigo-600 hover:bg-indigo-700 rounded-md font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Submit Reviewer
                                </button>
                            </div>
                        </form>
                        
                        @if($reviewer->time_limit)
                            <x-slot name="script">
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const timeLimit = {{ $reviewer->time_limit }};
                                        let timeLeft = timeLimit * 60; // Convert to seconds
                                        
                                        const timerDisplay = document.createElement('div');
                                        timerDisplay.className = 'fixed bottom-4 right-4 bg-indigo-600 text-white px-4 py-2 rounded-md shadow-lg';
                                        timerDisplay.id = 'timer';
                                        document.body.appendChild(timerDisplay);
                                        
                                        function updateTimer() {
                                            const minutes = Math.floor(timeLeft / 60);
                                            const seconds = timeLeft % 60;
                                            document.getElementById('timer').textContent = `Time left: ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                                            
                                            if (timeLeft <= 0) {
                                                document.getElementById('reviewer-form').submit();
                                            } else {
                                                timeLeft--;
                                                setTimeout(updateTimer, 1000);
                                            }
                                        }
                                        
                                        updateTimer();
                                    });
                                </script>
                            </x-slot>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>