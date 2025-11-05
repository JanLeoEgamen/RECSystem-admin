<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Announcements / Edit
            </h2>
            <a href="{{ route('announcements.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Announcements
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8 md:p-10">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Edit Announcement</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 ml-16">Update announcement details and recipients</p>
                    </div>

                    <form id="updateForm" action="{{ route('announcements.update', $announcement->id) }}" method="post">
                        @csrf
                        
                        <!-- Announcement Details Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Announcement Details</h4>
                            </div>

                            <div class="space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            Title
                                        </span>
                                    </label>
                                    <input value="{{ old('title', $announcement->title) }}" name="title" id="title" placeholder="Enter announcement title" type="text" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                            Content
                                        </span>
                                    </label>
                                    <textarea name="content" id="content" placeholder="Enter announcement content" rows="6"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">{{ old('content', $announcement->content) }}</textarea>
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

                        <!-- Recipients Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Recipients</h4>
                            </div>

                            <div class="space-y-4">
                                <!-- Section Filter Dropdown -->
                                <div>
                                    <label for="section-filter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                            </svg>
                                            Filter by Section
                                        </span>
                                    </label>
                                    <select id="section-filter" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
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
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            Select Members
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <select name="members[]" id="members-select" multiple class="hidden">
                                            @foreach($members as $member)
                                                <option value="{{ $member->id }}" {{ in_array($member->id, old('members', $announcement->members->pluck('id')->toArray())) ? 'selected' : '' }}
                                                    data-section="section-{{ $member->section_id }}">
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="members-dropdown" class="w-full">
                                            <div class="relative">
                                                <input type="text" id="members-search" placeholder="Search members..." 
                                                    class="w-full border-gray-300 shadow-sm rounded-lg pl-10 pr-4 py-3 focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div id="members-options" class="mt-2 max-h-60 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg hidden bg-white dark:bg-gray-700">
                                                <div class="p-3">
                                                    <div class="flex items-center mb-3 pb-3 border-b border-gray-200 dark:border-gray-600">
                                                        <input type="checkbox" id="select-all-members" class="rounded border-gray-300 text-amber-600 focus:ring-amber-500 mr-2">
                                                        <label for="select-all-members" class="text-sm font-medium text-gray-700 dark:text-gray-300">Select All Visible Members</label>
                                                    </div>
                                                    <div class="space-y-2" id="members-options-container">
                                                        @foreach($members as $member)
                                                            <div class="flex items-center member-option hover:bg-gray-50 dark:hover:bg-gray-600 p-2 rounded transition-colors duration-150" 
                                                                 data-value="{{ $member->id }}" 
                                                                 data-section="section-{{ $member->section_id }}">
                                                                <input type="checkbox" id="member-{{ $member->id }}" 
                                                                    value="{{ $member->id }}" class="rounded border-gray-300 text-amber-600 focus:ring-amber-500 mr-2 member-checkbox"
                                                                    {{ in_array($member->id, old('members', $announcement->members->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                                <label for="member-{{ $member->id }}" class="text-sm text-gray-700 dark:text-gray-300 cursor-pointer flex-1">
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
                                            <div id="selected-members" class="mt-3 flex flex-wrap gap-2">
                                                @foreach($members as $member)
                                                    @if(in_array($member->id, old('members', $announcement->members->pluck('id')->toArray())))
                                                        <div class="bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200 text-sm px-3 py-1.5 rounded-lg flex items-center gap-2 shadow-sm" data-value="{{ $member->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            {{ $member->first_name }} {{ $member->last_name }}
                                                            @if($member->section)
                                                                <span class="text-xs text-amber-600 dark:text-amber-300">
                                                                    ({{ $member->section->section_name }})
                                                                </span>
                                                            @endif
                                                            <button type="button" class="ml-1 text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-200 remove-member transition-colors duration-150" data-value="{{ $member->id }}">
                                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
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
                            </div>
                        </div>

                        <!-- Status & Actions Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_published" value="0">
                                    <input type="checkbox" name="is_published" id="is_published" 
                                        class="w-5 h-5 rounded text-blue-600 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 transition-all duration-200" 
                                        value="1" {{ old('is_published', $announcement->is_published) ? 'checked' : '' }}>
                                    <label for="is_published" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Published
                                    </label>
                                </div>

                                <button type="submit" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Announcement
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
                        const isSectionMatch = sectionFilter.value === 'all' || option.dataset.section === sectionFilter.value;
                        option.style.display = label.includes(searchTerm) && isSectionMatch ? 'flex' : 'none';
                    });
                    updateSelectAllState();
                });
                
                // Section filter functionality
                sectionFilter.addEventListener('change', function() {
                    const selectedSection = this.value;
                    const searchTerm = membersSearch.value.toLowerCase();
                    
                    document.querySelectorAll('.member-option').forEach(option => {
                        const label = option.querySelector('label').textContent.toLowerCase();
                        const isSectionMatch = selectedSection === 'all' || option.dataset.section === selectedSection;
                        const isSearchMatch = label.includes(searchTerm);
                        
                        option.style.display = isSectionMatch && isSearchMatch ? 'flex' : 'none';
                    });
                    
                    updateSelectAllState();
                });
                
                // Update selected members and hidden select
                function updateSelectedMembers() {
                    // Clear current selections in hidden select
                    Array.from(membersSelect.options).forEach(option => {
                        option.selected = false;
                    });
                    
                    // Update hidden select with currently selected members
                    document.querySelectorAll('.member-checkbox:checked').forEach(checkbox => {
                        const memberId = checkbox.value;
                        const option = membersSelect.querySelector(`option[value="${memberId}"]`);
                        if (option) option.selected = true;
                    });
                    
                    // Update selected members display
                    const selectedMembersContainer = document.getElementById('selected-members');
                    selectedMembersContainer.innerHTML = '';
                    
                    document.querySelectorAll('.member-checkbox:checked').forEach(checkbox => {
                        const memberId = checkbox.value;
                        const memberName = checkbox.nextElementSibling.textContent.split(' (')[0]; // Remove section from display
                        const sectionInfo = checkbox.closest('.member-option').querySelector('span')?.textContent || '';
                        
                        const badge = document.createElement('div');
                        badge.className = 'bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded flex items-center';
                        badge.innerHTML = `
                            ${memberName} ${sectionInfo}
                            <button type="button" class="ml-1 text-blue-500 hover:text-blue-700 remove-member" data-value="${memberId}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        `;
                        selectedMembersContainer.appendChild(badge);
                    });
                    
                    // Add event listeners to remove buttons
                    document.querySelectorAll('.remove-member').forEach(button => {
                        button.addEventListener('click', function() {
                            const memberId = this.getAttribute('data-value');
                            const checkbox = document.querySelector(`.member-checkbox[value="${memberId}"]`);
                            if (checkbox) {
                                checkbox.checked = false;
                                updateSelectedMembers();
                                updateSelectAllState();
                            }
                        });
                    });
                }
                
                // Update select all checkbox based on visible options
                function updateSelectAllState() {
                    const visibleCheckboxes = document.querySelectorAll('.member-option[style*="flex"] .member-checkbox');
                    const checkedVisibleCheckboxes = document.querySelectorAll('.member-option[style*="flex"] .member-checkbox:checked');
                    
                    selectAll.checked = visibleCheckboxes.length > 0 && 
                                       visibleCheckboxes.length === checkedVisibleCheckboxes.length;
                }
                
                // Handle individual member selection
                memberCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectedMembers();
                        updateSelectAllState();
                    });
                });
                
                // Handle select all functionality (only visible members)
                selectAll.addEventListener('change', () => {
                    const visibleCheckboxes = document.querySelectorAll('.member-option[style*="flex"] .member-checkbox');
                    visibleCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAll.checked;
                    });
                    updateSelectedMembers();
                });

                // Add event listeners to existing remove buttons
                document.querySelectorAll('#selected-members .remove-member').forEach(button => {
                    button.addEventListener('click', function() {
                        const memberId = this.getAttribute('data-value');
                        const checkbox = document.querySelector(`.member-checkbox[value="${memberId}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                            updateSelectedMembers();
                            updateSelectAllState();
                        }
                    });
                });

                document.getElementById("updateForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to update this announcement?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#5e6ffb",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, update it!",
                        cancelButtonText: "Cancel",
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
                        title: "Updated!",
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