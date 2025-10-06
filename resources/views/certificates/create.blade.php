<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Certificate Templates / Create
            </h2>
            <a href="{{ route('certificates.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Certificates
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="createCertificateForm" action="{{ route('certificates.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input 
                                    value="{{ old('title', $certificate->title ?? '') }}" 
                                    name="title" 
                                    id="title" 
                                    placeholder="Enter certificate title (max 5 words)" 
                                    type="text" 
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg"
                                    oninput="validateWordCount(this)"
                                >
                                <p id="word-count" class="text-sm text-gray-500 mt-1">Words: 0/5</p>
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <span class="text-sm font-medium">Content</span>
                            <div class="my-3">    
                                <textarea id="content" name="content" class="border-gray-300 shadow-sm w-full rounded-lg">{{ old('content') }}</textarea>
                                @error('content')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <span class="text-sm font-medium">Signatories</span>
                            <div class="my-3" id="signatories-container">
                                <div class="signatory-row flex items-center space-x-4 mb-2">
                                    <input type="text" name="signatories[0][name]" placeholder="Name" class="border-gray-300 shadow-sm rounded-lg w-1/3" required>
                                    <input type="text" name="signatories[0][position]" placeholder="Position" class="border-gray-300 shadow-sm rounded-lg w-1/3">
                                    <button type="button" class="remove-signatory text-red-600 hover:text-red-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-signatory" 
                                class="mt-4 flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                    bg-[#10b981] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-[#10b981] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-sm leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Signatory
                            </button>

                            <span class="text-sm font-medium mt-6 block">Assign to Members</span>

                            <!-- Add Section Filter Dropdown -->
                            <div class="my-3">
                                <label for="section-filter" class="block text-sm font-medium mb-2">Filter by Section:</label>
                                <select id="section-filter" class="border-gray-300 shadow-sm rounded-lg w-full md:w-1/3">
                                    <option value="all">All Sections</option>
                                    @foreach($sections as $section)
                                        <option value="section-{{ $section->id }}">
                                            {{ $section->section_name }} 
                                            @if($section->bureau)
                                                ({{ $section->bureau->bureau_name }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="my-3">
                                <div class="relative">
                                    <select name="members[]" id="members-select" multiple class="hidden">
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ in_array($member->id, old('members', [])) ? 'selected' : '' }}
                                                data-section="section-{{ $member->section_id }}">
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
                                                    <label for="select-all-members" class="text-sm">Select All Visible Members</label>
                                                </div>
                                                <div class="space-y-1" id="members-options-container">
                                                    @foreach($members as $member)
                                                        <div class="flex items-center member-option" 
                                                            data-value="{{ $member->id }}" 
                                                            data-section="section-{{ $member->section_id }}">
                                                            <input type="checkbox" id="member-{{ $member->id }}" 
                                                                value="{{ $member->id }}" class="rounded mr-2 member-checkbox"
                                                                {{ in_array($member->id, old('members', [])) ? 'checked' : '' }}>
                                                            <label for="member-{{ $member->id }}" class="text-sm">
                                                                {{ $member->first_name }} {{ $member->last_name }}
                                                                @if($member->section)
                                                                    <span class="text-xs text-gray-500 ml-2">
                                                                        ({{ $member->section->section_name }})
                                                                    </span>
                                                                @endif
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
                                <button type="button" id="createCertificateButton"
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Certificate Template
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
        </style>
        <script>
            CKEDITOR.replace('content');

            let signatoryCount = 1;
            const MAX_SIGNATORIES = 2;

            $('#add-signatory').click(function() {
                const currentCount = $('.signatory-row').length;
                
                if (currentCount >= MAX_SIGNATORIES) {
                    Swal.fire({
                        icon: "warning",
                        title: "Maximum Reached",
                        text: `You can only add up to ${MAX_SIGNATORIES} signatories.`,
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                const newRow = `
                    <div class="signatory-row flex items-center space-x-4 mb-2">
                        <input type="text" name="signatories[${signatoryCount}][name]" placeholder="Name" class="border-gray-300 shadow-sm rounded-lg w-1/3" required>
                        <input type="text" name="signatories[${signatoryCount}][position]" placeholder="Position" class="border-gray-300 shadow-sm rounded-lg w-1/3">
                        <button type="button" class="remove-signatory text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                `;
                $('#signatories-container').append(newRow);
                signatoryCount++;
                
                // Hide add button if max reached
                if ($('.signatory-row').length >= MAX_SIGNATORIES) {
                    $('#add-signatory').hide();
                }
            });

            $(document).on('click', '.remove-signatory', function() {
                if ($('.signatory-row').length > 1) {
                    $(this).closest('.signatory-row').remove();
                    // Show add button if below max
                    if ($('.signatory-row').length < MAX_SIGNATORIES) {
                        $('#add-signatory').show();
                    }
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Cannot Remove",
                        text: "At least one signatory is required.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                }
            });

            // Members dropdown functionality
            const membersSelect = document.getElementById('members-select');
            const membersSearch = document.getElementById('members-search');
            const membersOptions = document.getElementById('members-options');
            const selectedMembers = document.getElementById('selected-members');
            const selectAll = document.getElementById('select-all-members');
            const memberCheckboxes = document.querySelectorAll('.member-checkbox');
            const sectionFilter = document.getElementById('section-filter');
            
            // Initialize selected members display
            updateSelectedMembers();
            
            // Section filter functionality
            sectionFilter.addEventListener('change', function() {
                const selectedSection = this.value;
                const memberOptions = document.querySelectorAll('.member-option');
                
                memberOptions.forEach(option => {
                    if (selectedSection === 'all' || option.dataset.section === selectedSection) {
                        option.style.display = 'flex';
                    } else {
                        option.style.display = 'none';
                    }
                });
                
                // Update select all checkbox state for visible options
                updateSelectAllState();
            });

            // Update select all checkbox based on visible options
            function updateSelectAllState() {
                const visibleCheckboxes = document.querySelectorAll('.member-option[style*="flex"] .member-checkbox');
                const checkedVisibleCheckboxes = document.querySelectorAll('.member-option[style*="flex"] .member-checkbox:checked');
                
                selectAll.checked = visibleCheckboxes.length > 0 && 
                                visibleCheckboxes.length === checkedVisibleCheckboxes.length;
            }

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
                
                setTimeout(updateSelectAllState, 100);
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
            
            // Handle individual member selection
            memberCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedMembers();
                    updateSelectAllState();
                });
            });

            
            // Handle select all functionality
            selectAll.addEventListener('change', () => {
                const visibleCheckboxes = document.querySelectorAll('.member-option[style*="flex"] .member-checkbox');
                visibleCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                updateSelectedMembers();
            });

            $('#createCertificateButton').click(function(e) {
                e.preventDefault();

                for (let instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                const title = $('input[name="title"]').val().trim();
                const content = CKEDITOR.instances.content.getData().trim();
                
                if (!title) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Title",
                        text: "Please provide a certificate title.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                if (!content) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Content",
                        text: "Please provide certificate content.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                let hasValidSignatory = false;
                $('.signatory-row input[name*="[name]"]').each(function() {
                    if ($(this).val().trim()) {
                        hasValidSignatory = true;
                        return false; 
                    }
                });

                if (!hasValidSignatory) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Signatory",
                        text: "Please provide at least one signatory name.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                // Validate signatory count
                const signatoryCount = $('.signatory-row').length;
                if (signatoryCount > MAX_SIGNATORIES) {
                    Swal.fire({
                        icon: "warning",
                        title: "Too Many Signatories",
                        text: `You can only have up to ${MAX_SIGNATORIES} signatories.`,
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Create Certificate Template?',
                    text: "Are you sure you want to create this certificate template?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5e6ffb',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, create it!',
                    cancelButtonText: 'Cancel',
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
                                document.getElementById('createCertificateForm').submit();
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
                    confirmButtonColor: "#5e6ffb",
                    background: '#101966',
                    color: '#fff'
                });
            @endif

            function validateWordCount(input) {
                const text = input.value.trim();
                const wordCount = text === '' ? 0 : text.split(/\s+/).length;
                const wordCountElement = document.getElementById('word-count');
                
                wordCountElement.textContent = `Words: ${wordCount}/5`;
                
                if (wordCount > 5) {
                    wordCountElement.classList.add('text-red-500');
                    wordCountElement.classList.remove('text-gray-500');
                } else {
                    wordCountElement.classList.remove('text-red-500');
                    wordCountElement.classList.add('text-gray-500');
                }
                
                // Optional: Prevent typing beyond 5 words
                if (wordCount > 5) {
                    const words = text.split(/\s+/).slice(0, 5);
                    input.value = words.join(' ');
                    // Recalculate after truncation
                    validateWordCount(input);
                }
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                const titleInput = document.getElementById('title');
                if (titleInput) {
                    // Trigger validation for pre-populated value
                    validateWordCount(titleInput);
                    
                    // Also validate on form submit
                    const form = titleInput.closest('form');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            const currentWordCount = titleInput.value.trim().split(/\s+/).length;
                            if (currentWordCount > 5) {
                                e.preventDefault();
                                alert('Title cannot exceed 5 words. Please shorten your title.');
                                titleInput.focus();
                            }
                        });
                    }
                }
            });
        </script>
    </x-slot>
</x-app-layout>