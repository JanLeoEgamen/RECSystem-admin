<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-3xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Certificate Templates / Edit
            </h2>

            <a href="{{ route('certificates.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto text-center">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Certificates
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header with Icon -->
            <div class="mb-8 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-lg p-6">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-3 rounded-xl shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Certificate Template</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update certificate details, content, and signatories</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('certificates.update', $certificate->id) }}" method="post" id="updateCertificateForm">
                @csrf
                @method('PUT')

                <!-- Certificate Details Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Certificate Details</h4>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label for="title" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Certificate Title
                                </label>
                                <input 
                                    value="{{ old('title', $certificate->title ?? 'Sample Certificate Title') }}" 
                                    name="title" 
                                    id="title" 
                                    placeholder="Enter certificate title (max 5 words)" 
                                    type="text" 
                                    class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-violet-500 focus:ring-2 focus:ring-violet-500 focus:ring-opacity-50 transition-all duration-200"
                                    oninput="validateWordCount(this)"
                                >
                                <p id="word-count" class="text-sm text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Words: 0/5
                                </p>
                            </div>

                            <div>
                                <label for="content" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    Certificate Content
                                </label>
                                <textarea id="content" name="content" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-violet-500 focus:ring-2 focus:ring-violet-500 focus:ring-opacity-50">{{ old('content', $certificate->content) }}</textarea>
                                @error('content')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signatories Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Signatories</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Maximum of 2 signatories allowed</p>
                            </div>
                        </div>

                        <div id="signatories-container" class="space-y-3">
                            @foreach($certificate->signatories as $index => $signatory)
                            <div class="signatory-row bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 p-4 rounded-lg border-2 border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold px-3 py-1.5 rounded-lg text-sm">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label class="flex items-center gap-1 text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Name
                                            </label>
                                            <input type="text" name="signatories[{{ $index }}][name]" placeholder="Enter signatory name" 
                                                value="{{ old("signatories.$index.name", $signatory->name) }}" 
                                                class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="flex items-center gap-1 text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                Position
                                            </label>
                                            <input type="text" name="signatories[{{ $index }}][position]" placeholder="Enter position/title" 
                                                value="{{ old("signatories.$index.position", $signatory->position) }}" 
                                                class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm">
                                        </div>
                                    </div>
                                    <button type="button" class="remove-signatory bg-red-100 hover:bg-red-600 text-red-600 hover:text-white p-2 rounded-lg transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-signatory" 
                            class="mt-4 flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Signatory
                        </button>
                    </div>
                </div>

                <!-- Members Assignment Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Assign to Members</h4>
                        </div>

                        <div class="space-y-4">
                            <!-- Section Filter -->
                            <div>
                                <label for="section-filter" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Filter by Section
                                </label>
                                <select id="section-filter" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-amber-500 focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
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
                                <div class="relative">
                                    <select name="members[]" id="members-select" multiple class="hidden">
                                        @foreach($members as $member)
                                            <option value="{{ $member->id }}" {{ in_array($member->id, old('members', $certificate->members->pluck('id')->toArray())) ? 'selected' : '' }}
                                                data-section="section-{{ $member->section_id }}">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div id="members-dropdown" class="w-full">
                                        <div class="relative">
                                            <input type="text" id="members-search" placeholder="Search members..." 
                                                class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg pl-10 pr-4 py-2.5 focus:border-amber-500 focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div id="members-options" class="mt-2 max-h-60 overflow-y-auto border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-lg hidden shadow-sm">
                                            <div class="p-3">
                                                <div class="flex items-center mb-3 pb-3 border-b border-gray-200 dark:border-gray-600">
                                                    <input type="checkbox" id="select-all-members" class="h-4 w-4 text-amber-600 rounded focus:ring-2 focus:ring-amber-500 mr-2">
                                                    <label for="select-all-members" class="text-sm font-medium text-gray-700 dark:text-gray-300">Select All Visible Members</label>
                                                </div>
                                                <div class="space-y-2" id="members-options-container">
                                                    @foreach($members as $member)
                                                        <div class="flex items-center member-option hover:bg-gray-50 dark:hover:bg-gray-600 p-2 rounded transition-colors duration-150" 
                                                             data-value="{{ $member->id }}" 
                                                             data-section="section-{{ $member->section_id }}">
                                                            <input type="checkbox" id="member-{{ $member->id }}" 
                                                                value="{{ $member->id }}" class="h-4 w-4 text-amber-600 rounded focus:ring-2 focus:ring-amber-500 mr-2 member-checkbox"
                                                                {{ in_array($member->id, old('members', $certificate->members->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                                @if(in_array($member->id, old('members', $certificate->members->pluck('id')->toArray())))
                                                    <div class="bg-amber-100 dark:bg-amber-900 text-amber-800 dark:text-amber-200 text-sm px-3 py-1.5 rounded-lg flex items-center gap-2 shadow-sm" data-value="{{ $member->id }}">
                                                        <span>{{ $member->first_name }} {{ $member->last_name }}</span>
                                                        @if($member->section)
                                                            <span class="text-xs text-amber-600 dark:text-amber-300">
                                                                ({{ $member->section->section_name }})
                                                            </span>
                                                        @endif
                                                        <button type="button" class="ml-1 text-amber-600 dark:text-amber-300 hover:text-amber-800 dark:hover:text-amber-100 remove-member transition-colors duration-150" data-value="{{ $member->id }}">
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
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                    <div class="p-6">
                        <button type="button" id="updateCertificateButton"
                            class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="text-lg">Update Certificate Template</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            CKEDITOR.replace('content');

            let signatoryCount = {{ count($certificate->signatories) }};
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
                    <div class="signatory-row bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 p-4 rounded-lg border-2 border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold px-3 py-1.5 rounded-lg text-sm">
                                ${signatoryCount + 1}
                            </div>
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="flex items-center gap-1 text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Name
                                    </label>
                                    <input type="text" name="signatories[${signatoryCount}][name]" placeholder="Enter signatory name" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm" required>
                                </div>
                                <div>
                                    <label class="flex items-center gap-1 text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">
                                        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Position
                                    </label>
                                    <input type="text" name="signatories[${signatoryCount}][position]" placeholder="Enter position/title" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 text-sm">
                                </div>
                            </div>
                            <button type="button" class="remove-signatory bg-red-100 hover:bg-red-600 text-red-600 hover:text-white p-2 rounded-lg transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                $('#signatories-container').append(newRow);
                signatoryCount++;
                
                // Update badge numbers
                $('.signatory-row').each(function(index) {
                    $(this).find('.bg-gradient-to-r').text(index + 1);
                });
                
                // Hide add button if max reached
                if ($('.signatory-row').length >= MAX_SIGNATORIES) {
                    $('#add-signatory').hide();
                }
            });

            $(document).on('click', '.remove-signatory', function() {
                if ($('.signatory-row').length > 1) {
                    $(this).closest('.signatory-row').remove();
                    
                    // Update badge numbers after removal
                    $('.signatory-row').each(function(index) {
                        $(this).find('.bg-gradient-to-r').text(index + 1);
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

            // Hide add button on page load if max already reached
            $(document).ready(function() {
                if ($('.signatory-row').length >= MAX_SIGNATORIES) {
                    $('#add-signatory').hide();
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

            $('#updateCertificateButton').click(function(e) {
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
                    title: 'Update Certificate Template?',
                    text: "Are you sure you want to update this certificate template?",
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
                                document.getElementById('updateCertificateForm').submit();
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