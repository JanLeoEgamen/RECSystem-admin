<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </div>
                <h2 class="font-bold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                    Create Announcement
                </h2>
            </div>

            <a href="{{ route('announcements.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-all duration-200 
                    w-full md:w-auto mt-4 md:mt-0 text-center shadow-lg hover:shadow-xl">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Announcements
            </a>                
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form id="createForm" action="{{ route('announcements.store') }}" method="post">
                        @csrf
                        
                        <!-- Announcement Content Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Announcement Content</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            Title <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input 
                                        value="{{ old('title') }}" 
                                        name="title" 
                                        id="title" 
                                        placeholder="Enter announcement title" 
                                        type="text" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div>
                                    <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Content <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <textarea 
                                        name="content" 
                                        id="content" 
                                        placeholder="Enter announcement content" 
                                        rows="6"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">{{ old('content') }}</textarea>
                                    @error('content')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Assign Members Card -->
                        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Assign to Members</h3>
                            </div>

                            <!-- Section Filter -->
                            <div class="mb-4">
                                <label for="section-filter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                        </svg>
                                        Filter by Section
                                    </span>
                                </label>
                                <select id="section-filter" class="block w-full md:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
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

                            <!-- Members Selection -->
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
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 pl-10 pr-4 py-3">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div id="members-options" class="mt-2 max-h-60 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg hidden bg-white dark:bg-gray-700">
                                        <div class="p-3">
                                            <div class="flex items-center mb-3 pb-3 border-b border-gray-200 dark:border-gray-600">
                                                <input type="checkbox" id="select-all-members" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                                <label for="select-all-members" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">Select All Members</label>
                                            </div>
                                            <div class="space-y-2" id="members-options-container">
                                                @foreach($members as $member)
                                                    <div class="flex items-center member-option hover:bg-gray-50 dark:hover:bg-gray-600 p-2 rounded transition-colors" 
                                                        data-value="{{ $member->id }}" 
                                                        data-section="section-{{ $member->section_id }}">
                                                        <input type="checkbox" id="member-{{ $member->id }}" 
                                                            value="{{ $member->id }}" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer member-checkbox"
                                                            {{ in_array($member->id, old('members', [])) ? 'checked' : '' }}>
                                                        <label for="member-{{ $member->id }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer flex-1">
                                                            {{ $member->first_name }} {{ $member->last_name }}
                                                            @if($member->section)
                                                                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">
                                                                    ({{ $member->section->section_name }})
                                                                </span>
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div id="selected-members" class="mt-3 flex flex-wrap gap-2"></div>
                                </div>
                            </div>
                            @error('members')
                                <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Publishing Settings Card -->
                        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Publishing Settings</h3>
                            </div>

                            <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" class="h-5 w-5 rounded border-gray-300 text-green-600 focus:ring-2 focus:ring-green-500 cursor-pointer" value="1" {{ old('is_published', false) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-3 cursor-pointer">
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                        Publish Immediately
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-7">Check to send notifications to selected members right away</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-8 py-4 text-white bg-gradient-to-r from-[#101966] to-indigo-700 hover:from-white hover:to-gray-50 hover:text-[#101966] 
                                border-2 border-[#101966] hover:border-[#101966] rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105
                                dark:from-gray-900 dark:to-gray-800 dark:text-white dark:border-gray-100 
                                dark:hover:from-gray-700 dark:hover:to-gray-600 dark:hover:text-white dark:hover:border-gray-100">
                                    
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Announcement
                            </button>
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
                // Members dropdown functionality
                const membersSelect = document.getElementById('members-select');
                const membersSearch = document.getElementById('members-search');
                const membersOptions = document.getElementById('members-options');
                const selectedMembers = document.getElementById('selected-members');
                const selectAll = document.getElementById('select-all-members');
                const memberCheckboxes = document.querySelectorAll('.member-checkbox');
                
                // Initialize selected members display
                updateSelectedMembers();
                
                // Section filter functionality
                const sectionFilter = document.getElementById('section-filter');
                
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

                document.getElementById("createForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to create this announcement?",
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