<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Reviewers / Edit
            </h2>
            <a href="{{ route('reviewers.index') }}" class="bg-indigo-600 hover:indigo-700 text-white px-4 py-2 rounded-md flex items-center">
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
                    <form action="{{ route('reviewers.update', $reviewer->id) }}" method="post">
                        @csrf
                        <div class="space-y-6">
                            <!-- Basic Information -->
                            <div>
                                <h3 class="text-lg font-medium mb-4">Basic Information</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="title" class="block text-sm font-medium">Title</label>
                                        <div class="mt-1">
                                            <input type="text" name="title" id="title" value="{{ old('title', $reviewer->title) }}" 
                                                   class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                            @error('title')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label for="passing_score" class="block text-sm font-medium">Passing Score (optional)</label>
                                        <div class="mt-1">
                                            <input type="number" name="passing_score" id="passing_score" 
                                                   value="{{ old('passing_score', $reviewer->passing_score) }}" min="0" 
                                                   class="block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('passing_score')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <label for="description" class="block text-sm font-medium">Description</label>
                                    <div class="mt-1">
                                        <textarea name="description" id="description" rows="3" 
                                                  class="block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $reviewer->description) }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="time_limit" class="block text-sm font-medium">Time Limit (minutes, optional)</label>
                                        <div class="mt-1">
                                            <input type="number" name="time_limit" id="time_limit" 
                                                   value="{{ old('time_limit', $reviewer->time_limit) }}" min="1" 
                                                   class="block w-full rounded-md border-gray-300 shadow-sm">
                                            @error('time_limit')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="hidden" name="is_published" value="0">
                                        <input type="checkbox" name="is_published" id="is_published" 
                                               class="rounded" value="1" {{ old('is_published', $reviewer->is_published) ? 'checked' : '' }}>
                                        <label for="is_published" class="ml-2 text-sm font-medium">Published</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Questions -->
                            <div class="mt-8">
                                <h3 class="text-lg font-medium mb-4">Questions</h3>
                                
                                <div id="questions-container">
                                    @foreach($reviewer->questions as $index => $question)
                                        <div class="question-item mb-6 p-4 border rounded-lg" data-index="{{ $index + 1 }}">
                                            <div class="flex justify-between items-center mb-2">
                                                <h4 class="font-medium">Question #{{ $index + 1 }}</h4>
                                                <button type="button" class="remove-question text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <input type="hidden" name="questions[{{ $index + 1 }}][id]" value="{{ $question->id }}">
                                            
                                            <div class="mb-3">
                                                <label class="text-sm font-medium">Question Text</label>
                                                <input type="text" name="questions[{{ $index + 1 }}][question]" 
                                                       value="{{ old('questions.'.($index+1).'.question', $question->question) }}" 
                                                       placeholder="Enter question" 
                                                       class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div class="mb-3">
                                                    <label class="text-sm font-medium">Question Type</label>
                                                    <select name="questions[{{ $index + 1 }}][type]" class="question-type border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                                        <option value="identification" {{ $question->type === 'identification' ? 'selected' : '' }}>Identification</option>
                                                        <option value="true_false" {{ $question->type === 'true_false' ? 'selected' : '' }}>True or False</option>
                                                        <option value="multiple_choice" {{ $question->type === 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                                        <option value="checkbox" {{ $question->type === 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="text-sm font-medium">Points</label>
                                                    <input type="number" name="questions[{{ $index + 1 }}][points]" min="1" 
                                                           value="{{ old('questions.'.($index+1).'.points', $question->points) }}" 
                                                           class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                                </div>
                                            </div>
                                            
                                            <div class="options-container mb-3 {{ !in_array($question->type, ['multiple_choice', 'checkbox', 'true_false']) ? 'hidden' : '' }}">
                                                <label class="text-sm font-medium">Options (one per line)</label>
                                                <textarea name="questions[{{ $index + 1 }}][options]" 
                                                          class="border-gray-300 shadow-sm w-full rounded-lg mt-1" 
                                                          rows="3">{{ old('questions.'.($index+1).'.options', $question->options ? implode("\n", $question->options) : '') }}</textarea>
                                            </div>
                                            
                                            <div class="correct-answers-container mb-3">
                                                <label class="text-sm font-medium">Correct Answer(s)</label>
                                                <div class="answers-input-container mt-1">
                                                    @if($question->type === 'identification')
                                                        <input type="text" name="questions[{{ $index + 1 }}][correct_answers][]" 
                                                               value="{{ old('questions.'.($index+1).'.correct_answers.0', $question->correct_answers[0] ?? '') }}" 
                                                               class="border-gray-300 shadow-sm w-full rounded-lg" required>
                                                    @elseif($question->type === 'true_false')
                                                        <select name="questions[{{ $index + 1 }}][correct_answers][]" class="border-gray-300 shadow-sm w-full rounded-lg" required>
                                                            <option value="true" {{ (old('questions.'.($index+1).'.correct_answers.0', $question->correct_answers[0] ?? '') === 'true') ? 'selected' : '' }}>True</option>
                                                            <option value="false" {{ (old('questions.'.($index+1).'.correct_answers.0', $question->correct_answers[0] ?? '') === 'false') ? 'selected' : '' }}>False</option>
                                                        </select>
                                                    @elseif($question->type === 'multiple_choice')
                                                        @foreach($question->options as $option)
                                                            <div class="flex items-center mb-2">
                                                                <input type="radio" id="correct-{{ $question->id }}-{{ $loop->index }}" 
                                                                       name="questions[{{ $index + 1 }}][correct_answers][]" 
                                                                       value="{{ $option }}" 
                                                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" 
                                                                       {{ (in_array($option, old('questions.'.($index+1).'.correct_answers', $question->correct_answers ?? []))) ? 'checked' : '' }}
                                                                       required>
                                                                <label for="correct-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm">{{ $option }}</label>
                                                            </div>
                                                        @endforeach
                                                    @elseif($question->type === 'checkbox')
                                                        @foreach($question->options as $option)
                                                            <div class="flex items-center mb-2">
                                                                <input type="checkbox" id="correct-{{ $question->id }}-{{ $loop->index }}" 
                                                                       name="questions[{{ $index + 1 }}][correct_answers][]" 
                                                                       value="{{ $option }}" 
                                                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                                                       {{ (in_array($option, old('questions.'.($index+1).'.correct_answers', $question->correct_answers ?? []))) ? 'checked' : '' }}>
                                                                <label for="correct-{{ $question->id }}-{{ $loop->index }}" class="ml-3 block text-sm">{{ $option }}</label>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <button type="button" id="add-question" class="mt-4 flex items-center px-4 py-2 text-sm text-green-600 hover:text-white hover:bg-green-600 rounded-md transition-colors duration-200 border border-green-100 hover:border-green-600 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Question
                                </button>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit" class="flex items-center px-4 py-2 text-sm text-white bg-indigo-600 hover:bg-indigo-700 rounded-md font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Reviewer
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
            document.addEventListener('DOMContentLoaded', function() {
                const questionsContainer = document.getElementById('questions-container');
                const addQuestionBtn = document.getElementById('add-question');
                let questionCount = {{ $reviewer->questions->count() }};

                // Initialize question type change handlers
                document.querySelectorAll('.question-type').forEach(select => {
                    select.addEventListener('change', function() {
                        const questionDiv = this.closest('.question-item');
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        const correctAnswersContainer = questionDiv.querySelector('.correct-answers-container');
                        const answersInputContainer = questionDiv.querySelector('.answers-input-container');

                        // Show/hide options container
                        if (this.value === 'multiple_choice' || this.value === 'checkbox' || this.value === 'true_false') {
                            optionsContainer.classList.remove('hidden');
                            
                            // Set up options change listener
                            const optionsTextarea = questionDiv.querySelector('textarea[name*="[options]"]');
                            optionsTextarea.addEventListener('input', function() {
                                updateCorrectAnswersInput(this.value, this.value.split('\n'), answersInputContainer, this.name.replace('options', 'correct_answers'), select.value);
                            });
                        } else {
                            optionsContainer.classList.add('hidden');
                        }

                        // Update correct answers input
                        if (this.value === 'true_false') {
                            updateCorrectAnswersInput('true\nfalse', ['true', 'false'], answersInputContainer, select.name.replace('type', 'correct_answers'), 'true_false');
                        } else if (this.value === 'identification') {
                            answersInputContainer.innerHTML = `
                                <input type="text" name="${select.name.replace('type', 'correct_answers')}[]" class="border-gray-300 shadow-sm w-full rounded-lg" required>
                            `;
                        } else if (optionsTextarea && optionsTextarea.value) {
                            updateCorrectAnswersInput(optionsTextarea.value, optionsTextarea.value.split('\n'), answersInputContainer, optionsTextarea.name.replace('options', 'correct_answers'), select.value);
                        }
                    });
                });

                // Initialize remove buttons
                document.querySelectorAll('.remove-question').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const questionDiv = this.closest('.question-item');
                        questionDiv.remove();
                        // Renumber remaining questions
                        const questions = questionsContainer.querySelectorAll('.question-item');
                        questions.forEach((q, index) => {
                            q.dataset.index = index + 1;
                            q.querySelector('h4').textContent = `Question #${index + 1}`;
                            // Update all input names
                            const inputs = q.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => {
                                const name = input.name.replace(/questions\[\d+\]/, `questions[${index + 1}]`);
                                input.name = name;
                            });
                        });
                        questionCount = questions.length;
                    });
                });

                addQuestionBtn.addEventListener('click', function() {
                    questionCount++;
                    const questionDiv = document.createElement('div');
                    questionDiv.className = 'question-item mb-6 p-4 border rounded-lg';
                    questionDiv.dataset.index = questionCount;

                    questionDiv.innerHTML = `
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-medium">Question #${questionCount}</h4>
                            <button type="button" class="remove-question text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mb-3">
                            <label class="text-sm font-medium">Question Text</label>
                            <input type="text" name="questions[${questionCount}][question]" placeholder="Enter question" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="mb-3">
                                <label class="text-sm font-medium">Question Type</label>
                                <select name="questions[${questionCount}][type]" class="question-type border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                    <option value="identification">Identification</option>
                                    <option value="true_false">True or False</option>
                                    <option value="multiple_choice">Multiple Choice</option>
                                    <option value="checkbox">Checkbox</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="text-sm font-medium">Points</label>
                                <input type="number" name="questions[${questionCount}][points]" min="1" value="1" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                            </div>
                        </div>
                        
                        <div class="options-container hidden mb-3">
                            <label class="text-sm font-medium">Options (one per line)</label>
                            <textarea name="questions[${questionCount}][options]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" rows="3"></textarea>
                        </div>
                        
                        <div class="correct-answers-container hidden mb-3">
                            <label class="text-sm font-medium">Correct Answer(s)</label>
                            <div class="answers-input-container mt-1"></div>
                        </div>
                    `;

                    questionsContainer.appendChild(questionDiv);

                    // Add event listener for type change
                    const typeSelect = questionDiv.querySelector('.question-type');
                    typeSelect.addEventListener('change', function() {
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        const correctAnswersContainer = questionDiv.querySelector('.correct-answers-container');
                        const answersInputContainer = questionDiv.querySelector('.answers-input-container');

                        // Show/hide options container
                        if (this.value === 'multiple_choice' || this.value === 'checkbox' || this.value === 'true_false') {
                            optionsContainer.classList.remove('hidden');
                            
                            // Set up options change listener
                            const optionsTextarea = questionDiv.querySelector('textarea[name*="[options]"]');
                            optionsTextarea.addEventListener('input', function() {
                                updateCorrectAnswersInput(this.value, this.value.split('\n'), answersInputContainer, this.name.replace('options', 'correct_answers'), typeSelect.value);
                            });
                        } else {
                            optionsContainer.classList.add('hidden');
                        }

                        // Show/hide correct answers container
                        if (this.value !== 'identification') {
                            correctAnswersContainer.classList.remove('hidden');
                            if (this.value === 'true_false') {
                                updateCorrectAnswersInput('true\nfalse', ['true', 'false'], answersInputContainer, typeSelect.name.replace('type', 'correct_answers'), 'true_false');
                            } else if (optionsTextarea && optionsTextarea.value) {
                                updateCorrectAnswersInput(optionsTextarea.value, optionsTextarea.value.split('\n'), answersInputContainer, optionsTextarea.name.replace('options', 'correct_answers'), typeSelect.value);
                            }
                        } else {
                            correctAnswersContainer.classList.remove('hidden');
                            answersInputContainer.innerHTML = `
                                <input type="text" name="questions[${questionCount}][correct_answers][]" class="border-gray-300 shadow-sm w-full rounded-lg" required>
                            `;
                        }
                    });

                    // Add event listener for remove button
                    const removeBtn = questionDiv.querySelector('.remove-question');
                    removeBtn.addEventListener('click', function() {
                        questionDiv.remove();
                        // Renumber remaining questions
                        const questions = questionsContainer.querySelectorAll('.question-item');
                        questions.forEach((q, index) => {
                            q.dataset.index = index + 1;
                            q.querySelector('h4').textContent = `Question #${index + 1}`;
                            // Update all input names
                            const inputs = q.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => {
                                const name = input.name.replace(/questions\[\d+\]/, `questions[${index + 1}]`);
                                input.name = name;
                            });
                        });
                        questionCount = questions.length;
                    });

                    // Trigger change event to initialize correct UI
                    typeSelect.dispatchEvent(new Event('change'));
                });

                function updateCorrectAnswersInput(optionsText, optionsArray, container, namePrefix, questionType) {
                    container.innerHTML = '';
                    
                    if (questionType === 'true_false') {
                        container.innerHTML = `
                            <select name="${namePrefix}[]" class="border-gray-300 shadow-sm w-full rounded-lg" required>
                                <option value="true">True</option>
                                <option value="false">False</option>
                            </select>
                        `;
                    } 
                    else if (questionType === 'multiple_choice') {
                        optionsArray = optionsArray.filter(opt => opt.trim() !== '');
                        optionsArray.forEach((option, idx) => {
                            const div = document.createElement('div');
                            div.className = 'flex items-center mb-2';
                            div.innerHTML = `
                                <input type="radio" id="correct-${questionCount}-${idx}" name="${namePrefix}[]" value="${option.trim()}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" ${idx === 0 ? 'required' : ''}>
                                <label for="correct-${questionCount}-${idx}" class="ml-3 block text-sm">${option.trim()}</label>
                            `;
                            container.appendChild(div);
                        });
                    }
                    else if (questionType === 'checkbox') {
                        optionsArray = optionsArray.filter(opt => opt.trim() !== '');
                        optionsArray.forEach((option, idx) => {
                            const div = document.createElement('div');
                            div.className = 'flex items-center mb-2';
                            div.innerHTML = `
                                <input type="checkbox" id="correct-${questionCount}-${idx}" name="${namePrefix}[]" value="${option.trim()}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="correct-${questionCount}-${idx}" class="ml-3 block text-sm">${option.trim()}</label>
                            `;
                            container.appendChild(div);
                        });
                    }
                }
            });
        </script>
    </x-slot>
</x-app-layout>