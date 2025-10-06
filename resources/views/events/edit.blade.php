<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Events / Edit
            </h2>
            <a href="{{ route('events.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Events
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="updateForm" action="{{ route('events.update', $event->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium">Title</label>
                                <div class="mt-1">
                                    <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium">Description</label>
                                <div class="mt-1">
                                    <textarea name="description" id="description" rows="3" 
                                              class="block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $event->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Date and Time -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium">Start Date & Time</label>
                                    <div class="mt-1">
                                        <input type="datetime-local" name="start_date" id="start_date" 
                                               value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('start_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium">End Date & Time</label>
                                    <div class="mt-1">
                                        <input type="datetime-local" name="end_date" id="end_date" 
                                               value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('end_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Location and Capacity -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="location" class="block text-sm font-medium">Location</label>
                                    <div class="mt-1">
                                        <input type="text" name="location" id="location" 
                                               value="{{ old('location', $event->location) }}" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm" required>
                                        @error('location')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="capacity" class="block text-sm font-medium">Capacity (optional)</label>
                                    <div class="mt-1">
                                        <input type="number" name="capacity" id="capacity" 
                                               value="{{ old('capacity', $event->capacity) }}" min="1" 
                                               class="block w-full rounded-md border-gray-300 shadow-sm">
                                        @error('capacity')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Members -->
                            <div>
                                <span class="text-sm font-medium mt-6 block">Recipients</span>

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
                                                <option value="{{ $member->id }}" {{ in_array($member->id, old('members', $event->members->pluck('id')->toArray())) ? 'selected' : '' }}
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
                                                                    {{ in_array($member->id, old('members', $event->members->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                            <div id="selected-members" class="mt-2 flex flex-wrap gap-2">
                                                @foreach($members as $member)
                                                    @if(in_array($member->id, old('members', $event->members->pluck('id')->toArray())))
                                                        <div class="bg-blue-100 text-blue-800 text-sm px-2 py-1 rounded flex items-center" data-value="{{ $member->id }}">
                                                            {{ $member->first_name }} {{ $member->last_name }}
                                                            @if($member->section)
                                                                <span class="text-xs text-blue-600 ml-1">
                                                                    ({{ $member->section->section_name }})
                                                                </span>
                                                            @endif
                                                            <button type="button" class="ml-1 text-blue-500 hover:text-blue-700 remove-member" data-value="{{ $member->id }}">
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
                                    <p class="text-red-400 font-medium"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Publish Status -->
                            <div class="flex items-center">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" name="is_published" id="is_published" 
                                       class="rounded" value="1" {{ old('is_published', $event->is_published) ? 'checked' : '' }}>
                                <label for="is_published" class="ml-2 text-sm font-medium">Published</label>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit" 
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                        
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Event
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
                        text: "Do you want to update this event?",
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