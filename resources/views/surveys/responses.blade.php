<x-app-layout>
    
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Survey Responses: {{ $survey->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('surveys.view', $survey->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Survey
                </a>
                <a href="{{ route('surveys.send', $survey->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Send Survey
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <div class="flex space-x-2">
                            <a href="{{ route('surveys.responses', ['survey' => $survey->id, 'view' => 'summary']) }}" 
                            class="px-4 py-2 rounded-md {{ $viewType === 'summary' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                                Summary
                            </a>
                            <a href="{{ route('surveys.responses', ['survey' => $survey->id, 'view' => 'question']) }}" 
                            class="px-4 py-2 rounded-md {{ $viewType === 'question' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                                By Question
                            </a>
                            <a href="{{ route('surveys.responses', ['survey' => $survey->id, 'view' => 'individual']) }}" 
                            class="px-4 py-2 rounded-md {{ $viewType === 'individual' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                                By Individual
                            </a>
                        </div>
                    </div>

                    @if($viewType === 'summary')
                        <div class="space-y-6">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="text-lg font-medium mb-2">Response Summary</h3>
                                <p>Total Responses: {{ $responses->count() }}</p>
                            </div>

                            @foreach($summaryData as $questionId => $data)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h4 class="font-medium">{{ $data['question'] }}</h4>
                                <p class="text-sm text-gray-500 mb-3">{{ ucfirst(str_replace('-', ' ', $data['type'])) }} - {{ $data['total_answers'] }} responses</p>
                                
                                @if(in_array($data['type'], ['multiple-choice', 'checkbox', 'dropdown']))
                                    <div class="mt-4">
                                        @foreach($data['option_counts'] as $option => $count)
                                        <div class="mb-2">
                                            <div class="flex justify-between mb-1">
                                                <span>{{ $option }}</span>
                                                <span>{{ $count }} ({{ $data['total_answers'] > 0 ? round(($count / $data['total_answers']) * 100, 1) : 0 }}%)</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $data['total_answers'] > 0 ? ($count / $data['total_answers']) * 100 : 0 }}%"></div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mt-4">
                                        <p class="text-sm font-medium">Sample Responses:</p>
                                        <ul class="list-disc list-inside">
                                            @foreach(array_slice($data['answers'], 0, 5) as $answer)
                                            <li class="truncate">{{ $answer }}</li>
                                            @endforeach
                                            @if(count($data['answers']) > 5)
                                            <li>...and {{ count($data['answers']) - 5 }} more</li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @elseif($viewType === 'question')
                        <div class="mb-4">
                            <label for="question-select" class="block text-sm font-medium mb-2">Select Question</label>
                            <select id="question-select" class="border-gray-300 shadow-sm rounded-lg w-full">
                                @foreach($questions as $question)
                                <option value="{{ $question->id }}">{{ $question->question }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="question-responses">
                            @foreach($questions as $question)
                            <div class="question-responses hidden" id="responses-for-question-{{ $question->id }}">
                                <h3 class="text-lg font-medium mb-2">{{ $question->question }}</h3>
                                <p class="text-sm text-gray-500 mb-3">{{ ucfirst(str_replace('-', ' ', $question->type)) }}</p>
                                
                                <div class="space-y-4">
                                    @php
                                        $answers = \App\Models\SurveyAnswer::where('question_id', $question->id)->get();
                                    @endphp
                                    
                                    @if($answers->count() > 0)
                                        @if(in_array($question->type, ['multiple-choice', 'checkbox', 'dropdown']))
                                            @php
                                                $options = $question->options;
                                                $optionCounts = array_fill_keys($options, 0);
                                                
                                                foreach ($answers as $answer) {
                                                    if ($question->type === 'checkbox') {
                                                        $selectedOptions = json_decode($answer->answer, true) ?? [];
                                                        foreach ($selectedOptions as $option) {
                                                            if (isset($optionCounts[$option])) {
                                                                $optionCounts[$option]++;
                                                            }
                                                        }
                                                    } else {
                                                        if (isset($optionCounts[$answer->answer])) {
                                                            $optionCounts[$answer->answer]++;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            
                                            @foreach($optionCounts as $option => $count)
                                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                                <div class="flex justify-between mb-1">
                                                    <span>{{ $option }}</span>
                                                    <span>{{ $count }} ({{ $answers->count() > 0 ? round(($count / $answers->count()) * 100, 1) : 0 }}%)</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $answers->count() > 0 ? ($count / $answers->count()) * 100 : 0 }}%"></div>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
@foreach($answers->take(10) as $answer)
<div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
    <div class="flex justify-between items-start">
        <div>
            <p class="font-medium">
                {{ $answer->response->member ? $answer->response->member->first_name.' '.$answer->response->member->last_name : 'Anonymous User' }}
            </p>
            <p class="text-sm text-gray-500">
                {{ $answer->response->member->email_address ?? 'No email' }}
            </p>
        </div>
        <p class="text-sm">{{ \Carbon\Carbon::parse($answer->response->completed_at)->format('M d, Y H:i') }}</p>
    </div>
    <div class="mt-2">
        <p class="whitespace-pre-wrap">{{ $answer->answer }}</p>
    </div>
</div>
@endforeach
                                        @endif
                                    @else
                                        <p class="text-gray-500">No responses for this question yet.</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @elseif($viewType === 'individual')
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Completed At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Score</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
@foreach($responses as $response)
<tr>
    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">
        {{ $response->member ? $response->member->first_name.' '.$response->member->last_name : 'Anonymous User' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">
        {{ $response->member->email_address ?? 'No email' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">
        {{ \Carbon\Carbon::parse($response->completed_at)->format('M d, Y H:i') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap dark:text-gray-300">
        {{ $response->score ?? 'N/A' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex space-x-2">
            <a href="{{ route('surveys.responses.view', ['survey' => $survey->id, 'response' => $response->id]) }}" 
               class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" 
               title="View Response">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
            <a href="javascript:void(0)" 
               onclick="confirmDeleteResponse({{ $response->id }}, '{{ $response->member ? $response->member->first_name.' '.$response->member->last_name : 'Anonymous User' }}')"
               class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" 
               title="Delete Response">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </a>
        </div>
    </td>
</tr>
@endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // For question view
            $(document).ready(function() {
                // Show first question by default
                const firstQuestionId = $('#question-select').val();
                $(`#responses-for-question-${firstQuestionId}`).removeClass('hidden');
                
                // Handle question selection change
                $('#question-select').on('change', function() {
                    const questionId = $(this).val();
                    $('.question-responses').addClass('hidden');
                    $(`#responses-for-question-${questionId}`).removeClass('hidden');
                });
            });

            function confirmDeleteResponse(responseId, memberName) {
                if (confirm(`Are you sure you want to delete the response from ${memberName}?`)) {
                    // Show loading state
                    const loadingDiv = document.createElement('div');
                    loadingDiv.className = 'fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg bg-blue-500 text-white notification';
                    loadingDiv.innerHTML = `
                        <div class="flex items-center">
                            <svg class="animate-spin h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Deleting response...</span>
                        </div>
                    `;
                    document.body.appendChild(loadingDiv);

                    $.ajax({
                        url: '{{ route("surveys.delete-response") }}',
                        type: 'delete',
                        data: {id: responseId},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            // Remove loading notification
                            loadingDiv.classList.add('hide');
                            setTimeout(() => loadingDiv.remove(), 500);

                            // Show result notification
                            const messageDiv = document.createElement('div');
                            messageDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg text-white notification ${
                                response.status ? 'bg-green-500' : 'bg-red-500'
                            }`;
                            messageDiv.innerHTML = `
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${response.status ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"/>
                                    </svg>
                                    <span>${response.message}</span>
                                </div>
                            `;
                            
                            document.body.appendChild(messageDiv);
                            
                            // Auto-remove after 5 seconds
                            setTimeout(() => {
                                messageDiv.classList.add('hide');
                                setTimeout(() => messageDiv.remove(), 500);
                            }, 5000);
                            
                            // Reload the page if successful
                            if (response.status) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            // Remove loading notification
                            loadingDiv.classList.add('hide');
                            setTimeout(() => loadingDiv.remove(), 500);

                            // Show error notification
                            const messageDiv = document.createElement('div');
                            messageDiv.className = 'fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg bg-red-500 text-white notification';
                            messageDiv.innerHTML = `
                                <div class="flex items-center">
                                    <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span>An error occurred while deleting the response</span>
                                </div>
                            `;
                            document.body.appendChild(messageDiv);
                            setTimeout(() => {
                                messageDiv.classList.add('hide');
                                setTimeout(() => messageDiv.remove(), 500);
                            }, 5000);
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>