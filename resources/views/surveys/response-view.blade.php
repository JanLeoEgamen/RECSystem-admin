<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Survey Response: {{ $survey->title }}
            </h2>
            <a href="{{ route('surveys.responses', $survey->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
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
                        <h3 class="text-xl font-semibold">{{ $survey->title }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mt-2">
                            Response by: {{ $response->member->first_name }} {{ $response->member->last_name }} ({{ $response->member->email_address }})
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Started: {{ $response->started_at->format('M d, Y H:i') }} | 
                            Completed: {{ $response->completed_at ? $response->completed_at->format('M d, Y H:i') : 'Not completed' }} | 
                            Score: {{ $response->score ?? 'N/A' }}
                        </p>
                    </div>

                    <div class="space-y-6">
                        @foreach($survey->questions as $question)
                            @php
                                $answer = $response->answers->where('question_id', $question->id)->first();
                            @endphp
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <h4 class="font-medium">{{ $question->question }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Type: {{ ucfirst(str_replace('-', ' ', $question->type)) }}
                                </p>
                                
                                <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    @if($answer)
                                        @if($question->type === 'multiple-choice' || $question->type === 'dropdown')
                                            <p class="text-gray-800 dark:text-gray-200">{{ $answer->answer }}</p>
                                        @elseif($question->type === 'checkbox')
                                            <ul class="list-disc list-inside text-gray-800 dark:text-gray-200">
                                                @foreach(json_decode($answer->answer) as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-gray-800 dark:text-gray-200">{{ $answer->answer }}</p>
                                        @endif
                                    @else
                                        <p class="text-gray-500 dark:text-gray-400 italic">No answer provided</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('surveys.response-resend', ['survey' => $survey->id, 'response' => $response->id]) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Resend Results
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>