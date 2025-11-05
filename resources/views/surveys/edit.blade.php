<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Surveys / Edit</span>
            </h2>
            <a href="{{ route('surveys.index') }}" 
                class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
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
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-8 md:p-10">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 p-3 rounded-xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Edit Survey</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 ml-16">Update survey details, questions, and recipients</p>
                    </div>

                    <form id="updateForm" action="{{ route('surveys.update', $survey->id) }}" method="post">
                        @csrf
                        
                        <!-- Survey Details Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Survey Details</h4>
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
                                    <input value="{{ old('title', $survey->title) }}" name="title" id="title" placeholder="Enter survey title" type="text" 
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

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                            Description
                                        </span>
                                    </label>
                                    <textarea name="description" id="description" placeholder="Enter survey description" rows="3"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">{{ old('description', $survey->description) }}</textarea>
                                    @error('description')
                                    <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                    @enderror
                                </div>

                                <!-- Published Status -->
                                <div class="flex items-center gap-3 bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                    <input type="hidden" name="is_published" value="0">
                                    <input type="checkbox" name="is_published" id="is_published" 
                                        class="w-5 h-5 rounded text-teal-600 focus:ring-2 focus:ring-teal-500 dark:bg-gray-700 dark:border-gray-600 transition-all duration-200" 
                                        value="1" {{ old('is_published', $survey->is_published) ? 'checked' : '' }}>
                                    <label for="is_published" class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Published
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Questions Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Survey Questions</h4>
                            </div>
                            
                            <div id="questions-container" class="space-y-4">
                                @foreach($survey->questions as $index => $question)
                                    <div class="question-item bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 p-5 rounded-xl border-2 border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200" data-index="{{ $index + 1 }}">
                                        <div class="flex justify-between items-center mb-4">
                                            <div class="flex items-center gap-2">
                                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-md">
                                                    {{ $index + 1 }}
                                                </div>
                                                <h4 class="font-bold text-gray-900 dark:text-gray-100">Question #{{ $index + 1 }}</h4>
                                            </div>
                                            <button type="button" class="remove-question p-2 rounded-lg text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 transition-all duration-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <input type="hidden" name="questions[{{ $index + 1 }}][id]" value="{{ $question->id }}">
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    <span class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Question Text
                                                    </span>
                                                </label>
                                                <input type="text" name="questions[{{ $index + 1 }}][question]" 
                                                    value="{{ old('questions.'.($index+1).'.question', $question->question) }}" 
                                                    placeholder="Enter question" 
                                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2.5 px-4" required>
                                            </div>
                                            
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    <span class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                                        </svg>
                                                        Question Type
                                                    </span>
                                                </label>
                                                <select name="questions[{{ $index + 1 }}][type]" class="question-type block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2.5 px-4" required>
                                                    <option value="short-answer" {{ $question->type == 'short-answer' ? 'selected' : '' }}>Short Answer</option>
                                                    <option value="long-answer" {{ $question->type == 'long-answer' ? 'selected' : '' }}>Long Answer</option>
                                                    <option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                    <option value="multiple-choice" {{ $question->type == 'multiple-choice' ? 'selected' : '' }}>Multiple Choice</option>
                                                </select>
                                            </div>
                                            
                                            <div class="options-container {{ !in_array($question->type, ['checkbox', 'multiple-choice']) ? 'hidden' : '' }}">
                                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    <span class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                        </svg>
                                                        Options (one per line)
                                                    </span>
                                                </label>
                                                <textarea name="questions[{{ $index + 1 }}][options]" 
                                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2.5 px-4" 
                                                    rows="3">{{ old('questions.'.($index+1).'.options', $question->options ? implode("\n", $question->options) : '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" id="add-question" 
                                class="mt-6 inline-flex items-center justify-center px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-700 hover:from-green-700 hover:to-emerald-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Question
                            </button>
                        </div>

                        <!-- Members Assignment Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300 mb-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100">Assign to Members</h4>
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
                                                <option value="{{ $member->id }}" {{ in_array($member->id, old('members', $survey->members->pluck('id')->toArray())) ? 'selected' : '' }}
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
                                                                    {{ in_array($member->id, old('members', $survey->members->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                                    @if(in_array($member->id, old('members', $survey->members->pluck('id')->toArray())))
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

                        <!-- Submit Button Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex justify-end">
                                <button type="submit" 
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-700 hover:from-teal-700 hover:to-cyan-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Update Survey
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
                let questionCount = {{ $survey->questions->count() }};

                // Initialize question type change handlers
                document.querySelectorAll('.question-type').forEach(select => {
                    select.addEventListener('change', function() {
                        const questionDiv = this.closest('.question-item');
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        if (this.value === 'checkbox' || this.value === 'multiple-choice') {
                            optionsContainer.classList.remove('hidden');
                        } else {
                            optionsContainer.classList.add('hidden');
                        }
                    });
                });

                // Initialize remove buttons
                document.querySelectorAll('.remove-question').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const questionDiv = this.closest('.question-item');
                        questionDiv.remove();
                        // Renumber remaining questions
                        const questions = questionsContainer.querySelectorAll('.question-item');
                        questions.forEach((q, index) => {
                            q.dataset.index = index + 1;
                            q.querySelector('h4').textContent = `Question #${index + 1}`;
                            q.querySelector('.bg-gradient-to-r').textContent = index + 1;
                            // Update all input names
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
                    questionDiv.className = 'question-item bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 p-5 rounded-xl border-2 border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200';
                    questionDiv.dataset.index = questionCount;

                    questionDiv.innerHTML = `
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center gap-2">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-md">
                                    ${questionCount}
                                </div>
                                <h4 class="font-bold text-gray-900 dark:text-gray-100">Question #${questionCount}</h4>
                            </div>
                            <button type="button" class="remove-question p-2 rounded-lg text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Question Text
                                    </span>
                                </label>
                                <input type="text" name="questions[${questionCount}][question]" placeholder="Enter question" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2.5 px-4" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        Question Type
                                    </span>
                                </label>
                                <select name="questions[${questionCount}][type]" class="question-type block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2.5 px-4" required>
                                    <option value="short-answer">Short Answer</option>
                                    <option value="long-answer">Long Answer</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="multiple-choice">Multiple Choice</option>
                                </select>
                            </div>
                            
                            <div class="options-container hidden">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <span class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Options (one per line)
                                    </span>
                                </label>
                                <textarea name="questions[${questionCount}][options]" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-2.5 px-4" rows="3"></textarea>
                            </div>
                        </div>
                    `;

                    questionsContainer.appendChild(questionDiv);

                    // Add event listener for type change
                    const typeSelect = questionDiv.querySelector('.question-type');
                    typeSelect.addEventListener('change', function() {
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        if (this.value === 'checkbox' || this.value === 'multiple-choice') {
                            optionsContainer.classList.remove('hidden');
                        } else {
                            optionsContainer.classList.add('hidden');
                        }
                    });

                    // Add event listener for remove button
                    const removeBtn = questionDiv.querySelector('.remove-question');
                    removeBtn.addEventListener('click', function() {
                        questionDiv.remove();
                        // Renumber remaining questions
                        const questions = questionsContainer.querySelectorAll('.question-item');
                        questions.forEach((q, index) => {
                            q.dataset.index = index + 1;
                            q.querySelector('h4').textContent = `Question #${index + 1}`;
                            q.querySelector('.bg-gradient-to-r').textContent = index + 1;
                            // Update all input names
                            const inputs = q.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => {
                                const name = input.name.replace(/questions\[\d+\]/, `questions[${index + 1}]`);
                                input.name = name;
                            });
                        });
                        questionCount = questions.length;
                    });
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

                document.getElementById("updateForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to update this survey?",
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