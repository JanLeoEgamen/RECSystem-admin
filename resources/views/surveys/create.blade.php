<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Surveys / Create</span>
            </h2>
            <a href="{{ route('surveys.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

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
                    <form id="createForm" action="{{ route('surveys.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input value="{{ old('title') }}" name="title" id="title" placeholder="Enter survey title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="description" class="text-sm font-medium">Description</label>
                            <div class="my-3">    
                                <textarea name="description" id="description" placeholder="Enter survey description" class="border-gray-300 shadow-sm w-full rounded-lg" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="my-3 flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" class="rounded" value="1" {{ old('is_published', false) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2">Publish Immediately</label>
                            </div>

                            <div class="mt-8">
                                <h3 class="text-lg font-medium mb-4">Questions</h3>
                                <div id="questions-container"></div>
                                <button type="button" id="add-question" 
                                    class="mt-4 flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#10b981] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#10b981] border border-white font-medium dark:border-[#3E3E3A] 
                                        dark:hover:bg-black dark:hover:border-[#10b981] rounded-lg text-sm leading-normal transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Question
                                </button>
                            </div>

                            <span class="text-sm font-medium mt-6 block">Assign to Members</span>
                            <div class="my-3">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" id="select-all-members" class="rounded mr-2">
                                    <label for="select-all-members">Select All Members</label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach($members as $member)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="members[]" id="member-{{ $member->id }}" 
                                                value="{{ $member->id }}" class="rounded member-checkbox">
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
                                <button type="submit" 
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                                        dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Survey
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const questionsContainer = document.getElementById('questions-container');
                const addQuestionBtn = document.getElementById('add-question');
                let questionCount = 0;

                addQuestion();

                addQuestionBtn.addEventListener('click', addQuestion);

                function addQuestion() {
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
                        <div class="mb-3">
                            <label class="text-sm font-medium">Question Type</label>
                            <select name="questions[${questionCount}][type]" class="question-type border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                <option value="short-answer">Short Answer</option>
                                <option value="long-answer">Long Answer</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="multiple-choice">Multiple Choice</option>
                            </select>
                        </div>
                        <div class="options-container hidden mb-3">
                            <label class="text-sm font-medium">Options (one per line)</label>
                            <textarea name="questions[${questionCount}][options]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" rows="3"></textarea>
                        </div>
                    `;

                    questionsContainer.appendChild(questionDiv);

                    const typeSelect = questionDiv.querySelector('.question-type');
                    typeSelect.addEventListener('change', function() {
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        if (this.value === 'checkbox' || this.value === 'multiple-choice') {
                            optionsContainer.classList.remove('hidden');
                        } else {
                            optionsContainer.classList.add('hidden');
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
                                input.name = input.name.replace(/questions\[\d+\]/, `questions[${index + 1}]`);
                            });
                        });
                        questionCount = questions.length;
                    });
                }

                document.getElementById('select-all-members').addEventListener('change', function() {
                    const checkboxes = document.querySelectorAll('.member-checkbox');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });

                const memberCheckboxes = document.querySelectorAll('.member-checkbox');
                const selectAllMembers = document.getElementById('select-all-members');
                function checkSelectAllMembers() {
                    selectAllMembers.checked = Array.from(memberCheckboxes).every(checkbox => checkbox.checked);
                }
                memberCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', checkSelectAllMembers);
                });

                document.getElementById("createForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to create this survey?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#5e6ffb",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, create it!",
                        cancelButtonText: "Cancel",
                        background: '#101966',
                        color: '#fff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Creating...',
                                text: 'Please wait',
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                willClose: () => {
                                    e.target.submit();
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
                        title: "Created!",
                        text: "{{ session('success') }}",
                        confirmButtonColor: "#5e6ffb",
                        background: '#101966',
                        color: '#fff'
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "{{ session('error') }}",
                        confirmButtonColor: "#5e6ffb",
                        background: '#101966',
                        color: '#fff'
                    });
                @endif
            });
        </script>
    </x-slot>
</x-app-layout>