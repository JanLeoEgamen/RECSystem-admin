<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4
                    p-4 sm:p-6 rounded-lg shadow-lg
                    bg-gradient-to-r from-[#101966] via-[#3F53E8] via-[#5E6FFB] to-[#8AA9FF]
                    dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Quiz Results: {{ $response->quiz->title }}
            </h2>

            <a href="{{ route('member.quizzes') }}" class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center font-medium border border-white hover:border-white transition">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Quizzes
            </a>
        </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Summary</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Quiz</p>
                                <p class="font-medium">{{ $response->quiz->title }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Completed On</p>
                                <p class="font-medium">{{ $response->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Score</p>
                                <p class="font-bold">{{ $response->total_score }} / {{ $response->quiz->questions->sum('points') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Percentage</p>
                                <p class="font-bold">
                                    @php
                                        $totalPossible = $response->quiz->questions->sum('points');
                                        $percentage = $totalPossible > 0 ? ($response->total_score / $totalPossible) * 100 : 0;
                                    @endphp
                                    {{ number_format($percentage, 1) }}%
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-lg font-medium">Question Results</h3>
                        
                        @foreach($response->quiz->questions as $question)
                            @php
                                $answer = $response->answers->where('question_id', $question->id)->first();
                            @endphp
                            
                            <div class="p-4 border rounded-lg {{ $answer && $answer->is_correct ? 'bg-green-50 dark:bg-green-900' : 'bg-red-50 dark:bg-red-900' }}">
                                <h4 class="font-medium">{{ $question->question }}</h4>
                                <p class="text-sm text-gray-500 mb-3">
                                    {{ ucfirst(str_replace('-', ' ', $question->type)) }} | 
                                    Points: {{ $question->points }}
                                </p>
                                
                                @if($answer)
                                    <div class="mt-2">
                                        <p class="font-medium">Your Answer:</p>
                                        @if($question->type === 'checkbox')
                                            <ul class="list-disc list-inside mt-1">
                                                @foreach(json_decode($answer->answer, true) ?? [] as $selectedOption)
                                                    <li>{{ $selectedOption }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="mt-1">{{ $answer->answer }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-2">
                                        <p class="font-medium">Correct Answer(s):</p>
                                        @if($question->type === 'checkbox')
                                            <ul class="list-disc list-inside mt-1">
                                                @foreach($question->correct_answers ?? [] as $correctAnswer)
                                                    <li>{{ $correctAnswer }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="mt-1">{{ $question->correct_answers[0] ?? '' }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="mt-2">
                                        <p class="font-medium">Score: 
                                            <span class="{{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $answer->score }} / {{ $question->points }}
                                            </span>
                                        </p>
                                    </div>
                                @else
                                    <p class="text-gray-400 italic mt-2">No response provided</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>