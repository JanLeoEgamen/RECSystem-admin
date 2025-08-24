<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                {{ __('Edit ' . ucfirst($type)) }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-gray-10 dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('bureau-section.update', ['id' => $item->id, 'type' => $type]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        @if($type === 'bureau')
                            <div class="mb-6">
                                <label for="bureau_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bureau Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="bureau_name" id="bureau_name" value="{{ old('bureau_name', $item->bureau_name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                    placeholder="Enter bureau name" required>
                                @error('bureau_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <div class="mb-6">
                                <label for="bureau_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bureau <span class="text-red-500">*</span>
                                </label>
                                <select name="bureau_id" id="bureau_id" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                                    <option value="">Select Bureau</option>
                                    @foreach($bureaus as $bureau)
                                        <option value="{{ $bureau->id }}" {{ old('bureau_id', $item->bureau_id) == $bureau->id ? 'selected' : '' }}>
                                            {{ $bureau->bureau_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bureau_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="section_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Section Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="section_name" id="section_name" value="{{ old('section_name', $item->section_name) }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                    placeholder="Enter section name" required>
                                @error('section_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('bureau-section.index') }}"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-[#101966] dark:bg-blue-600 text-white rounded-lg hover:bg-[#0e1552] dark:hover:bg-blue-700 transition">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>