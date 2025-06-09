<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Surveys / Edit
            </h2>
            <a href="{{ route('surveys.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
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
                    <form action="{{ route('surveys.update', $survey->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input value="{{ old('title', $survey->title) }}" name="title" placeholder="Enter survey title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="description" class="text-sm font-medium">Description</label>
                            <div class="my-3">    
                                <textarea name="description" placeholder="Enter survey description" class="border-gray-300 shadow-sm w-full rounded-lg">{{ old('description', $survey->description) }}</textarea>
                                @error('description')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label class="text-sm font-medium">Questions</label>
                            <div class="my-3" id="questions-container">
                                @foreach($survey->questions as $index => $question)
                                <div class="question-row mb-6 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex justify-between mb-2">
                                        <span class="font-medium">Question #{{ $index + 1 }}</span>
                                        <button type="button" class="remove-question text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" name="questions[{{ $index }}][question]" placeholder="Question text" 
                                            value="{{ old("questions.$index.question", $question->question) }}" 
                                            class="border-gray-300 shadow-sm w-full rounded-lg" required>
                                    </div>
                                    <div class="mb-3">
                                        <select name="questions[{{ $index }}][type]" class="question-type border-gray-300 shadow-sm rounded-lg" required>
                                            <option value="">Select question type</option>
                                            <option value="short-answer" {{ old("questions.$index.type", $question->type) == 'short-answer' ? 'selected' : '' }}>Short Answer</option>
                                            <option value="long-answer" {{ old("questions.$index.type", $question->type) == 'long-answer' ? 'selected' : '' }}>Long Answer</option>
                                            <option value="multiple-choice" {{ old("questions.$index.type", $question->type) == 'multiple-choice' ? 'selected' : '' }}>Multiple Choice</option>
                                            <option value="checkbox" {{ old("questions.$index.type", $question->type) == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                            <option value="dropdown" {{ old("questions.$index.type", $question->type) == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 options-container {{ in_array($question->type, ['multiple-choice', 'checkbox', 'dropdown']) ? '' : 'hidden' }}">
                                        <textarea name="questions[{{ $index }}][options]" placeholder="Enter options, one per line" class="border-gray-300 shadow-sm w-full rounded-lg">{{ old("questions.$index.options", $question->options ? implode("\n", $question->options) : '') }}</textarea>
                                        <p class="text-xs text-gray-500">Enter one option per line</p>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="questions[{{ $index }}][is_required]" id="question-{{ $index }}-required" 
                                            {{ old("questions.$index.is_required", $question->is_required) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <label for="question-{{ $index }}-required" class="ml-2">Required</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-question" class="mb-4 text-blue-600 hover:text-blue-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Question
                            </button>

                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-blue-600 hover:text-white hover:bg-blue-600 rounded-md transition-colors duration-200 border border-blue-100 hover:border-blue-600 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Update Survey
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            // Add question row
            let questionCount = {{ count($survey->questions) }};
            $('#add-question').click(function() {
                const newRow = `
                    <div class="question-row mb-6 p-4 border border-gray-200 rounded-lg">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Question #${questionCount + 1}</span>
                            <button type="button" class="remove-question text-red-600 hover:text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="questions[${questionCount}][question]" placeholder="Question text" class="border-gray-300 shadow-sm w-full rounded-lg" required>
                        </div>
                        <div class="mb-3">
                            <select name="questions[${questionCount}][type]" class="question-type border-gray-300 shadow-sm rounded-lg" required>
                                <option value="">Select question type</option>
                                <option value="short-answer">Short Answer</option>
                                <option value="long-answer">Long Answer</option>
                                <option value="multiple-choice">Multiple Choice</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="dropdown">Dropdown</option>
                            </select>
                        </div>
                        <div class="mb-3 options-container hidden">
                            <textarea name="questions[${questionCount}][options]" placeholder="Enter options, one per line" class="border-gray-300 shadow-sm w-full rounded-lg"></textarea>
                            <p class="text-xs text-gray-500">Enter one option per line</p>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="questions[${questionCount}][is_required]" id="question-${questionCount}-required" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <label for="question-${questionCount}-required" class="ml-2">Required</label>
                        </div>
                    </div>
                `;
                $('#questions-container').append(newRow);
                questionCount++;
            });

            // Remove question row
            $(document).on('click', '.remove-question', function() {
                if ($('.question-row').length > 1) {
                    $(this).closest('.question-row').remove();
                    // Renumber questions
                    $('.question-row').each(function(index) {
                        $(this).find('.font-medium').text('Question #' + (index + 1));
                    });
                    questionCount = $('.question-row').length;
                } else {
                    alert('At least one question is required.');
                }
            });

            // Show/hide options based on question type
            $(document).on('change', '.question-type', function() {
                const type = $(this).val();
                const optionsContainer = $(this).closest('.question-row').find('.options-container');
                
                if (['multiple-choice', 'checkbox', 'dropdown'].includes(type)) {
                    optionsContainer.removeClass('hidden');
                    optionsContainer.find('textarea').attr('required', true);
                } else {
                    optionsContainer.addClass('hidden');
                    optionsContainer.find('textarea').removeAttr('required');
                }
            });
        </script>
    </x-slot>
</x-app-layout>