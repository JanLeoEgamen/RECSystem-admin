<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Survey Responses: {{ $survey->title }}
            </h2>

            <a href="{{ route('surveys.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto text-center">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Surveys
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Summary</h3>
                        <p class="text-gray-600 dark:text-gray-400">Total Responses: {{ $survey->responses->count() }}</p>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-medium mb-4">By Question</h3>
                        
                        @foreach($survey->questions as $question)
                            <div class="mb-6 p-4 border rounded-lg">
                                <h4 class="font-medium">{{ $question->question }}</h4>
                                <p class="text-sm text-gray-500 mb-3">{{ ucfirst(str_replace('-', ' ', $question->type)) }}</p>
                                
                                @if(in_array($question->type, ['checkbox', 'multiple-choice']))
                                    <div class="mt-3">
                                        <h5 class="text-sm font-medium mb-2">Response Summary:</h5>
                                        <ul class="space-y-2">
                                            @php
                                                $answerCounts = [];
                                                foreach($question->answers as $answer) {
                                                    if ($question->type === 'checkbox') {
                                                        $selectedOptions = json_decode($answer->answer, true) ?? [];
                                                        foreach($selectedOptions as $option) {
                                                            $answerCounts[$option] = ($answerCounts[$option] ?? 0) + 1;
                                                        }
                                                    } else {
                                                        $answerCounts[$answer->answer] = ($answerCounts[$answer->answer] ?? 0) + 1;
                                                    }
                                                }
                                            @endphp
                                            
                                            @foreach($question->options as $option)
                                                @php
                                                    $count = $answerCounts[$option] ?? 0;
                                                    $percentage = $survey->responses->count() > 0 ? ($count / $survey->responses->count()) * 100 : 0;
                                                @endphp
                                                <li>
                                                    <div class="flex justify-between text-sm mb-1">
                                                        <span>{{ $option }}</span>
                                                        <span>{{ $count }} ({{ round($percentage, 1) }}%)</span>
                                                    </div>
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <h5 class="text-sm font-medium mb-2">Sample Responses:</h5>
                                        <ul class="space-y-1">
                                            @foreach($question->answers->take(5) as $answer)
                                                <li class="text-sm">"{{ Str::limit($answer->answer, 100) }}"</li>
                                            @endforeach
                                        </ul>
                                        @if($question->answers->count() > 5)
                                            <p class="text-sm text-gray-500 mt-1">+ {{ $question->answers->count() - 5 }} more responses</p>
                                        @endif
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
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($survey->responses as $response)
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
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('surveys.individual-response', ['survey' => $survey, 'response' => $response]) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>                                            </td>
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