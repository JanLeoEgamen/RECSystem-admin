<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Survey: {{ $survey->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('surveys.edit', $survey->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('surveys.send', $survey->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Send
                </a>
                <a href="{{ route('surveys.responses', $survey->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Responses
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-2">Survey Link</h3>
                        <div class="flex items-center">
                            <input type="text" id="survey-link" value="{{ route('survey.show', $survey->slug) }}" class="border-gray-300 shadow-sm w-full rounded-l-lg" readonly>
                            <button onclick="copySurveyLink()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg">
                                Copy
                            </button>
                        </div>
                    </div>

                    @if($survey->description)
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-2">Description</h3>
                        <p>{{ $survey->description }}</p>
                    </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-2">Questions</h3>
                        <div class="space-y-4">
                            @foreach($survey->questions as $question)
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="font-medium">{{ $question->question }}</h4>
                                        <p class="text-sm text-gray-500">{{ ucfirst(str_replace('-', ' ', $question->type)) }} @if($question->is_required) (Required) @endif</p>
                                    </div>
                                </div>
                                
                                @if(in_array($question->type, ['multiple-choice', 'checkbox', 'dropdown']))
                                <div class="mt-3">
                                    <p class="text-sm font-medium">Options:</p>
                                    <ul class="list-disc list-inside">
                                        @foreach($question->options as $option)
                                        <li>{{ $option }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            function copySurveyLink() {
                const linkInput = document.getElementById('survey-link');
                linkInput.select();
                document.execCommand('copy');
                
                // Show notification
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg';
                notification.textContent = 'Link copied to clipboard!';
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        </script>
    </x-slot>
</x-app-layout>