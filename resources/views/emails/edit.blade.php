<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
            {{ __('Edit Email Template') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('emails.update', $template->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name', $template->name) }}" required
                            class="w-full px-4 py-2 border rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Subject</label>
                        <input type="text" name="subject" value="{{ old('subject', $template->subject) }}" required
                            class="w-full px-4 py-2 border rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label class="block font-bold mb-1">Content</label>
                        <textarea name="body" rows="6" required
                            class="w-full px-4 py-2 border rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white">{{ old('body', $template->body) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('emails.index') }}"
                           class="mr-4 text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-5 py-2 bg-[#101966] text-white hover:bg-white hover:text-[#101966] border border-[#101966] rounded-lg">
                            Update Template
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
