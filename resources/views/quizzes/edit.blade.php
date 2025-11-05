<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Quizzes / Edit
            </h2>
            <a href="{{ route('quizzes.index') }}" class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
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
            <!-- Page Header with Icon -->
            <div class="mb-8 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-lg p-6">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-xl shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Quiz</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update quiz details, questions, and assignments</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('quizzes.update', $quiz->id) }}" method="post" id="updateForm">
                @csrf
                @method('PUT')

                <!-- Quiz Details Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Quiz Details</h4>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label for="title" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Quiz Title
                                </label>
                                <input value="{{ old('title', $quiz->title) }}" name="title" placeholder="Enter quiz title" type="text" 
                                    class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-violet-500 focus:ring-2 focus:ring-violet-500 focus:ring-opacity-50 transition-all duration-200">
                                @error('title')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    Description
                                </label>
                                <textarea name="description" placeholder="Enter quiz description" 
                                    class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-violet-500 focus:ring-2 focus:ring-violet-500 focus:ring-opacity-50 transition-all duration-200" rows="3">{{ old('description', $quiz->description) }}</textarea>
                                @error('description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <div class="bg-gradient-to-r from-violet-50 to-purple-50 dark:from-gray-700 dark:to-gray-700 p-4 rounded-lg border border-violet-200 dark:border-gray-600">
                                <div class="flex items-center gap-3">
                                    <input type="hidden" name="is_published" value="0">
                                    <input type="checkbox" name="is_published" id="is_published" 
                                        class="h-5 w-5 text-violet-600 rounded focus:ring-2 focus:ring-violet-500 focus:ring-offset-2" value="1" 
                                        {{ old('is_published', $quiz->is_published) ? 'checked' : '' }}>
                                    <label for="is_published" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                                        <svg class="h-5 w-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Published (Visible to assigned members)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Questions Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Questions</h4>
                        </div>

                        <div id="questions-container" class="space-y-4">
                            @foreach($quiz->questions as $index => $question)
                                <div class="question-item bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 p-5 rounded-xl border-2 border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200" data-index="{{ $index + 1 }}">
                                    <div class="flex justify-between items-center mb-4">
                                        <div class="flex items-center gap-3">
                                            <span class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold px-3 py-1 rounded-lg text-sm">{{ $index + 1 }}</span>
                                            <h4 class="font-semibold text-gray-700 dark:text-gray-300">Question #{{ $index + 1 }}</h4>
                                        </div>
                                        <button type="button" class="remove-question bg-red-100 hover:bg-red-600 text-red-600 hover:text-white p-2 rounded-lg transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <input type="hidden" name="questions[{{ $index + 1 }}][id]" value="{{ $question->id }}">
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Question Text
                                            </label>
                                            <input type="text" name="questions[{{ $index + 1 }}][question]" 
                                                value="{{ old('questions.'.($index+1).'.question', $question->question) }}" 
                                                placeholder="Enter question" 
                                                class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" required>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                                    </svg>
                                                    Question Type
                                                </label>
                                                <select name="questions[{{ $index + 1 }}][type]" class="question-type block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" required>
                                                    <option value="identification" {{ $question->type == 'identification' ? 'selected' : '' }}>Identification</option>
                                                    <option value="true-false" {{ $question->type == 'true-false' ? 'selected' : '' }}>True or False</option>
                                                    <option value="checkbox" {{ $question->type == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                    <option value="multiple-choice" {{ $question->type == 'multiple-choice' ? 'selected' : '' }}>Multiple Choice</option>
                                                </select>
                                            </div>
                                            
                                            <div>
                                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                    Points
                                                </label>
                                                <input type="number" name="questions[{{ $index + 1 }}][points]" 
                                                    min="0" step="0.01" 
                                                    value="{{ old('questions.'.($index+1).'.points', $question->points) }}" 
                                                    class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" required>
                                            </div>
                                        </div>
                                        
                                        <div class="options-container {{ !in_array($question->type, ['checkbox', 'multiple-choice']) ? 'hidden' : '' }}">
                                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                Options (one per line)
                                            </label>
                                            <textarea name="questions[{{ $index + 1 }}][options]" 
                                                class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" 
                                                rows="3">{{ old('questions.'.($index+1).'.options', $question->options ? implode("\n", $question->options) : '') }}</textarea>
                                        </div>
                                        
                                        <div class="correct-answers-container">
                                            <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Correct Answer(s)
                                            </label>
                                            <div class="correct-answers-inputs">
                                                @if($question->type === 'identification')
                                                    <input type="text" name="questions[{{ $index + 1 }}][correct_answers]" 
                                                        value="{{ old('questions.'.($index+1).'.correct_answers', $question->correct_answers[0] ?? '') }}" 
                                                        class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50" required>
                                                @elseif($question->type === 'true-false')
                                                    <select name="questions[{{ $index + 1 }}][correct_answers]" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50" required>
                                                        <option value="true" {{ old('questions.'.($index+1).'.correct_answers', $question->correct_answers[0] ?? '') == 'true' ? 'selected' : '' }}>True</option>
                                                        <option value="false" {{ old('questions.'.($index+1).'.correct_answers', $question->correct_answers[0] ?? '') == 'false' ? 'selected' : '' }}>False</option>
                                                    </select>
                                                @elseif($question->type === 'multiple-choice')
                                                    <select name="questions[{{ $index + 1 }}][correct_answers]" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-500 focus:ring-opacity-50" required>
                                                        <option value="">Select correct answer</option>
                                                        @foreach($question->options as $option)
                                                            <option value="{{ $option }}" {{ (old('questions.'.($index+1).'.correct_answers', $question->correct_answers[0] ?? '') == $option) ? 'selected' : '' }}>{{ $option }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif($question->type === 'checkbox')
                                                    <div class="space-y-2 mt-2 bg-white dark:bg-gray-700 p-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                                        @foreach($question->options as $option)
                                                            <div class="flex items-center">
                                                                <input type="checkbox" name="questions[{{ $index + 1 }}][correct_answers][]" 
                                                                    id="q{{ $index + 1 }}-correct-{{ $loop->index }}" 
                                                                    value="{{ $option }}" 
                                                                    class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 dark:border-gray-600 rounded"
                                                                    {{ in_array($option, old('questions.'.($index+1).'.correct_answers', $question->correct_answers ?? [])) ? 'checked' : '' }}>
                                                                <label for="q{{ $index + 1 }}-correct-{{ $loop->index }}" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $option }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" id="add-question" class="mt-6 flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add Question
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
                                            <option value="{{ $member->id }}" {{ in_array($member->id, old('members', $quiz->members->pluck('id')->toArray())) ? 'selected' : '' }}
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
                                                                {{ in_array($member->id, old('members', $quiz->members->pluck('id')->toArray())) ? 'checked' : '' }}>
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
                                                @if(in_array($member->id, old('members', $quiz->members->pluck('id')->toArray())))
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
                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="text-lg">Update Quiz</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const questionsContainer = document.getElementById('questions-container');
                const addQuestionBtn = document.getElementById('add-question');
                let questionCount = {{ $quiz->questions->count() }};

                // Initialize question type change handlers
                document.querySelectorAll('.question-type').forEach(select => {
                    select.addEventListener('change', function() {
                        const questionDiv = this.closest('.question-item');
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        const correctAnswersContainer = questionDiv.querySelector('.correct-answers-container');
                        const correctAnswersInputs = questionDiv.querySelector('.correct-answers-inputs');
                        
                        if (this.value === 'checkbox' || this.value === 'multiple-choice') {
                            optionsContainer.classList.remove('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            
                            // Clear previous inputs
                            correctAnswersInputs.innerHTML = '';
                            
                            if (this.value === 'multiple-choice') {
                                correctAnswersInputs.innerHTML = `
                                    <select name="${this.name.replace('[type]', '[correct_answers]')}" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                        <option value="">Select correct answer</option>
                                    </select>
                                `;
                            } else {
                                correctAnswersInputs.innerHTML = `
                                    <div class="space-y-2 mt-2">
                                        <p class="text-xs text-gray-500">Select all correct answers (will be populated after options are entered)</p>
                                    </div>
                                `;
                            }
                        } else if (this.value === 'true-false') {
                            optionsContainer.classList.add('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            correctAnswersInputs.innerHTML = `
                                <select name="${this.name.replace('[type]', '[correct_answers]')}" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            `;
                        } else {
                            optionsContainer.classList.add('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            correctAnswersInputs.innerHTML = `
                                <input type="text" name="${this.name.replace('[type]', '[correct_answers]')}" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                            `;
                        }
                    });

                    // Add event listener for options textarea to populate correct answers for checkbox/multiple-choice
                    const optionsTextarea = select.closest('.question-item').querySelector('textarea[name^="questions"]');
                    if (optionsTextarea) {
                        optionsTextarea.addEventListener('input', function() {
                            const typeSelect = select.closest('.question-item').querySelector('.question-type');
                            if (typeSelect.value === 'multiple-choice') {
                                const options = this.value.split('\n').filter(opt => opt.trim() !== '');
                                const correctAnswersSelect = select.closest('.question-item').querySelector('select[name^="questions"][name$="[correct_answers]"]');
                                
                                if (correctAnswersSelect) {
                                    correctAnswersSelect.innerHTML = '<option value="">Select correct answer</option>';
                                    options.forEach(option => {
                                        if (option.trim() !== '') {
                                            const opt = document.createElement('option');
                                            opt.value = option.trim();
                                            opt.textContent = option.trim();
                                            correctAnswersSelect.appendChild(opt);
                                        }
                                    });
                                }
                            } else if (typeSelect.value === 'checkbox') {
                                const options = this.value.split('\n').filter(opt => opt.trim() !== '');
                                const correctAnswersDiv = select.closest('.question-item').querySelector('.correct-answers-inputs > div');
                                
                                if (correctAnswersDiv) {
                                    correctAnswersDiv.innerHTML = '';
                                    options.forEach((option, index) => {
                                        if (option.trim() !== '') {
                                            const div = document.createElement('div');
                                            div.className = 'flex items-center';
                                            const qIndex = select.closest('.question-item').dataset.index;
                                            div.innerHTML = `
                                                <input type="checkbox" name="questions[${qIndex}][correct_answers][]" 
                                                    id="q${qIndex}-correct-${index}" 
                                                    value="${option.trim()}" 
                                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                <label for="q${qIndex}-correct-${index}" class="ml-2 text-sm">${option.trim()}</label>
                                            `;
                                            correctAnswersDiv.appendChild(div);
                                        }
                                    });
                                }
                            }
                        });
                    }
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
                            // Update numbered badge
                            const badge = q.querySelector('.bg-gradient-to-r');
                            if (badge) badge.textContent = index + 1;
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
                            <div class="flex items-center gap-3">
                                <span class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold px-3 py-1 rounded-lg text-sm">${questionCount}</span>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300">Question #${questionCount}</h4>
                            </div>
                            <button type="button" class="remove-question bg-red-100 hover:bg-red-600 text-red-600 hover:text-white p-2 rounded-lg transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin-round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Question Text
                                </label>
                                <input type="text" name="questions[${questionCount}][question]" placeholder="Enter question" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" required>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                        </svg>
                                        Question Type
                                    </label>
                                    <select name="questions[${questionCount}][type]" class="question-type block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" required>
                                        <option value="identification">Identification</option>
                                        <option value="true-false">True or False</option>
                                        <option value="checkbox">Checkbox</option>
                                        <option value="multiple-choice">Multiple Choice</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                        Points
                                    </label>
                                    <input type="number" name="questions[${questionCount}][points]" min="0" step="0.01" value="1.00" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" required>
                                </div>
                            </div>
                            
                            <div class="options-container hidden">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Options (one per line)
                                </label>
                                <textarea name="questions[${questionCount}][options]" class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" rows="3"></textarea>
                            </div>
                            
                            <div class="correct-answers-container hidden">
                                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Correct Answer(s)
                                </label>
                                <div class="correct-answers-inputs"></div>
                            </div>
                        </div>
                    `;

                    questionsContainer.appendChild(questionDiv);

                    // Add event listener for type change
                    const typeSelect = questionDiv.querySelector('.question-type');
                    typeSelect.addEventListener('change', function() {
                        const optionsContainer = questionDiv.querySelector('.options-container');
                        const correctAnswersContainer = questionDiv.querySelector('.correct-answers-container');
                        const correctAnswersInputs = questionDiv.querySelector('.correct-answers-inputs');
                        
                        if (this.value === 'checkbox' || this.value === 'multiple-choice') {
                            optionsContainer.classList.remove('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            
                            // Clear previous inputs
                            correctAnswersInputs.innerHTML = '';
                            
                            if (this.value === 'multiple-choice') {
                                correctAnswersInputs.innerHTML = `
                                    <select name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                        <option value="">Select correct answer</option>
                                    </select>
                                `;
                            } else {
                                correctAnswersInputs.innerHTML = `
                                    <div class="space-y-2 mt-2">
                                        <p class="text-xs text-gray-500">Select all correct answers (will be populated after options are entered)</p>
                                    </div>
                                `;
                            }
                        } else if (this.value === 'true-false') {
                            optionsContainer.classList.add('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            correctAnswersInputs.innerHTML = `
                                <select name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            `;
                        } else {
                            optionsContainer.classList.add('hidden');
                            correctAnswersContainer.classList.remove('hidden');
                            correctAnswersInputs.innerHTML = `
                                <input type="text" name="questions[${questionCount}][correct_answers]" class="border-gray-300 shadow-sm w-full rounded-lg mt-1" required>
                            `;
                        }
                    });

                    // Trigger change event to initialize
                    typeSelect.dispatchEvent(new Event('change'));

                    // Add event listener for options textarea to populate correct answers for checkbox/multiple-choice
                    const optionsTextarea = questionDiv.querySelector('textarea[name^="questions"]');
                    optionsTextarea.addEventListener('input', function() {
                        const typeSelect = questionDiv.querySelector('.question-type');
                        if (typeSelect.value === 'multiple-choice') {
                            const options = this.value.split('\n').filter(opt => opt.trim() !== '');
                            const correctAnswersSelect = questionDiv.querySelector('select[name^="questions"][name$="[correct_answers]"]');
                            
                            if (correctAnswersSelect) {
                                correctAnswersSelect.innerHTML = '<option value="">Select correct answer</option>';
                                options.forEach(option => {
                                    if (option.trim() !== '') {
                                        const opt = document.createElement('option');
                                        opt.value = option.trim();
                                        opt.textContent = option.trim();
                                        correctAnswersSelect.appendChild(opt);
                                    }
                                });
                            }
                        } else if (typeSelect.value === 'checkbox') {
                            const options = this.value.split('\n').filter(opt => opt.trim() !== '');
                            const correctAnswersDiv = questionDiv.querySelector('.correct-answers-inputs > div');
                            
                            if (correctAnswersDiv) {
                                correctAnswersDiv.innerHTML = '';
                                options.forEach((option, index) => {
                                    if (option.trim() !== '') {
                                        const div = document.createElement('div');
                                        div.className = 'flex items-center';
                                        div.innerHTML = `
                                            <input type="checkbox" name="questions[${questionCount}][correct_answers][]" 
                                                id="q${questionCount}-correct-${index}" 
                                                value="${option.trim()}" 
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="q${questionCount}-correct-${index}" class="ml-2 text-sm">${option.trim()}</label>
                                        `;
                                        correctAnswersDiv.appendChild(div);
                                    }
                                });
                            }
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
                            // Update numbered badge
                            const badge = q.querySelector('.bg-gradient-to-r');
                            if (badge) badge.textContent = index + 1;
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

                // Add SweetAlert for form submission
                document.getElementById("updateForm").addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Do you want to update this quiz?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#5e6ffb",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, update it!",
                        cancelButtonText: "Cancel",
                        background: '#101966',
                        color: '#fff'
                    }).then((result) => {
                        if(result.isConfirmed){
                            Swal.fire({
                                title: 'Updating...',
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