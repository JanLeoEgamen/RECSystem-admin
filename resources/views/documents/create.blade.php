<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm p-3 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="font-bold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                    Create Document
                </h2>
            </div>
            <a href="{{ route('documents.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-all duration-200 
                    w-full md:w-auto mt-4 md:mt-0 shadow-lg hover:shadow-xl">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Documents
            </a>                
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form id="createDocumentForm" action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Document Details Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-teal-500 to-emerald-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Document Information</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            Title <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input value="{{ old('title') }}" name="title" id="title" placeholder="Enter document title" type="text" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                            Description
                                        </span>
                                    </label>
                                    <textarea name="description" id="description" placeholder="Enter document description" rows="3"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- File Upload & URL Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="file" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                File Upload
                                            </span>
                                        </label>
                                        <input type="file" name="file" id="file" 
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                                        @error('file')
                                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            PDF, Word, JPEG, PNG, GIF (Max: 2MB)
                                        </p>
                                    </div>
                                    <div>
                                        <label for="url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                                OR External URL
                                            </span>
                                        </label>
                                        <input value="{{ old('url') }}" name="url" id="url" placeholder="https://example.com/document.pdf" type="url" 
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
                                        @error('url')
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
                        </div>

                        <!-- Recipients Card -->
                        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Recipients</h3>
                            </div>

                            <div class="space-y-4">
                                <!-- Section Filter -->
                                <div>
                                    <label for="section-filter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                            </svg>
                                            Filter by Section
                                        </span>
                                    </label>
                                    <select id="section-filter" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
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
                                    <select name="members[]" id="members-select" multiple class="hidden">
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ in_array($member->id, old('members', [])) ? 'selected' : '' }}
                                                data-section="section-{{ $member->section_id }}">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                    <div id="members-dropdown" class="w-full">
                                        <label for="members-search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                                Search Members
                                            </span>
                                        </label>
                                        <div class="relative">
                                            <input type="text" id="members-search" placeholder="Type to search members..." 
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 pl-10 pr-4">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <div id="members-options" class="mt-2 max-h-80 overflow-y-auto border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700/50 hidden">
                                            <div class="p-4">
                                                <div class="flex items-center mb-3 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                                    <input type="checkbox" id="select-all" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="select-all" class="ml-3 text-sm font-semibold text-gray-900 dark:text-gray-100">Select All Visible Members</label>
                                                </div>
                                                <div class="space-y-2" id="members-options-container">
                                                    @foreach($members as $member)
                                                        <div class="flex items-center member-option p-2 hover:bg-white dark:hover:bg-gray-700 rounded-md transition-colors duration-150" 
                                                            data-value="{{ $member->id }}" 
                                                            data-section="section-{{ $member->section_id }}">
                                                            <input type="checkbox" id="member-{{ $member->id }}" 
                                                                value="{{ $member->id }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 member-checkbox"
                                                                {{ in_array($member->id, old('members', [])) ? 'checked' : '' }}>
                                                            <label for="member-{{ $member->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300 cursor-pointer">
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

                            <div class="flex items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', false) ? 'checked' : '' }}
                                    class="w-5 h-5 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="is_published" class="ml-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    Publish document immediately
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" 
                                class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-teal-500 to-emerald-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-teal-300 dark:focus:ring-teal-800 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Create Document
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
                const selectAll = document.getElementById('select-all');
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

                document.getElementById('createDocumentForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to create this document?",
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