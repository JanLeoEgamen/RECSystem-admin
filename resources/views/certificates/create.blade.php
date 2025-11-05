<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Certificate Templates / Create
            </h2>
            <a href="{{ route('certificates.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-semibold dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-all duration-200 
                    w-full md:w-auto hover:shadow-lg">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Certificates
            </a>                
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8 bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl p-6 md:p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-600 p-4 rounded-xl backdrop-blur-sm shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Create Certificate Template</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Design and configure a new certificate template</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form id="createCertificateForm" action="{{ route('certificates.store') }}" method="post">
                        @csrf
                        
                        <!-- Certificate Details Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-amber-500 to-yellow-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Certificate Details</h3>
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
                                        value="{{ old('title', $certificate->title ?? '') }}" 
                                        name="title" 
                                        id="title" 
                                        placeholder="Enter certificate title (max 5 words)" 
                                        type="text" 
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                        oninput="validateWordCount(this)"
                                    >
                                    <div class="flex items-center justify-between mt-2">
                                        <p id="word-count" class="text-sm text-gray-500 dark:text-gray-400">Words: 0/5</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Maximum 5 words allowed
                                        </p>
                                    </div>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                            Content <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <textarea id="content" name="content" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200">{{ old('content') }}</textarea>
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

                        <!-- Signatories Card -->
                        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Signatories</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maximum 2 signatories allowed</p>
                                </div>
                            </div>

                            <div id="signatories-container" class="space-y-4">
                                <div class="signatory-row bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 rounded-lg p-4 border border-violet-200 dark:border-violet-700">
                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center justify-center w-8 h-8 bg-violet-500 text-white font-bold rounded-full text-sm flex-shrink-0">1</span>
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <input type="text" name="signatories[0][name]" placeholder="Signatory Name" 
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3" required>
                                            <input type="text" name="signatories[0][position]" placeholder="Position/Title" 
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                                        </div>
                                        <button type="button" class="remove-signatory flex items-center justify-center w-10 h-10 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-200 hover:scale-105 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="add-signatory" 
                                class="mt-4 inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg hover:scale-105 focus:outline-none focus:ring-4 focus:ring-violet-300 dark:focus:ring-violet-800 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Signatory
                            </button>
                        </div>

                        <!-- Assign to Members Card -->
                        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Assign to Members</h3>
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
                                                    <input type="checkbox" id="select-all-members" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                    <label for="select-all-members" class="ml-3 text-sm font-semibold text-gray-900 dark:text-gray-100">Select All Visible Members</label>
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

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="button" id="createCertificateButton"
                                class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-amber-500 to-yellow-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-amber-300 dark:focus:ring-amber-800 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    <div class="signatory-row bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 rounded-lg p-4 border border-violet-200 dark:border-violet-700">
                        <div class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 bg-violet-500 text-white font-bold rounded-full text-sm flex-shrink-0">${signatoryCount + 1}</span>
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                <input type="text" name="signatories[${signatoryCount}][name]" placeholder="Signatory Name" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3" required>
                                <input type="text" name="signatories[${signatoryCount}][position]" placeholder="Position/Title" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2 px-3">
                            </div>
                            <button type="button" class="remove-signatory flex items-center justify-center w-10 h-10 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-all duration-200 hover:scale-105 flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
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
                    // Update numbering
                    $('.signatory-row').each(function(index) {
                        $(this).find('span').first().text(index + 1);
                    });
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