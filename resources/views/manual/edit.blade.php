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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="manualForm" action="{{ route('manual.update', $manual->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Basic Information -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Basic Information</h3>
                            </div>

                            <div class="md:col-span-2">
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Content Type <span class="text-red-500">*</span>
                                </label>
                                <select name="type" id="type" required
                                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200">
                                    <option value="">Select Content Type</option>
                                    @foreach($types as $key => $value)
                                        <option value="{{ $key }}" {{ old('type', $manual->type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="title" id="title" value="{{ old('title', $manual->title) }}" required
                                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                    placeholder="Enter content title">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                    placeholder="Enter content description">{{ old('description', $manual->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Type-specific fields -->
                        <div id="typeSpecificFields" class="space-y-6 mb-6">
                            <!-- Fields will be dynamically loaded based on type selection -->
                        </div>

                        <!-- Settings -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Settings</h3>
                            </div>

                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Sort Order
                                </label>
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $manual->sort_order) }}" min="0"
                                    class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200">
                                @error('sort_order')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $manual->is_active) ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('manual.index') }}" 
                               class="inline-flex items-center px-5 py-2 text-white hover:text-red-700 hover:border-red-700 
                                    bg-red-600 hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-red-600 border border-red-600 font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" 
                                class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                  bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                  focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                  dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Update Content</span>
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
                const manualData = @json($manual);

                function loadTypeSpecificFields(type) {
                    let html = '';

                    switch(type) {
                        case 'tutorial_video':
                            html = `
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Tutorial Video Details</h3>
                                    </div>
                                    <div>
                                        <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Video URL <span class="text-red-500">*</span>
                                        </label>
                                        <input type="url" name="video_url" id="video_url" value="{{ old('video_url', $manual->video_url) }}" required
                                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                            placeholder="https://www.youtube.com/watch?v=...">
                                        <p class="text-xs text-gray-500 mt-1">Enter the full URL to the tutorial video</p>
                                    </div>
                                </div>
                            `;
                            break;

                        case 'faq':
                            html = `
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">FAQ Details</h3>
                                    </div>
                                    <div>
                                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Answer <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="content" id="content" rows="6" required
                                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                            placeholder="Enter the detailed answer to the question">{{ old('content', $manual->content) }}</textarea>
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
                                        <div class="step-group flex items-center space-x-2 mb-2">
                                            <span class="text-sm text-gray-500 w-8">${index + 1}.</span>
                                            <input type="text" name="steps[]" value="${step}"
                                                class="flex-1 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                                placeholder="Enter step description" required>
                                            ${index === 0 ? 
                                                // Add button (only on the first row)
                                                '<button type="button" onclick="addStep()" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition duration-200">' +
                                                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                                                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />' +
                                                    '</svg>' +
                                                '</button>' 
                                                : 
                                                // Remove button (for other rows)
                                                '<button type="button" onclick="removeStep(this)" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition duration-200">' +
                                                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">' +
                                                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />' +
                                                    '</svg>' +
                                                '</button>'
                                            }
                                        </div>
                                    `;
                                });
                            } else {
                                stepsHtml = `
                                    <div class="step-group flex items-center space-x-2 mb-2">
                                        <input type="text" name="steps[]" 
                                            class="flex-1 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                            placeholder="Enter step description" required>
                                        <button type="button" onclick="addStep()" 
                                            class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </div>
                                `;
                            }

                            html = `
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">User Guide Steps</h3>
                                    </div>
                                    <div id="stepsContainer">
                                        ${stepsHtml}
                                    </div>
                                    <p class="text-xs text-gray-500">Add at least one step for the user guide</p>
                                </div>
                            `;
                            break;

                        case 'support':
                            html = `
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Support Contact Details</h3>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Contact Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $manual->contact_email) }}" required
                                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                            placeholder="support@example.com">
                                    </div>
                                    <div>
                                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Contact Phone
                                        </label>
                                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $manual->contact_phone) }}"
                                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                            placeholder="+1 (555) 123-4567">
                                    </div>
                                    <div>
                                        <label for="contact_hours" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Contact Hours
                                        </label>
                                        <input type="text" name="contact_hours" id="contact_hours" value="{{ old('contact_hours', $manual->contact_hours) }}"
                                            class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                                            placeholder="Mon-Fri 9:00 AM - 5:00 PM">
                                    </div>
                                </div>
                            `;
                            break;

                        default:
                            html = '<p class="text-gray-500 dark:text-gray-400">Select a content type to see specific fields</p>';
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
                stepGroup.className = 'step-group flex items-center space-x-2 mb-2';
                stepGroup.innerHTML = `
                    <span class="text-sm text-gray-500 w-8">${stepCount}.</span>
                    <input type="text" name="steps[]" 
                        class="flex-1 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-300 transition duration-200"
                        placeholder="Enter step description" required>
                    <button type="button" onclick="removeStep(this)" 
                        class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                        group.querySelector('span').textContent = `${index + 1}.`;
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>