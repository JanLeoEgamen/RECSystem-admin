<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Quizzes / Create
            </h2>
            <a href="{{ route('quizzes.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200">
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
                    <form id="createForm" action="{{ route('quizzes.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input value="{{ old('title') }}" name="title" id="title" placeholder="Enter quiz title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="description" class="text-sm font-medium">Description</label>
                            <div class="my-3">    
                                <textarea name="description" id="description" placeholder="Enter quiz description" class="border-gray-300 shadow-sm w-full rounded-lg" rows="3">{{ old('description') }}</textarea>
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
                                    class="mt-4 flex items-center px-4 py-2 text-sm text-green-600 
                                    hover:text-white hover:bg-green-600 rounded-md transition-colors 
                                    duration-200 border border-green-100 hover:border-green-600 font-medium
                                    dark:bg-gray-900 dark:text-white dark:border-gray-100 dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Question
                                </button>
                            </div>

                            <span class="text-sm font-medium mt-6 block">Assign to Members</span>
                            <div class="my-3">
                                <div class="relative">
                                    <select name="members[]" id="members-select" multiple class="hidden">
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ in_array($member->id, old('members', [])) ? 'selected' : '' }}>
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="members-dropdown" class="w-full mt-1">
                                        <div class="relative">
                                            <input type="text" id="members-search" placeholder="Search members..." 
                                                class="w-full border-gray-300 shadow-sm rounded-lg pl-10 pr-4 py-2">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div id="members-options" class="mt-1 max-h-60 overflow-y-auto border border-gray-300 rounded-lg hidden">
                                            <div class="p-2">
                                                <div class="flex items-center mb-2">
                                                    <input type="checkbox" id="select-all-members" class="rounded mr-2">
                                                    <label for="select-all-members" class="text-sm">Select All Members</label>
                                                </div>
                                                <div class="space-y-1">
                                                    @foreach($members as $member)
                                                        <div class="flex items-center member-option" data-value="{{ $member->id }}">
                                                            <input type="checkbox" id="member-{{ $member->id }}" 
                                                                value="{{ $member->id }}" class="rounded mr-2 member-checkbox">
                                                            <label for="member-{{ $member->id }}" class="text-sm">
                                                                {{ $member->first_name }} {{ $member->last_name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div id="selected-members" class="mt-2 flex flex-wrap gap-2"></div>
                                    </div>
                                </div>
                                @error('members')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Quiz
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

                function addQuestion() {
                    questionCount++;
                    const div = document.createElement('div');
                    div.className = 'question-item mb-6 p-4 border rounded-lg';
                    div.dataset.index = questionCount;

                    const questionId = `question-${questionCount}`;
                    const typeId = `type-${questionCount}`;
                    const pointsId = `points-${questionCount}`;
                    const optionsId = `options-${questionCount}`;

                    div.innerHTML = `
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-medium">Question #${questionCount}</h4>
                            <button type="button" class="remove-question text-red-500 hover:text-red-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="${questionId}" class="text-sm font-medium">Question Text</label>
                            <input type="text" id="${questionId}" name="questions[${questionCount}][question]" placeholder="Enter question" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                        </div>

                        <div class="mb-3">
                            <label for="${typeId}" class="text-sm font-medium">Question Type</label>
                            <select id="${typeId}" name="questions[${questionCount}][type]" class="question-type border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                <option value="identification">Identification</option>
                                <option value="true-false">True or False</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="multiple-choice">Multiple Choice</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="${pointsId}" class="text-sm font-medium">Points</label>
                            <input type="number" id="${pointsId}" name="questions[${questionCount}][points]" min="0" step="0.01" value="1.00" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                        </div>

                        <div class="options-container hidden mb-3">
                            <label for="${optionsId}" class="text-sm font-medium">Options (one per line)</label>
                            <textarea id="${optionsId}" name="questions[${questionCount}][options]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" rows="3"></textarea>
                        </div>

                        <div class="correct-answers-container hidden mb-3">
                            <span class="text-sm font-medium">Correct Answer(s)</span>
                            <div class="correct-answers-inputs"></div>
                        </div>
                    `;

                    questionsContainer.appendChild(div);

                    const typeSelect = div.querySelector('.question-type');
                    const optionsTextarea = div.querySelector('textarea[name^="questions"]');
                    const correctContainer = div.querySelector('.correct-answers-container');
                    const correctInputs = div.querySelector('.correct-answers-inputs');

                    typeSelect.addEventListener('change', function() {
                        const type = this.value;
                        if(type === 'checkbox' || type === 'multiple-choice') {
                            div.querySelector('.options-container').classList.remove('hidden');
                            correctContainer.classList.remove('hidden');
                        } else {
                            div.querySelector('.options-container').classList.add('hidden');
                            correctContainer.classList.remove('hidden');
                            correctInputs.innerHTML = type === 'true-false' 
                                ? `<select name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>`
                                : `<input type="text" name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>`;
                        }
                    });

                    typeSelect.dispatchEvent(new Event('change'));

                    optionsTextarea.addEventListener('input', function() {
                        const options = this.value.split('\n').filter(o => o.trim() !== '');
                        if(typeSelect.value === 'multiple-choice') {
                            correctInputs.innerHTML = `<select name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                <option value="">Select correct answer</option>
                            </select>`;
                            const select = correctInputs.querySelector('select');
                            options.forEach(opt => {
                                const optionEl = document.createElement('option');
                                optionEl.value = opt;
                                optionEl.textContent = opt;
                                select.appendChild(optionEl);
                            });
                        } else if(typeSelect.value === 'checkbox') {
                            correctInputs.innerHTML = '';
                            options.forEach((opt, idx) => {
                                const optionId = `q${questionCount}-correct-${idx}`;
                                correctInputs.innerHTML += `
                                    <div class="flex items-center mt-2">
                                        <input type="checkbox" name="questions[${questionCount}][correct_answers][]" id="${optionId}" value="${opt}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="${optionId}" class="ml-2 text-sm">${opt}</label>
                                    </div>`;
                            });
                        }
                    });

                    div.querySelector('.remove-question').addEventListener('click', function() {
                        div.remove();
                        const remaining = questionsContainer.querySelectorAll('.question-item');
                        remaining.forEach((q, idx) => {
                            q.dataset.index = idx + 1;
                            q.querySelector('h4').textContent = `Question #${idx + 1}`;
                            const inputs = q.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => input.name = input.name.replace(/questions\[\d+\]/, `questions[${idx + 1}]`));
                        });
                        questionCount = remaining.length;
                    });
                }

                addQuestion();
                addQuestionBtn.addEventListener('click', addQuestion);

                // Members dropdown functionality
                const membersSelect = document.getElementById('members-select');
                const membersSearch = document.getElementById('members-search');
                const membersOptions = document.getElementById('members-options');
                const selectedMembers = document.getElementById('selected-members');
                const selectAll = document.getElementById('select-all-members');
                const memberCheckboxes = document.querySelectorAll('.member-checkbox');
                
                // Toggle dropdown on search input focus
                membersSearch.addEventListener('focus', () => {
                    membersOptions.classList.remove('hidden');
                });
                
                // Hide dropdown when clicking outside
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('#members-dropdown')) {
                        membersOptions.classList.add('hidden');
                    }
                });
                
                // Filter members based on search input
                membersSearch.addEventListener('input', () => {
                    const searchTerm = membersSearch.value.toLowerCase();
                    document.querySelectorAll('.member-option').forEach(option => {
                        const label = option.querySelector('label').textContent.toLowerCase();
                        option.style.display = label.includes(searchTerm) ? 'flex' : 'none';
                    });
                });
                
                // Update selected members and hidden select
                function updateSelectedMembers() {
                    // Clear current selections
                    selectedMembers.innerHTML = '';
                    Array.from(membersSelect.options).forEach(option => {
                        option.selected = false;
                    });
                    
                    // Add selected members
                    document.querySelectorAll('.member-checkbox:checked').forEach(checkbox => {
                        const memberId = checkbox.value;
                        const memberName = checkbox.nextElementSibling.textContent;
                        
                        // Update hidden select
                        const option = membersSelect.querySelector(`option[value="${memberId}"]`);
                        if (option) option.selected = true;
                        
                        // Add to selected members display
                        const badge = document.createElement('div');
                        badge.className = 'bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded flex items-center';
                        badge.innerHTML = `
                            ${memberName}
                            <button type="button" class="ml-1 text-blue-500 hover:text-blue-700" data-value="${memberId}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        `;
                        selectedMembers.appendChild(badge);
                        
                        // Add event to remove button
                        badge.querySelector('button').addEventListener('click', (e) => {
                            e.stopPropagation();
                            const checkboxToUncheck = document.querySelector(`.member-checkbox[value="${memberId}"]`);
                            if (checkboxToUncheck) {
                                checkboxToUncheck.checked = false;
                                updateSelectedMembers();
                            }
                        });
                    });
                    
                    // Update select all checkbox
                    selectAll.checked = document.querySelectorAll('.member-checkbox:checked').length === memberCheckboxes.length;
                }
                
                // Initialize selected members
                updateSelectedMembers();
                
                // Handle individual member selection
                memberCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedMembers);
                });
                
                // Handle select all functionality
                selectAll.addEventListener('change', () => {
                    memberCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAll.checked;
                    });
                    updateSelectedMembers();
                });

                document.getElementById("createForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to create this quiz?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#5e6ffb",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, create it!",
                        cancelButtonText: "Cancel",
                        background: '#101966',
                        color: '#fff'
                    }).then((result) => {
                        if(result.isConfirmed){
                            Swal.fire({
                                title: 'Creating...',
                                text: 'Please wait',
                                timer: 1500,
                                timerProgressBar: true,
                                didOpen: () => Swal.showLoading(),
                                willClose: () => e.target.submit(),
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