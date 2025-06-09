<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Survey Response: {{ $response->survey->title }}
            </h2>
            <a href="{{ route('surveys.responses', $response->survey->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
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
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium">
                                    {{ $response->member ? $response->member->first_name.' '.$response->member->last_name : 'Anonymous User' }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ $response->member->email_address ?? 'No email provided' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm">Completed: {{ \Carbon\Carbon::parse($response->completed_at)->format('M d, Y H:i') }}</p>
                                @if($response->score)
                                <p class="text-sm">Score: {{ $response->score }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @foreach($response->survey->questions as $question)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <h4 class="font-medium">{{ $question->question }}</h4>
                            <p class="text-sm text-gray-500 mb-3">{{ ucfirst(str_replace('-', ' ', $question->type)) }} @if($question->is_required) (Required) @endif</p>
                            
                            @php
                                $answer = $response->answers->where('question_id', $question->id)->first();
                            @endphp
                            
                            @if($answer)
                                @if(in_array($question->type, ['multiple-choice', 'dropdown']))
                                    <p>{{ $answer->answer }}</p>
                                @elseif($question->type === 'checkbox')
                                    <ul class="list-disc list-inside">
                                        @foreach(json_decode($answer->answer, true) ?? [] as $option)
                                        <li>{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="whitespace-pre-wrap">{{ $answer->answer }}</p>
                                @endif
                            @else
                                <p class="text-gray-500">No answer provided</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>