<pre>{{ print_r($attempt->toArray(), true) }}</pre>


<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white dark:text-gray-200 leading-tight">
                Quiz Attempt Review: {{ $quiz->title }}
            </h2>
            <a href="{{ route('quizzes.send', $quiz->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Quiz
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8 border-b pb-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium">Participant: {{ $member->first_name }} {{ $member->last_name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $member->email_address }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm">Started: {{ $attempt->created_at->format('M j, Y g:i A') }}</p>
<p class="text-sm">
    Completed: 
    {{ $attempt->completed_at 
        ? \Carbon\Carbon::parse($attempt->completed_at)->format('M j, Y g:i A') 
        : 'Not completed' 
    }}
</p>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-between items-center">
                            <div>
                                <span class="text-lg font-bold">
                                    Score: {{ $attempt->score ?? 'Pending' }} / {{ $quiz->questions->sum('points') }}
                                </span>
                            </div>
                            <div>
                                @if($attempt->completed_at)
                                <a href="{{ route('quizzes.resend-results', ['quiz' => $quiz->id, 'member' => $member->id]) }}" 
                                   class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green active:bg-green-700 transition duration-150 ease-in-out">
                                    Resend Results
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($quiz->questions as $question)
                        @php
                            $attemptAnswer = $attempt->answers->where('question_id', $question->id)->first();
                            $userAnswer = $attemptAnswer ? (json_decode($attemptAnswer->answer, true) ?? $attemptAnswer->answer) : null;
                        @endphp
                        
                        <div class="p-4 border rounded-lg @if($attemptAnswer && $attemptAnswer->points_earned == $question->points) border-green-200 bg-green-50 @else border-red-200 bg-red-50 @endif">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-200">Question #{{ $loop->iteration }}</h3>
                                    <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $question->question }}</p>
                                </div>
                                <span class="text-sm font-medium @if($attemptAnswer && $attemptAnswer->points_earned == $question->points) text-green-600 @else text-red-600 @endif">
                                    @if($attemptAnswer)
                                        {{ $attemptAnswer->points_earned }} / {{ $question->points }} points
                                    @else
                                        0 / {{ $question->points }} points
                                    @endif
                                </span>
                            </div>
                            
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Participant's Answer:</h4>
                                @if(is_array($userAnswer))
                                    <ul class="list-disc pl-5 mt-1 space-y-1">
                                        @foreach($userAnswer as $item)
                                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ $userAnswer ?? 'No answer provided' }}</p>
                                @endif
                            </div>
                            
                            @if($question->type !== 'essay' && $attemptAnswer && $attemptAnswer->points_earned < $question->points)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Correct Answer:</h4>
                                @if($question->type === 'multiple_choice')
                                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ $question->correctAnswers->first()->answer }}</p>
                                @elseif($question->type === 'identification')
                                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">{{ $question->answers->first()->answer }}</p>
                                @elseif($question->type === 'enumeration')
                                    <ul class="list-disc pl-5 mt-1 space-y-1">
                                        @foreach($question->answers as $answer)
                                            <li class="text-sm text-gray-700 dark:text-gray-300">{{ $answer->answer }}</li>
                                        @endforeach
                                    </ul>
                                @endif
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