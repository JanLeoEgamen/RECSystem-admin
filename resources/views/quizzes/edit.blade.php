<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Quizzes / Edit
            </h2>

            <a href="{{ route('quizzes.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto text-center">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Quizzes
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('quizzes.update', $quiz->id) }}" method="post" id="updateForm">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input id="title" value="{{ old('title', $quiz->title) }}" name="title" placeholder="Enter quiz title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="description" class="text-sm font-medium">Description</label>
                            <div class="my-3">    
                                <textarea id="description" name="description" placeholder="Enter quiz description" class="border-gray-300 shadow-sm w-full rounded-lg" rows="3">{{ old('description', $quiz->description) }}</textarea>
                                @error('description')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="my-3 flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" class="rounded" value="1" 
                                    {{ old('is_published', $quiz->is_published) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2">Published</label>
                            </div>

                            <div class="mt-8">
                                <h3 class="text-lg font-medium mb-4">Questions</h3>
                                
                                <div id="questions-container">
                                    @foreach($quiz->questions as $index => $question)
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
                                                <label for="question-{{ $index + 1 }}" class="text-sm font-medium">Question Text</label>
                                                <input id="question-{{ $index + 1 }}" type="text" name="questions[{{ $index + 1 }}][question]" 
                                                    value="{{ old('questions.'.($index+1).'.question', $question->question) }}" 
                                                    placeholder="Enter question" 
                                                    class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="type-{{ $index + 1 }}" class="text-sm font-medium">Question Type</label>
                                                <select id="type-{{ $index + 1 }}" name="questions[{{ $index + 1 }}][type]" class="question-type border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                                    <option value="identification" {{ $question->type == 'identification' ? 'selected' : '' }}>Identification</option>
                                                    <option value="true-false" {{ $question->type == 'true-false' ? 'selected' : '' }}>True or False</option>
                                                    <option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                    <option value="multiple-choice" {{ $question->type == 'multiple-choice' ? 'selected' : '' }}>Multiple Choice</option>
                                                </select>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="points-{{ $index + 1 }}" class="text-sm font-medium">Points</label>
                                                <input id="points-{{ $index + 1 }}" type="number" name="questions[{{ $index + 1 }}][points]" 
                                                    min="0" step="0.01" 
                                                    value="{{ old('questions.'.($index+1).'.points', $question->points) }}" 
                                                    class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                            </div>
                                            
                                            <div class="options-container mb-3 {{ !in_array($question->type, ['checkbox', 'multiple-choice']) ? 'hidden' : '' }}">
                                                <label for="options-{{ $index + 1 }}" class="text-sm font-medium">Options (one per line)</label>
                                                <textarea id="options-{{ $index + 1 }}" name="questions[{{ $index + 1 }}][options]" 
                                                    class="border-gray-300 shadow-sm w-full rounded-lg mt-1" 
                                                    rows="3">{{ old('questions.'.($index+1).'.options', $question->options ? implode("\n", $question->options) : '') }}</textarea>
                                            </div>
                                            
                                            <div class="correct-answers-container mb-3">
                                                <label class="text-sm font-medium">Correct Answer(s)</label>
                                                <div class="correct-answers-inputs">
                                                    @if($question->type === 'identification')
                                                        <input type="text" name="questions[{{ $index + 1 }}][correct_answers]" 
                                                            value="{{ old('questions.'.($index+1).'.correct_answers', $question->correct_answers[0] ?? '') }}" 
                                                            class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                                    @elseif($question->type === 'true-false')
                                                        <select name="questions[{{ $index + 1 }}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                                            <option value="true" {{ old('questions.'.($index+1).'.correct_answers', $question->correct_answers[0] ?? '') == 'true' ? 'selected' : '' }}>True</option>
                                                            <option value="false" {{ old('questions.'.($index+1).'.correct_answers', $question->correct_answers[0] ?? '') == 'false' ? 'selected' : '' }}>False</option>
                                                        </select>
                                                    @elseif($question->type === 'multiple-choice')
                                                        <select name="questions[{{ $index + 1 }}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                                            <option value="">Select correct answer</option>
                                                            @foreach($question->options as $option)
                                                                <option value="{{ $option }}" {{ (old('questions.'.($index+1).'.correct_answers', $question->correct_answers[0] ?? '') == $option) ? 'selected' : '' }}>{{ $option }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($question->type === 'checkbox')
                                                        <div class="space-y-2 mt-2">
                                                            @foreach($question->options as $option)
                                                                <div class="flex items-center">
                                                                    <input type="checkbox" name="questions[{{ $index + 1 }}][correct_answers][]" 
                                                                        id="q{{ $index + 1 }}-correct-{{ $loop->index }}" 
                                                                        value="{{ $option }}" 
                                                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                                                        {{ in_array($option, old('questions.'.($index+1).'.correct_answers', $question->correct_answers ?? [])) ? 'checked' : '' }}>
                                                                    <label for="q{{ $index + 1 }}-correct-{{ $loop->index }}" class="ml-2 text-sm">{{ $option }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
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

                            <div class="my-3">
                                <label class="text-sm font-medium">Assign to Members</label>
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="select-all-members" class="rounded mr-2"
                                        {{ count($quiz->members) === count($members) ? 'checked' : '' }}>
                                    <label for="select-all-members">Select All Members</label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach($members as $member)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="members[]" id="member-{{ $member->id }}" 
                                                value="{{ $member->id }}" class="rounded member-checkbox"
                                                {{ $quiz->members->contains($member->id) ? 'checked' : '' }}>
                                            <label for="member-{{ $member->id }}" class="ml-2">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('members')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="mt-6">
                                <button type="button" id="updateButton"  
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                                        dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-colors duration-200">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Quiz
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-slot name="script">
        <script>
            document.getElementById("updateButton").addEventListener("click", function() {
                Swal.fire({
                    title: 'Update Quiz?',
                    text: "Are you sure you want to update this quiz?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5e6ffb',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel',
                    background: '#101966',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Updating...',
                            text: 'Please wait',
                            timer: 1500,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            willClose: () => {
                                document.getElementById('updateForm').submit();
                            },
                            background: '#101966',
                            color: '#fff',
                            allowOutsideClick: false
                        });
                    }
                });
            });

            @if(session('success'))
                Swal.fire({
                    icon: "success",
                    title: "Updated!",
                    text: "{{ session('success') }}",
                    confirmButtonColor: "#101966",
                    background: '#101966',
                    color: '#fff'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "{{ session('error') }}",
                    confirmButtonColor: "#101966",
                    background: '#101966',
                    color: '#fff'
                });
            @endif

            document.addEventListener('DOMContentLoaded', function() {
                const questionsContainer = document.getElementById('questions-container');
                const addQuestionBtn = document.getElementById('add-question');
                let questionCount = {{ $quiz->questions->count() }};

                document.querySelectorAll('.question-type').forEach(select => {
                    select.addEventListener('change', function() {
                        const questionDiv = this.closest('.question-item');
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        const correctAnswersContainer = questionDiv.querySelector('.correct-answers-container');
                        const correctAnswersInputs = questionDiv.querySelector('.correct-answers-inputs');
                        
                        if (this.value === 'checkbox' || this.value === 'multiple-choice') {
                            optionsContainer.classList.remove('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            
                            correctAnswersInputs.innerHTML = '';
                            
                            if (this.value === 'multiple-choice') {
                                correctAnswersInputs.innerHTML = `
                                    <select name="${this.name.replace('[type]', '[correct_answers]')}" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                        <option value="">Select correct answer</option>
                                    </select>
                                `;
                            } else {
                                correctAnswersInputs.innerHTML = `
                                    <div class="space-y-2 mt-2">
                                        <p class="text-xs text-gray-500">Select all correct answers (will be populated after options are entered)</p>
                                    </div>
                                `;
                            }
                        } else if (this.value === 'true-false') {
                            optionsContainer.classList.add('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            correctAnswersInputs.innerHTML = `
                                <select name="${this.name.replace('[type]', '[correct_answers]')}" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            `;
                        } else {
                            optionsContainer.classList.add('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            correctAnswersInputs.innerHTML = `
                                <input type="text" name="${this.name.replace('[type]', '[correct_answers]')}" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                            `;
                        }
                    });

                    const optionsTextarea = select.closest('.question-item').querySelector('textarea[name^="questions"]');
                    if (optionsTextarea) {
                        optionsTextarea.addEventListener('input', function() {
                            const typeSelect = select.closest('.question-item').querySelector('.question-type');
                            if (typeSelect.value === 'multiple-choice') {
                                const options = this.value.split('\n').filter(opt => opt.trim() !== '');
                                const correctAnswersSelect = select.closest('.question-item').querySelector('select[name^="questions"][name$="[correct_answers]"]');
                                
                                if (correctAnswersSelect) {
                                    correctAnswersSelect.innerHTML = '<option value="">Select correct answer</option>';
                                    options.forEach(option => {
                                        if (option.trim() !== '') {
                                            const opt = document.createElement('option');
                                            opt.value = option.trim();
                                            opt.textContent = option.trim();
                                            correctAnswersSelect.appendChild(opt);
                                        }
                                    });
                                }
                            } else if (typeSelect.value === 'checkbox') {
                                const options = this.value.split('\n').filter(opt => opt.trim() !== '');
                                const correctAnswersDiv = select.closest('.question-item').querySelector('.correct-answers-inputs > div');
                                
                                if (correctAnswersDiv) {
                                    correctAnswersDiv.innerHTML = '';
                                    options.forEach((option, index) => {
                                        if (option.trim() !== '') {
                                            const div = document.createElement('div');
                                            div.className = 'flex items-center';
                                            const qIndex = select.closest('.question-item').dataset.index;
                                            div.innerHTML = `
                                                <input type="checkbox" name="questions[${qIndex}][correct_answers][]" 
                                                    id="q${qIndex}-correct-${index}" 
                                                    value="${option.trim()}" 
                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <label for="q${qIndex}-correct-${index}" class="ml-2 text-sm">${option.trim()}</label>
                                            `;
                                            correctAnswersDiv.appendChild(div);
                                        }
                                    });
                                }
                            }
                        });
                    }
                });

                document.querySelectorAll('.remove-question').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const questionDiv = this.closest('.question-item');
                        questionDiv.remove();
                        const questions = questionsContainer.querySelectorAll('.question-item');
                        questions.forEach((q, index) => {
                            q.dataset.index = index + 1;
                            q.querySelector('h4').textContent = `Question #${index + 1}`;
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
                            <label for="question-${questionCount}" class="text-sm font-medium">Question Text</label>
                            <input id="question-${questionCount}" type="text" name="questions[${questionCount}][question]" placeholder="Enter question" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="type-${questionCount}" class="text-sm font-medium">Question Type</label>
                            <select id="type-${questionCount}" name="questions[${questionCount}][type]" class="question-type border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                <option value="identification">Identification</option>
                                <option value="true-false">True or False</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="multiple-choice">Multiple Choice</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="points-${questionCount}" class="text-sm font-medium">Points</label>
                            <input id="points-${questionCount}" type="number" name="questions[${questionCount}][points]" min="0" step="0.01" value="1.00" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                        </div>
                        
                        <div class="options-container hidden mb-3">
                            <label for="options-${questionCount}" class="text-sm font-medium">Options (one per line)</label>
                            <textarea id="options-${questionCount}" name="questions[${questionCount}][options]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" rows="3"></textarea>
                        </div>
                        
                        <div class="correct-answers-container hidden mb-3">
                            <label class="text-sm font-medium">Correct Answer(s)</label>
                            <div class="correct-answers-inputs"></div>
                        </div>
                    `;

                    questionsContainer.appendChild(questionDiv);

                    const typeSelect = questionDiv.querySelector('.question-type');
                    typeSelect.addEventListener('change', function() {
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        const correctAnswersContainer = questionDiv.querySelector('.correct-answers-container');
                        const correctAnswersInputs = questionDiv.querySelector('.correct-answers-inputs');
                        
                        if (this.value === 'checkbox' || this.value === 'multiple-choice') {
                            optionsContainer.classList.remove('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            
                            correctAnswersInputs.innerHTML = '';
                            
                            if (this.value === 'multiple-choice') {
                                correctAnswersInputs.innerHTML = `
                                    <select name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                        <option value="">Select correct answer</option>
                                    </select>
                                `;
                            } else {
                                correctAnswersInputs.innerHTML = `
                                    <div class="space-y-2 mt-2">
                                        <p class="text-xs text-gray-500">Select all correct answers (will be populated after options are entered)</p>
                                    </div>
                                `;
                            }
                        } else if (this.value === 'true-false') {
                            optionsContainer.classList.add('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            correctAnswersInputs.innerHTML = `
                                <select name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            `;
                        } else {
                            optionsContainer.classList.add('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            correctAnswersInputs.innerHTML = `
                                <input type="text" name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                            `;
                        }
                    });

                    typeSelect.dispatchEvent(new Event('change'));

                    const optionsTextarea = questionDiv.querySelector('textarea[name^="questions"]');
                    optionsTextarea.addEventListener('input', function() {
                        const typeSelect = questionDiv.querySelector('.question-type');
                        if (typeSelect.value === 'multiple-choice') {
                            const options = this.value.split('\n').filter(opt => opt.trim() !== '');
                            const correctAnswersSelect = questionDiv.querySelector('select[name^="questions"][name$="[correct_answers]"]');
                            
                            if (correctAnswersSelect) {
                                correctAnswersSelect.innerHTML = '<option value="">Select correct answer</option>';
                                options.forEach(option => {
                                    if (option.trim() !== '') {
                                        const opt = document.createElement('option');
                                        opt.value = option.trim();
                                        opt.textContent = option.trim();
                                        correctAnswersSelect.appendChild(opt);
                                    }
                                });
                            }
                        } else if (typeSelect.value === 'checkbox') {
                            const options = this.value.split('\n').filter(opt => opt.trim() !== '');
                            const correctAnswersDiv = questionDiv.querySelector('.correct-answers-inputs > div');
                            
                            if (correctAnswersDiv) {
                                correctAnswersDiv.innerHTML = '';
                                options.forEach((option, index) => {
                                    if (option.trim() !== '') {
                                        const div = document.createElement('div');
                                        div.className = 'flex items-center';
                                        div.innerHTML = `
                                            <input type="checkbox" name="questions[${questionCount}][correct_answers][]" 
                                                id="q${questionCount}-correct-${index}" 
                                                value="${option.trim()}" 
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="q${questionCount}-correct-${index}" class="ml-2 text-sm">${option.trim()}</label>
                                        `;
                                        correctAnswersDiv.appendChild(div);
                                    }
                                });
                            }
                        }
                    });

                    const removeBtn = questionDiv.querySelector('.remove-question');
                    removeBtn.addEventListener('click', function() {
                        questionDiv.remove();
                        const questions = questionsContainer.querySelectorAll('.question-item');
                        questions.forEach((q, index) => {
                            q.dataset.index = index + 1;
                            q.querySelector('h4').textContent = `Question #${index + 1}`;
                            const inputs = q.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => {
                                const name = input.name.replace(/questions\[\d+\]/, `questions[${index + 1}]`);
                                input.name = name;
                            });
                        });
                        questionCount = questions.length;
                    });
                });
            });

            document.getElementById('select-all-members').addEventListener('change', function() {
                const checkboxes = document.querySelectorAll('.member-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            const memberCheckboxes = document.querySelectorAll('.member-checkbox');
            const selectAllMembers = document.getElementById('select-all-members');

            function checkSelectAllMembers() {
                const allChecked = Array.from(memberCheckboxes).every(checkbox => checkbox.checked);
                selectAllMembers.checked = allChecked;
            }

            memberCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', checkSelectAllMembers);
            });
        </script>
    </x-slot>
</x-app-layout>