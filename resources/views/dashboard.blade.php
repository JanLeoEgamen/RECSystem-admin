<x-app-layout>
   <x-slot name="header">
    <div class="flex items-center justify-center sm:justify-start
                p-4 sm:p-6 rounded-lg shadow-lg
                bg-gradient-to-r from-[#101966] via-[#3F53E8] to-[#5E6FFB]
                dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">

        <!-- Header Title -->
        <h1 class="font-semibold text-2xl sm:text-3xl text-white dark:text-gray-100 leading-tight text-center sm:text-left">
            {{ __('Dashboard') }}
        </h1>
    </div>
</x-slot>


    <!-- Welcome Card -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-[#101966] to-[#5E6FFB] dark:from-[#101966] dark:to-[#5E6FFB] overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-2xl font-bold text-white dark:text-white">
                    <div class="flex items-center space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.28 0 4.5-2.22 4.5-5s-2.22-5-4.5-5S7.5 4.22 7.5 7s2.22 5 4.5 5zM4 20c0-4.418 4.5-8 8-8s8 3.582 8 8"></path>
                        </svg>
                        <div>
                            <p class="text-lg text-white font-semibold">{{ __("Hello,") }} <span class="text-white dark:text-white">{{ $fullName }}</span>!</p>
                            <p class="mt-1 text-xl text-white">{{ __("You're logged in!") }}</p>
                            
                        </div>
                        <div>
                            <p class="mt-1 text-md text-white dark:text-white">
                                {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('view members')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Members Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#5E6FFB] rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                    Total Members
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ $totalMembers }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Members Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#5E6FFB] rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                    Active Members
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ $activeMembers }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expiring Soon Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-[#101966] rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-300 truncate">
                                    Memberships Expiring Soon
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ $expiringSoon }}
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Memberships Expiring Soon Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            Memberships Expiring Soon
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-[#101966]">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Membership End</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Type</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($expiringSoonMembers as $member)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($member->membership_end)->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $member->membershipType->type_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300">
                                                No memberships expiring soon.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Recent Members Table -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                            Recent Members
                        </h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-[#5E6FFB]">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Membership Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Joined</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($recentMembers as $member)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $member->membershipType->type_name ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $member->created_at->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
</x-app-layout>