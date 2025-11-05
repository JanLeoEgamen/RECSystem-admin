<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-2xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                {{ __('Edit Manual Content') }}
            </h2>
            <a href="{{ route('manual.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full md:w-auto">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Edit User Manual</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Page Header with Icon -->
            <div class="mb-8 bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-lg p-6">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-orange-500 to-red-600 p-3 rounded-xl shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Manual Content</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Update user manual content and settings</p>
                    </div>
                </div>
            </div>

            <form id="manualForm" action="{{ route('manual.update', $manual->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Basic Information Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-violet-500 to-purple-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Basic Information</h4>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="type" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Content Type <span class="text-red-500">*</span>
                                </label>
                                <select name="type" id="type" required
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 transition-all duration-200 px-4 py-3">
                                    <option value="">Select Content Type</option>
                                    @foreach($types as $key => $value)
                                        <option value="{{ $key }}" {{ old('type', $manual->type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="title" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title', $manual->title) }}" required
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 transition-all duration-200 px-4 py-3"
                                    placeholder="Enter content title">
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
                                <textarea name="description" id="description" rows="3"
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-violet-500 focus:ring-2 focus:ring-violet-500 transition-all duration-200 px-4 py-3"
                                    placeholder="Enter content description">{{ old('description', $manual->description) }}</textarea>
                                @error('description')
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

                <!-- Type-specific fields container -->
                <div id="typeSpecificFields" class="mb-6">
                    <!-- Fields will be dynamically loaded based on type selection -->
                </div>

                <!-- Settings Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl mb-6">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-2 rounded-lg">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Settings</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="sort_order" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                    Sort Order
                                </label>
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $manual->sort_order) }}" min="0"
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 transition-all duration-200 px-4 py-3">
                                @error('sort_order')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <div class="p-4 bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-lg border-2 border-blue-200 dark:border-blue-700 w-full">
                                    <label for="is_active" class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $manual->is_active) ? 'checked' : '' }}
                                            class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active Status</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-end gap-4">
                            <a href="{{ route('manual.index') }}" 
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span class="text-lg">Cancel</span>
                            </a>
                            <button type="submit" 
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-[1.02]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span class="text-lg">Update Content</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const typeSelect = document.getElementById('type');
                const typeSpecificFields = document.getElementById('typeSpecificFields');
                const manualData = @json($manual);

                function loadTypeSpecificFields(type) {
                    let html = '';

                    switch(type) {
                        case 'tutorial_video':
                            html = `
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                                    <div class="p-6">
                                        <div class="flex items-center gap-3 mb-6">
                                            <div class="bg-gradient-to-r from-pink-500 to-rose-600 p-2 rounded-lg">
                                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Tutorial Video Details</h4>
                                        </div>
                                        <div>
                                            <label for="video_url" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <svg class="h-4 w-4 text-pink-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                                Video URL <span class="text-red-500">*</span>
                                            </label>
                                            <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $manual->video_url) }}" required
                                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-pink-500 focus:ring-2 focus:ring-pink-500 transition-all duration-200 px-4 py-3"
                                                placeholder="https://www.youtube.com/watch?v=...">
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 flex items-center gap-1">
                                                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Enter the full URL to the tutorial video
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;

                        case 'faq':
                            html = `
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                                    <div class="p-6">
                                        <div class="flex items-center gap-3 mb-6">
                                            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-2 rounded-lg">
                                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">FAQ Details</h4>
                                        </div>
                                        <div>
                                            <label for="content" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Answer <span class="text-red-500">*</span>
                                            </label>
                                            <textarea name="content" id="content" rows="6" required
                                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 transition-all duration-200 px-4 py-3"
                                                placeholder="Enter the detailed answer to the question">{{ old('content', $manual->content) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;

                        case 'user_guide':
                            const steps = manualData.steps ? manualData.steps : [];
                            let stepsHtml = '';
                            
                            if (steps.length > 0) {
                                steps.forEach((step, index) => {
                                    stepsHtml += `
                                        <div class="step-group flex items-center gap-3 mb-3">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                                ${index + 1}
                                            </div>
                                            <input type="text" name="steps[]" value="${step}"
                                                class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all duration-200 px-4 py-3"
                                                placeholder="Enter step description" required>
                                            ${index === 0 ? 
                                                '<button type="button" onclick="addStep()" class="flex-shrink-0 p-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">' +
                                                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                                                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />' +
                                                    '</svg>' +
                                                '</button>' 
                                                : 
                                                '<button type="button" onclick="removeStep(this)" class="flex-shrink-0 p-3 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">' +
                                                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                                                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />' +
                                                    '</svg>' +
                                                '</button>'
                                            }
                                        </div>
                                    `;
                                });
                            } else {
                                stepsHtml = `
                                    <div class="step-group flex items-center gap-3 mb-3">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                                            1
                                        </div>
                                        <input type="text" name="steps[]" 
                                            class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all duration-200 px-4 py-3"
                                            placeholder="Enter step description" required>
                                        <button type="button" onclick="addStep()" 
                                            class="flex-shrink-0 p-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                `;
                            }

                            html = `
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                                    <div class="p-6">
                                        <div class="flex items-center gap-3 mb-6">
                                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-2 rounded-lg">
                                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">User Guide Steps</h4>
                                        </div>
                                        <div id="stepsContainer" class="space-y-2">
                                            ${stepsHtml}
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-4 flex items-center gap-1">
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Add at least one step for the user guide
                                        </p>
                                    </div>
                                </div>
                            `;
                            break;

                        case 'support':
                            html = `
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 rounded-xl">
                                    <div class="p-6">
                                        <div class="flex items-center gap-3 mb-6">
                                            <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-2 rounded-lg">
                                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            </div>
                                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Support Contact Details</h4>
                                        </div>
                                        <div class="space-y-6">
                                            <div>
                                                <label for="contact_email" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                    <svg class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    Contact Email <span class="text-red-500">*</span>
                                                </label>
                                                <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $manual->contact_email) }}" required
                                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 transition-all duration-200 px-4 py-3"
                                                    placeholder="support@example.com">
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                <div>
                                                    <label for="contact_phone" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        <svg class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        Contact Phone
                                                    </label>
                                                    <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $manual->contact_phone) }}"
                                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 transition-all duration-200 px-4 py-3"
                                                        placeholder="+1 (555) 123-4567">
                                                </div>
                                                <div>
                                                    <label for="contact_hours" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        <svg class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Contact Hours
                                                    </label>
                                                    <input type="text" name="contact_hours" id="contact_hours" value="{{ old('contact_hours', $manual->contact_hours) }}"
                                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 transition-all duration-200 px-4 py-3"
                                                        placeholder="Mon-Fri 9:00 AM - 5:00 PM">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;

                        default:
                            html = `
                                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-xl">
                                    <div class="p-6">
                                        <p class="text-gray-500 dark:text-gray-400 text-center flex items-center justify-center gap-2">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Select a content type to see specific fields
                                        </p>
                                    </div>
                                </div>
                            `;
                    }

                    typeSpecificFields.innerHTML = html;
                }

                typeSelect.addEventListener('change', function() {
                    loadTypeSpecificFields(this.value);
                });

                // Load initial fields based on current type
                loadTypeSpecificFields(typeSelect.value);
            });

            function addStep() {
                const container = document.getElementById('stepsContainer');
                const stepCount = container.children.length + 1;
                
                const stepGroup = document.createElement('div');
                stepGroup.className = 'step-group flex items-center gap-3 mb-3';
                stepGroup.innerHTML = `
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                        ${stepCount}
                    </div>
                    <input type="text" name="steps[]" 
                        class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 transition-all duration-200 px-4 py-3"
                        placeholder="Enter step description" required>
                    <button type="button" onclick="removeStep(this)" 
                        class="flex-shrink-0 p-3 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                `;
                
                container.appendChild(stepGroup);
            }

            function removeStep(button) {
                const stepGroup = button.closest('.step-group');
                if (document.querySelectorAll('.step-group').length > 1) {
                    stepGroup.remove();
                    // Update step numbers
                    document.querySelectorAll('.step-group').forEach((group, index) => {
                        const numberBadge = group.querySelector('div.flex-shrink-0');
                        if (numberBadge) {
                            numberBadge.textContent = index + 1;
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>