<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Quiz Response Summary: {{ $quiz->title }}
            </h2>
            <a href="{{ route('quizzes.responses', $quiz->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
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
                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">Question Statistics</h3>
                        
                        @foreach($quiz->questions as $index => $question)
                            <div class="mb-6 p-4 border rounded-lg">
                                <h4 class="font-medium">Question #{{ $index + 1 }}: {{ $question->question }}</h4>
                                <p class="text-sm text-gray-500 mb-3">
                                    {{ ucfirst(str_replace('-', ' ', $question->type)) }} | 
                                    Points: {{ $question->points }}
                                </p>
                                
                                <div class="mt-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium">Correct Answers: {{ $questionStats[$index]['correct_answers'] }} / {{ $questionStats[$index]['total_answers'] }}</span>
                                        <span class="text-sm font-medium">{{ number_format($questionStats[$index]['accuracy'], 1) }}% Accuracy</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $questionStats[$index]['accuracy'] }}%"></div>
                                    </div>
                                </div>
                                
                                @if(in_array($question->type, ['checkbox', 'multiple-choice', 'true-false']))
                                    <div class="mt-4">
                                        <h5 class="text-sm font-medium mb-2">Answer Distribution:</h5>
                                        @php
                                            $answerCounts = [];
                                            foreach($question->answers as $answer) {
                                                if ($question->type === 'checkbox') {
                                                    $selectedOptions = json_decode($answer->answer, true) ?? [];
                                                    foreach($selectedOptions as $option) {
                                                        $answerCounts[$option] = ($answerCounts[$option] ?? 0) + 1;
                                                    }
                                                } else {
                                                    $answer = strtolower($answer->answer);
                                                    $answerCounts[$answer] = ($answerCounts[$answer] ?? 0) + 1;
                                                }
                                            }
                                        @endphp
                                        
                                        <ul class="space-y-2">
                                            @if($question->type === 'true-false')
                                                <li>
                                                    <div class="flex justify-between text-sm mb-1">
                                                        <span>True</span>
                                                        <span>{{ $answerCounts['true'] ?? 0 }} ({{ $quiz->responses->count() > 0 ? round(($answerCounts['true'] ?? 0) / $quiz->responses->count() * 100, 1) : 0 }}%)</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $quiz->responses->count() > 0 ? ($answerCounts['true'] ?? 0) / $quiz->responses->count() * 100 : 0 }}%"></div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="flex justify-between text-sm mb-1">
                                                        <span>False</span>
                                                        <span>{{ $answerCounts['false'] ?? 0 }} ({{ $quiz->responses->count() > 0 ? round(($answerCounts['false'] ?? 0) / $quiz->responses->count() * 100, 1) : 0 }}%)</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $quiz->responses->count() > 0 ? ($answerCounts['false'] ?? 0) / $quiz->responses->count() * 100 : 0 }}%"></div>
                                                    </div>
                                                </li>
                                            @else
                                                @foreach($question->options as $option)
                                                    @php
                                                        $count = $answerCounts[$option] ?? 0;
                                                        $percentage = $quiz->responses->count() > 0 ? ($count / $quiz->responses->count()) * 100 : 0;
                                                        $isCorrect = in_array($option, $question->correct_answers ?? []);
                                                    @endphp
                                                    <li>
                                                        <div class="flex justify-between text-sm mb-1">
                                                            <span class="{{ $isCorrect ? 'font-bold text-green-600' : '' }}">{{ $option }}</span>
                                                            <span>{{ $count }} ({{ round($percentage, 1) }}%)</span>
                                                        </div>
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                            <div class="{{ $isCorrect ? 'bg-green-600' : 'bg-blue-600' }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <h5 class="text-sm font-medium mb-2">Sample Answers:</h5>
                                        <ul class="space-y-1">
                                            @foreach($question->answers->take(5) as $answer)
                                                <li class="text-sm">
                                                    "{{ Str::limit($answer->answer, 100) }}"
                                                    @if($answer->is_correct)
                                                        <span class="text-green-600 ml-2">✓ Correct</span>
                                                    @else
                                                        <span class="text-red-600 ml-2">✗ Incorrect</span>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if($question->answers->count() > 5)
                                            <p class="text-sm text-gray-500 mt-1">+ {{ $question->answers->count() - 5 }} more answers</p>
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