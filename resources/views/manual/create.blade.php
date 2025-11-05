<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-2xl md:text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                {{ __('Create Manual Content') }}
            </h2>
            <a href="{{ route('manual.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-semibold dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-all duration-200 
                        w-full md:w-auto hover:shadow-lg">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Back to Edit Users Manual</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8 bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl p-6 md:p-8 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 rounded-xl backdrop-blur-sm shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">Create Manual Content</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Add new content to help users navigate the system</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form id="manualForm" action="{{ route('manual.store') }}" method="POST">
                        @csrf
                        
                        <!-- Basic Information Card -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Basic Information</h3>
                            </div>

                            <div class="space-y-6">
                                <!-- Content Type -->
                                <div>
                                    <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                            </svg>
                                            Content Type <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <select name="type" id="type" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
                                        <option value="">Select Content Type</option>
                                        @foreach($types as $key => $value)
                                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                            </svg>
                                            Title <span class="text-red-500">*</span>
                                        </span>
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                        placeholder="Enter content title">
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                            Description
                                        </span>
                                    </label>
                                    <textarea name="description" id="description" rows="3"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                        placeholder="Enter content description">{{ old('description') }}</textarea>
                                    @error('description')
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

                        <!-- Type-specific fields -->
                        <div id="typeSpecificFields" class="mt-6">
                            <!-- Fields will be dynamically loaded based on type selection -->
                        </div>

                        <!-- Settings Card -->
                        <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-lg shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Settings</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Sort Order -->
                                <div>
                                    <label for="sort_order" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                            Sort Order
                                        </span>
                                    </label>
                                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-2 focus:ring-purple-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4">
                                    @error('sort_order')
                                        <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Active Status -->
                                <div class="flex items-center pt-8">
                                    <div class="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg w-full">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                            class="w-5 h-5 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="is_active" class="ml-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex flex-col sm:flex-row justify-end gap-4">
                            <a href="{{ route('manual.index') }}" 
                               class="inline-flex items-center justify-center gap-2 px-8 py-4 text-white hover:text-red-700 hover:border-red-700 
                                    bg-red-600 hover:bg-white focus:outline-none focus:ring-4 focus:ring-red-300 
                                    border border-red-600 font-semibold dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg leading-normal transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>  
                                Cancel
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Create Content</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const typeSelect = document.getElementById('type');
                const typeSpecificFields = document.getElementById('typeSpecificFields');

                function loadTypeSpecificFields(type) {
                    let html = '';

                    switch(type) {
                        case 'tutorial_video':
                            html = `
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="bg-gradient-to-r from-red-500 to-pink-600 p-3 rounded-lg shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Tutorial Video Details</h3>
                                    </div>
                                    <div>
                                        <label for="video_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                </svg>
                                                Video URL <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                            placeholder="https://www.youtube.com/watch?v=...">
                                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Enter the full URL to the tutorial video
                                        </p>
                                    </div>
                                </div>
                            `;
                            break;

                        case 'faq':
                            html = `
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-3 rounded-lg shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">FAQ Details</h3>
                                    </div>
                                    <div>
                                        <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                            <span class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Answer <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        <textarea name="content" id="content" rows="6" required
                                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-2 focus:ring-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                            placeholder="Enter the detailed answer to the question">{{ old('content') }}</textarea>
                                    </div>
                                </div>
                            `;
                            break;

                        case 'user_guide':
                            html = `
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-3 rounded-lg shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">User Guide Steps</h3>
                                    </div>
                                    <div id="stepsContainer" class="space-y-3">
                                        <div class="step-group flex items-center gap-3">
                                            <span class="flex items-center justify-center w-8 h-8 bg-green-500 text-white font-bold rounded-full text-sm flex-shrink-0">1</span>
                                            <input type="text" name="steps[]" 
                                                class="flex-1 block rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                                placeholder="Enter step description" required>
                                            <button type="button" onclick="addStep()" 
                                                class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 hover:shadow-lg text-white rounded-lg transition-all duration-200 hover:scale-105 flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="mt-3 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Add at least one step for the user guide
                                    </p>
                                </div>
                            `;
                            break;

                        case 'support':
                            html = `
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 md:p-8 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-shadow duration-300">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-3 rounded-lg shadow-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">Support Contact Details</h3>
                                    </div>
                                    <div class="space-y-6">
                                        <div>
                                            <label for="contact_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                <span class="flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    Contact Email <span class="text-red-500">*</span>
                                                </span>
                                            </label>
                                            <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}" required
                                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                                placeholder="support@example.com">
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <label for="contact_phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    <span class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        Contact Phone
                                                    </span>
                                                </label>
                                                <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"
                                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                                    placeholder="+1 (555) 123-4567">
                                            </div>
                                            <div>
                                                <label for="contact_hours" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                                    <span class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-cyan-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Contact Hours
                                                    </span>
                                                </label>
                                                <input type="text" name="contact_hours" id="contact_hours" value="{{ old('contact_hours') }}"
                                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                                                    placeholder="Mon-Fri 9:00 AM - 5:00 PM">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            break;

                        default:
                            html = '';
                    }

                    typeSpecificFields.innerHTML = html;
                }

                typeSelect.addEventListener('change', function() {
                    loadTypeSpecificFields(this.value);
                });

                // Load initial fields if type is already selected
                if (typeSelect.value) {
                    loadTypeSpecificFields(typeSelect.value);
                }
            });

            function addStep() {
                const container = document.getElementById('stepsContainer');
                const stepCount = container.children.length + 1;
                
                const stepGroup = document.createElement('div');
                stepGroup.className = 'step-group flex items-center gap-3';
                stepGroup.innerHTML = `
                    <span class="flex items-center justify-center w-8 h-8 bg-green-500 text-white font-bold rounded-full text-sm flex-shrink-0">${stepCount}</span>
                    <input type="text" name="steps[]" 
                        class="flex-1 block rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition-all duration-200 py-3 px-4"
                        placeholder="Enter step description" required>
                    <button type="button" onclick="removeStep(this)" 
                        class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-red-500 to-pink-600 hover:shadow-lg text-white rounded-lg transition-all duration-200 hover:scale-105 flex-shrink-0">
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
                        const badge = group.querySelector('span');
                        badge.textContent = `${index + 1}`;
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>