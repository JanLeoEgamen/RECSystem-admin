<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Reviewer Response: {{ $response->reviewer->title }}
            </h2>
            <a href="{{ route('reviewers.responses', $response->reviewer_id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Responses
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white p-4 rounded-lg border">
                                <p class="text-sm text-gray-500">Member</p>
                                <p class="font-medium">{{ $response->member->first_name }} {{ $response->member->last_name }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border">
                                <p class="text-sm text-gray-500">Submitted On</p>
                                <p class="font-medium">{{ $response->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                            <div class="bg-white p-4 rounded-lg border">
                                <p class="text-sm text-gray-500">Score</p>
                                <p class="font-medium">
                                    {{ $response->score }} / {{ $response->total_points }}
                                    @if($response->reviewer->passing_score)
                                        @if($response->score >= $response->reviewer->passing_score)
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Passed
                                            </span>
                                        @else
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Failed
                                            </span>
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($response->reviewer->questions as $question)
                            @php
                                $answer = $response->answers->where('question_id', $question->id)->first();
                                $isCorrect = $answer ? $answer->is_correct : false;
                            @endphp
                            
                            <div class="p-4 border rounded-lg {{ $isCorrect ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium">{{ $question->question }}</h4>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ ucfirst(str_replace('_', ' ', $question->type)) }} ({{ $question->points }} point(s))
                                        </p>
                                    </div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                              {{ $isCorrect ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                                    </span>
                                </div>
                                
                                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Your Answer:</p>
                                        @if($question->type === 'checkbox' && is_array(json_decode($answer->answer, true)))
                                            <ul class="list-disc list-inside mt-1">
                                                @foreach(json_decode($answer->answer, true) as $selectedOption)
                                                    <li>{{ $selectedOption }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="mt-1">{{ $answer->answer }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Correct Answer:</p>
                                        @if($question->type === 'checkbox')
                                            <ul class="list-disc list-inside mt-1">
                                                @foreach($question->correct_answers as $correctAnswer)
                                                    <li>{{ $correctAnswer }}</li>
                                                @endforeach
                                            </ul>
                                        @elseif($question->type === 'multiple_choice' || $question->type === 'true_false')
                                            <p class="mt-1">{{ $question->correct_answers[0] }}</p>
                                        @else
                                            <p class="mt-1">{{ $question->correct_answers[0] }}</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <p class="text-sm font-medium">
                                        Points Earned: {{ $answer->points_earned }} / {{ $question->points }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>