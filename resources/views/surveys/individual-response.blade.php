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
                    <div class="mb-6">
                        <h3 class="text-lg font-medium">Respondent Information</h3>
                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p>{{ $response->member->first_name }} {{ $response->member->last_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p>{{ $response->member->email_address }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Submitted On</p>
                                <p>{{ $response->created_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-lg font-medium">Responses</h3>
                        
                        @foreach($response->survey->questions as $question)
                            @php
                                $answer = $response->answers->where('question_id', $question->id)->first();
                            @endphp
                            
                            <div class="p-4 border rounded-lg">
                                <h4 class="font-medium">{{ $question->question }}</h4>
                                <p class="text-sm text-gray-500 mb-3">{{ ucfirst(str_replace('-', ' ', $question->type)) }}</p>
                                
                                @if($answer)
                                    @if($question->type === 'checkbox')
                                        <ul class="list-disc list-inside mt-2">
                                            @foreach(json_decode($answer->answer, true) ?? [] as $selectedOption)
                                                <li>{{ $selectedOption }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mt-2">{{ $answer->answer }}</p>
                                    @endif
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