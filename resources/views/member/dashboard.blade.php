<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
            {{ __('Member Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Your member dashboard content will go here later -->
                    <p>Welcome to your member dashboard! This area is exclusive for organization members.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>