<x-guest-layout>
    <div class="min-h-screen bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6 bg-indigo-700 text-white">
                    <h1 class="text-2xl font-bold">Quiz Results: {{ $attempt->quiz->title }}</h1>
                    <div class="mt-4 flex justify-between items-center">
                        <div>
                            <p class="text-sm">Participant: {{ $attempt->member->first_name }} {{ $attempt->member->last_name }}</p>
                            <p class="text-sm">
                            Completed: {{ \Carbon\Carbon::parse($attempt->completed_at)->format('F j, Y g:i a') }}
                            </p>
                        </div>
                        <div class="text-xl font-bold">
                            Score: {{ $attempt->score }} / {{ $attempt->quiz->questions->sum('points') }}
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="space-y-8">
                        @foreach($attempt->quiz->questions as $question)
                        @php
                            $attemptAnswer = $attempt->answers->where('question_id', $question->id)->first();
                            $userAnswer = $attemptAnswer ? (json_decode($attemptAnswer->answer, true) ?? $attemptAnswer->answer) : null;
                        @endphp
                        
                        <div class="question p-4 border rounded-lg {{ $attemptAnswer && $attemptAnswer->points_earned == $question->points ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                            <div class="flex justify-between">
                                <h3 class="text-lg font-medium text-gray-900">Question #{{ $loop->iteration }}</h3>
                                <span class="text-sm font-medium {{ $attemptAnswer && $attemptAnswer->points_earned == $question->points ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $attemptAnswer ? $attemptAnswer->points_earned : 0 }} / {{ $question->points }} points
                                </span>
                            </div>
                            <p class="mt-2 text-gray-700">{{ $question->question }}</p>
                            
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700">Your Answer:</h4>
                                @if(is_array($userAnswer))
                                    <ul class="list-disc pl-5 mt-1">
                                        @foreach($userAnswer as $item)
                                            <li class="text-sm text-gray-700">{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="mt-1 text-sm text-gray-700">{{ $userAnswer ?? 'No answer provided' }}</p>
                                @endif
                            </div>
                            
                            @if($question->type !== 'essay' && $attemptAnswer && $attemptAnswer->points_earned < $question->points)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700">Correct Answer:</h4>
                                @if($question->type === 'multiple_choice')
                                    <p class="mt-1 text-sm text-gray-700">{{ $question->correctAnswers->first()->answer }}</p>
                                @elseif($question->type === 'identification')
                                    <p class="mt-1 text-sm text-gray-700">{{ $question->answers->first()->answer }}</p>
                                @elseif($question->type === 'enumeration')
                                    <ul class="list-disc pl-5 mt-1">
                                        @foreach($question->answers as $answer)
                                            <li class="text-sm text-gray-700">{{ $answer->answer }}</li>
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
</x-guest-layout>
