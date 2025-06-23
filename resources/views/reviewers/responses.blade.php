<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Reviewer Responses: {{ $reviewer->title }}
            </h2>
            <a href="{{ route('reviewers.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
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
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-800">Total Attempts</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $reviewer->responses->count() }}</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-800">Average Score</p>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ $reviewer->responses->avg('score') ? round($reviewer->responses->avg('score'), 1) : 0 }} / {{ $reviewer->questions->sum('points') }}
                                </p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-purple-800">Passing Rate</p>
                                <p class="text-2xl font-bold text-purple-600">
                                    @if($reviewer->passing_score)
                                        {{ round($reviewer->responses->where('score', '>=', $reviewer->passing_score)->count() / max($reviewer->responses->count(), 1) * 100) }}%
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">By Question</h3>
                        
                        @foreach($reviewer->questions as $question)
                            <div class="mb-6 p-4 border rounded-lg">
                                <h4 class="font-medium">{{ $question->question }}</h4>
                                <p class="text-sm text-gray-500 mb-3">{{ ucfirst(str_replace('_', ' ', $question->type)) }} ({{ $question->points }} point(s))</p>
                                
                                @php
                                    $correctCount = $question->answers->where('is_correct', true)->count();
                                    $totalAttempts = $question->answers->count();
                                    $correctPercentage = $totalAttempts > 0 ? round($correctCount / $totalAttempts * 100) : 0;
                                @endphp
                                
                                <div class="mt-3">
                                    <div class="flex justify-between mb-1">
                                        <span class="text-sm font-medium">Correct Answers: {{ $correctCount }}/{{ $totalAttempts }}</span>
                                        <span class="text-sm font-medium">{{ $correctPercentage }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $correctPercentage }}%"></div>
                                    </div>
                                </div>
                                
                                @if($question->type === 'multiple_choice' || $question->type === 'checkbox' || $question->type === 'true_false')
                                    <div class="mt-4">
                                        <h5 class="text-sm font-medium mb-2">Answer Distribution:</h5>
                                        <ul class="space-y-2">
                                            @foreach($question->options as $option)
                                                @php
                                                    $optionCount = $question->answers->where('answer', $option)->count();
                                                    $optionPercentage = $totalAttempts > 0 ? round($optionCount / $totalAttempts * 100) : 0;
                                                    $isCorrect = in_array($option, $question->correct_answers);
                                                @endphp
                                                <li>
                                                    <div class="flex justify-between text-sm mb-1">
                                                        <span class="{{ $isCorrect ? 'font-bold text-green-600' : '' }}">
                                                            {{ $option }} 
                                                            @if($isCorrect) (Correct) @endif
                                                        </span>
                                                        <span>{{ $optionCount }} ({{ $optionPercentage }}%)</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="{{ $isCorrect ? 'bg-green-600' : 'bg-gray-600' }} h-2.5 rounded-full" style="width: {{ $optionPercentage }}%"></div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <h3 class="text-lg font-medium mb-4">By Individual</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Result</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reviewer->responses as $response)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $response->member->first_name }} {{ $response->member->last_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $response->member->email_address }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $response->created_at->format('M d, Y h:i A') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{ $response->score }} / {{ $response->total_points }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if($reviewer->passing_score)
                                                    @if($response->score >= $reviewer->passing_score)
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Passed
                                                        </span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Failed
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        Completed
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('reviewers.individual-response', ['reviewerId' => $reviewer->id, 'responseId' => $response->id]) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">View Details</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>