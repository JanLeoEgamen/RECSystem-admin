<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out forwards;
        opacity: 0;
    }
    
    .grid-row {
        display: grid;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .row-1 {
        grid-template-columns: repeat(4, 1fr);
    }
    
    .row-2 {
        grid-template-columns: 2fr 1fr;
    }
    
    .row-3 {
        grid-template-columns: 1fr 1fr;
    }
    
    .row-4 {
        grid-template-columns: 1fr 2fr;
    }
    
    .card {
    background: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: scale(1.005);
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }

    
    .dark .card {
        background: #1f2937;
    }
    
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    .dark .visitors-card {
        background: #1f2937;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <!-- Welcome Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-fade-in-down" style="animation-delay: 0.1s;">
        <div class="bg-gray-300 dark:bg-gray-900 p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-400 dark:border-gray-700">
            
            <!-- Left Section -->
            <div class="mb-4 sm:mb-0 sm:mr-6 flex-1">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    Hello, {{ $fullName }}, Welcome Back!
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-sm sm:text-base">
                    You're Logged In - The system is up-to-date
                </p>
            </div>

            <!-- Right Section -->
            <div class="text-left sm:text-right w-full sm:w-auto">
                <p class="text-lg text-gray-800 dark:text-gray-200">
                    <span id="dashboardDay" class="font-semibold"></span>
                    <span id="dashboardDate"></span>
                </p>
                <p id="dashboardTime" class="text-xl font-bold mt-1 text-gray-900 dark:text-white"></p>
            </div>
        </div>
    </div>


    <script>
        function updateDashboardTime() {
            const now = new Date();
            const days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
            const dayName = days[now.getDay()];
            const dateStr = now.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
            const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });

            document.getElementById('dashboardDay').textContent = `${dayName}, `;
            document.getElementById('dashboardDate').textContent = dateStr;
            document.getElementById('dashboardTime').textContent = timeStr;
        }

        updateDashboardTime();
        setInterval(updateDashboardTime, 1000);
    </script>


    <div class="py-6 animate-fade-in-down" style="animation-delay: 0.2s;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Row 1: CARDS -->
            <div class=" grid-row row-1 mb-6 grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Total Members -->
                <a href="{{ route('members.index') }}" 
                class="relative overflow-hidden card animate-fade-in-down bg-gradient-to-r from-[#101966] via-[#5e6ffb] to-[#E0F2FF] text-white rounded-lg shadow-lg shadow-gray-800/40 p-5 transform transition duration-500 hover:scale-110 hover:shadow-2xl"
                style="animation-delay: 0.3s;">
                
                    <svg class="absolute bottom-[-30px] right-0 w-44 h-28 opacity-50 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 100">
                        <path d="M0 85 L40 65 L80 75 L120 55 L160 70 L200 45" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>

                    <div class="flex items-center relative z-10">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 
                                    20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 
                                    20H2v-2a3 3 0 015.356-1.857M7 
                                    20v-2c0-.656.126-1.283.356-1.857m0 
                                    0a5.002 5.002 0 019.288 0M15 
                                    7a3 3 0 11-6 0 3 3 0 016 
                                    0zm6 3a2 2 0 11-4 0 2 2 
                                    0 014 0zM7 10a2 2 0 11-4 
                                    0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-lg font-semibold truncate text-white/90 drop-shadow-md">Total Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-white drop-shadow">{{ $totalMembers }}</div>
                            </dd>
                        </div>
                    </div>
                </a>

                <!-- Active Members -->
                <a href="{{ route('members.active') }}" 
                class="relative overflow-hidden card animate-fade-in-down bg-gradient-to-r from-[#16A34A] to-[#D1FAE5] text-white rounded-lg shadow-lg shadow-gray-800/40 p-5 transform transition duration-500 hover:scale-110 hover:shadow-2xl"
                style="animation-delay: 0.4s;">

                    <svg class="absolute bottom-[-30px] right-0 w-44 h-28 opacity-50 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 100">
                        <path d="M0 85 L40 65 L80 75 L120 55 L160 70 L200 45" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>

                    <div class="flex items-center relative z-10">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 
                                2a9 9 0 11-18 0 9 9 0 0118 
                                0z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-lg font-semibold text-white/90 truncate drop-shadow-md">Active Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-white drop-shadow">{{ $activeMembers }}</div>
                            </dd>
                        </div>
                    </div>
                </a>

                <!-- Inactive Members -->
                <a href="{{ route('members.inactive') }}" 
                class="relative overflow-hidden card animate-fade-in-down bg-gradient-to-r from-[#F94261] via-[#F75E77] to-[#FECACA] text-white rounded-lg shadow-lg shadow-gray-800/40 p-5 transform transition duration-500 hover:scale-110 hover:shadow-2xl"
                style="animation-delay: 0.45s;">

                    <svg class="absolute bottom-[-30px] right-0 w-44 h-28 opacity-50 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 100">
                        <path d="M0 85 L40 65 L80 75 L120 55 L160 70 L200 45" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>

                    <div class="flex items-center relative z-10">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 
                                5.656l3.536 3.536M5.636 
                                5.636l3.536 3.536m0 5.656l-3.536 
                                3.536"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-lg font-semibold text-white/90 truncate drop-shadow-md">Inactive Members</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-white drop-shadow">{{ $inactiveMembers }}</div>
                            </dd>
                        </div>
                    </div>
                </a>

                <!-- Expiring Soon -->
                <a href="{{ route('renew.index') }}" 
                class="relative overflow-hidden card animate-fade-in-down bg-gradient-to-r from-[#F66C2E] via-[#F2904D] to-[#FFEAD5] text-white rounded-lg shadow-lg shadow-gray-800/40 p-5 transform transition duration-500 hover:scale-110 hover:shadow-2xl"
                style="animation-delay: 0.5s;">

                    <svg class="absolute bottom-[-30px] right-0 w-44 h-28 opacity-50 pointer-events-none" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 200 100">
                        <path d="M0 85 L40 65 L80 75 L120 55 L160 70 L200 45" stroke="white" stroke-width="3" fill="none" stroke-linecap="round"/>
                    </svg>

                    <div class="flex items-center relative z-10">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 
                                4h.01m-6.938 4h13.856c1.54 
                                0 2.502-1.667 1.732-3L13.732 
                                4c-.77-1.333-2.694-1.333-3.464 
                                0L3.34 16c-.77 1.333.192 3 1.732 
                                3z"/>
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dt class="text-lg font-semibold text-white/90 truncate drop-shadow-md">Expiring Soon</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-bold text-white drop-shadow">{{ $expiringSoon }}</div>
                            </dd>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Row 2: Applicant Report and Membership Growth Analysis -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Applicant Report -->
                <div class="card dark:bg-gray-800 lg:col-span-1 h-full flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Recent Applicants</h3>
                    </div>

                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-[#101966] dark:bg-gray-600">
                                <tr>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tl-lg border-r border-gray-300 dark:border-gray-600">
                                        Name
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tr-lg border-r border-gray-300 dark:border-gray-600">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-800">
                                @forelse($recentApplicants->take(6) as $applicant)
                                    <tr class="group hover:bg-[#5e6ffb] dark:hover:bg-gray-900 transition-colors duration-200">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white text-center group-hover:text-white border-r border-gray-300 dark:border-gray-800">
                                            {{ $applicant->first_name }} {{ $applicant->last_name }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-center border-r border-gray-300 dark:border-gray-600">
                                            @if($applicant->status === 'Pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                    Pending
                                                </span>
                                            @elseif($applicant->status === 'Approved')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                                    Approved
                                                </span>
                                            @elseif($applicant->status === 'Rejected')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                                    Rejected
                                                </span>
                                            @else
                                                {{-- Default to Pending --}}
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                                            No recent applicants.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- View All Applicants Link -->
                    <div class="mt-4 text-center">
                        <a href="{{ route('applicants.index') }}" class="inline-flex items-center text-sm font-medium text-[#5e6ffb] hover:text-[#101966] dark:text-blue-400 dark:hover:text-blue-300">
                            View All Applicants
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>


                <!-- Membership Growth Analysis -->
                <div class="card dark:bg-gray-800 lg:col-span-2 h-full flex flex-col">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-2">
                        Radio Engineering Circle Inc. Membership Growth Analysis
                    </h3>
                    <div class="text-center mb-4">
                        <span class="text-sm text-gray-500 dark:text-gray-300">
                            Showing data for {{ now()->year }}
                        </span>
                    </div>

                    <div class="flex justify-end items-center mb-4">
                        <button id="exportBtn" type="button" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Export Data
                        </button>
                    </div>

                    <div class="chart-container flex-1">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>


            <!-- Row 3: Bar Chart and Line Chart -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Membership Type Distribution -->
                <div class="card dark:bg-gray-800">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-2">
                        Membership Type Distribution
                    </h3>
                    
                    <div class="flex justify-end items-center mb-4">
                        <button id="exportMembershipTypeBtn" 
                            type="button" 
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Export Data
                        </button>
                    </div>

                    <div class="chart-container">
                        <canvas id="membershipTypeChart"></canvas>
                    </div>
                </div>

                <!-- Member Distribution by Section -->
                <div class="card dark:bg-gray-800">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-2">
                        Member Distribution by Section
                    </h3>
                    
                    <div class="flex justify-end items-center mb-4">
                        <button id="exportSectionBtn" 
                            type="button" 
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Export Data
                        </button>
                    </div>

                    <div class="chart-container">
                        <canvas id="sectionChart"></canvas>
                    </div>
                </div>
            </div>


            <!-- Row 4: Recent Members and Memberships Expiring Soon -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Recent Members -->
                <div class="card dark:bg-gray-800 lg:col-span-1 h-full flex flex-col">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                        Recent Members
                    </h3>
                    <div class="overflow-x-auto flex-1">
                        <table class="min-w-full border border-gray-300 dark:border-gray-800 rounded-lg overflow-hidden">
                            <thead class="bg-[#101966]  dark:bg-gray-600">
                                <tr>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tl-lg border-r border-gray-300 dark:border-gray-600">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border-r border-gray-300 dark:border-gray-600">
                                        Membership Type
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-800">
                                @foreach($recentMembers as $member)
                                    <tr class="group hover:bg-[#5e6ffb] dark:hover:bg-gray-900 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white text-center group-hover:text-white border-r border-gray-300 dark:border-gray-800">
                                            {{ $member->first_name }} {{ $member->last_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center group-hover:text-white border-r border-gray-300 dark:border-gray-600">
                                            {{ $member->membershipType->type_name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                    <!-- Memberships Expiring Soon  -->
                    <div class="card bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg lg:col-span-2 h-full flex flex-col">
                        <div class="px-4 py-5 sm:p-6 flex-1">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                                Memberships Expiring Soon
                            </h3>
                            <div class="overflow-x-auto flex-1">
                                <table class="min-w-full border border-gray-300 dark:border-gray-800 rounded-lg overflow-hidden">
                                    <thead class="bg-[#101966] dark:bg-gray-600">
                                        <tr>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tl-lg border border-gray-300 dark:border-gray-600">
                                                Name
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider border border-gray-300 dark:border-gray-600">
                                                Membership End
                                            </th>
                                            <th class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider rounded-tr-lg border border-gray-300 dark:border-gray-600">
                                                Type
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800">
                                        @forelse($expiringSoonMembers as $member)
                                            <tr class="group hover:bg-[#5e6ffb] dark:hover:bg-gray-900  transition-colors duration-200">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white text-center group-hover:text-white border border-gray-300 dark:border-gray-800">
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center group-hover:text-white border border-gray-300 dark:border-gray-600">
                                                    {{ \Carbon\Carbon::parse($member->membership_end)->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center group-hover:text-white border border-gray-300 dark:border-gray-600">
                                                    {{ $member->membershipType->type_name ?? 'N/A' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-300 border border-gray-300 dark:border-gray-600">
                                                    No memberships expiring soon.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Monthly Chart
        const exportBtn = document.getElementById('exportBtn');
        const monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const monthlyData = @json(array_values($monthlyData));
        const monthlyActiveData = @json(array_values($monthlyActiveData));
        const monthlyInactiveData = @json(array_values($monthlyInactiveData));
        const monthlyExpiringData = @json(array_values($monthlyExpiringData));

        function isDarkMode() {
            return document.documentElement.classList.contains('dark') || 
                   document.body.classList.contains('dark') ||
                   window.matchMedia('(prefers-color-scheme: dark)').matches;
        }

        function getTextColor() {
            return isDarkMode() ? '#FFFFFF' : '#000000';
        }

        function getGridColor() {
            return isDarkMode() ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        }

        function getTooltipBg() {
            return isDarkMode() ? '#1F2937' : '#FFFFFF';
        }

        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [
                    {
                        label: 'Total Members',
                        data: monthlyData,
                        borderColor: '#5E6FFB',
                        backgroundColor: 'rgba(94, 111, 251, 0.2)',
                        yAxisID: 'y',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Active Members',
                        data: monthlyActiveData,
                        borderColor: '#22C55E',
                        backgroundColor: 'rgba(34, 197, 94, 0.2)',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Inactive Members',
                        data: monthlyInactiveData,
                        borderColor: '#EF4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.2)',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Expiring Soon',
                        data: monthlyExpiringData,
                        borderColor: '#F59E0B',
                        backgroundColor: 'rgba(245, 158, 11, 0.2)',
                        borderDash: [5, 5],
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Membership Analysis',
                        font: { size: 16 },
                        color: getTextColor()
                    },
                    tooltip: {
                        backgroundColor: getTooltipBg(),
                        titleColor: getTextColor(),
                        bodyColor: getTextColor(),
                        borderColor: getTextColor(),
                        borderWidth: isDarkMode() ? 0 : 1,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                label += context.parsed.y;
                                return label;
                            }
                        }
                    },
                    legend: { 
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            color: getTextColor()
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { 
                            display: true, 
                            text: 'Total Members',
                            color: getTextColor()
                        },
                        ticks: {
                            color: getTextColor(),
                            precision: 0,
                            callback: function(value) {
                                if (Number.isInteger(value)) return value;
                            },
                            stepSize: 1
                        },
                        grid: {
                            color: getGridColor()
                        },
                        min: 0
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { 
                            drawOnChartArea: false,
                            color: getGridColor()
                        },
                        title: { 
                            display: true, 
                            text: 'Active/Inactive/Expiring Members',
                            color: getTextColor()
                        },
                        ticks: {
                            color: getTextColor(),
                            precision: 0,
                            callback: function(value) {
                                if (Number.isInteger(value)) return value;
                            },
                            stepSize: 1
                        },
                        min: 0
                    },
                    x: {
                        ticks: {
                            color: getTextColor()
                        },
                        grid: {
                            color: getGridColor()
                        }
                    }
                }
            }
        });

        function updateChartColors() {
            const textColor = getTextColor();
            const gridColor = getGridColor();
            const tooltipBg = getTooltipBg();

            monthlyChart.options.plugins.title.color = textColor;
            monthlyChart.options.plugins.tooltip.backgroundColor = tooltipBg;
            monthlyChart.options.plugins.tooltip.titleColor = textColor;
            monthlyChart.options.plugins.tooltip.bodyColor = textColor;
            monthlyChart.options.plugins.tooltip.borderColor = textColor;
            monthlyChart.options.plugins.tooltip.borderWidth = isDarkMode() ? 0 : 1;
            monthlyChart.options.plugins.legend.labels.color = textColor;

            monthlyChart.options.scales.y.title.color = textColor;
            monthlyChart.options.scales.y.ticks.color = textColor;
            monthlyChart.options.scales.y.grid.color = gridColor;
            monthlyChart.options.scales.y1.title.color = textColor;
            monthlyChart.options.scales.y1.ticks.color = textColor;
            monthlyChart.options.scales.y1.grid.color = gridColor;
            monthlyChart.options.scales.x.ticks.color = textColor;
            monthlyChart.options.scales.x.grid.color = gridColor;

            monthlyChart.update();
        }

        // Monthly Chart Export
        exportBtn.addEventListener('click', function() {
            let exportData = [];
            let fileName = 'monthly_membership_data_' + new Date().getFullYear() + '.csv';
            let headers = ['Month', 'Total Members', 'Active Members', 'Inactive Members', 'Expiring Soon'];
            
            exportData = monthlyLabels.map((month, index) => [
                month,
                monthlyData[index] || 0,
                monthlyActiveData[index] || 0,
                monthlyInactiveData[index] || 0,
                monthlyExpiringData[index] || 0
            ]);
            
            const csvContent = [ headers.join(','), ...exportData.map(row => row.join(',')) ].join('\n');          
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Membership Type Chart Export
        const exportMembershipTypeBtn = document.getElementById('exportMembershipTypeBtn');
        exportMembershipTypeBtn.addEventListener('click', function() {
            let exportData = [];
            let fileName = 'membership_type_distribution.csv';
            let headers = ['Membership Type', 'Count', 'Percentage'];
            
            const total = Object.values(@json($membershipTypeCounts)).reduce((a, b) => a + b, 0);
            
            Object.entries(@json($membershipTypeCounts)).forEach(([type, count]) => {
                const percentage = ((count / total) * 100).toFixed(2);
                exportData.push([type, count, `${percentage}%`]);
            });
            
            const csvContent = [ headers.join(','), ...exportData.map(row => row.join(',')) ].join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Section Chart Export
        const exportSectionBtn = document.getElementById('exportSectionBtn');
        exportSectionBtn.addEventListener('click', function() {
            let exportData = [];
            let fileName = 'section_distribution.csv';
            let headers = ['Section', 'Count', 'Percentage'];
            
            const total = Object.values(@json($sectionCounts)).reduce((a, b) => a + b, 0);
            
            Object.entries(@json($sectionCounts)).forEach(([section, count]) => {
                const percentage = ((count / total) * 100).toFixed(2);
                exportData.push([section, count, `${percentage}%`]);
            });
            
            const csvContent = [ headers.join(','), ...exportData.map(row => row.join(',')) ].join('\n');
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.setAttribute('href', url);
            link.setAttribute('download', fileName);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Membership Type Polar Chart
        const membershipTypeCtx = document.getElementById('membershipTypeChart').getContext('2d');
        const membershipTypeData = {
            labels: @json(array_keys($membershipTypeCounts)),
            datasets: [{
                data: @json(array_values($membershipTypeCounts)),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        const membershipTypeChart = new Chart(membershipTypeCtx, {
            type: 'polarArea',
            data: membershipTypeData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'white' : Chart.defaults.plugins.legend.labels.color;
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        },
                        titleColor: function(context) {
                            const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                            return isDarkMode ? 'white' : Chart.defaults.plugins.tooltip.titleColor;
                        },
                        bodyColor: function(context) {
                            const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                            return isDarkMode ? 'white' : Chart.defaults.plugins.tooltip.bodyColor;
                        }
                    }
                },
                scales: {
                    r: {
                        pointLabels: {
                            display: true,
                            centerPointLabels: true,
                            font: {
                                size: 12
                            },
                            color: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'white' : Chart.defaults.scales.radialLinear.pointLabels.color;
                            }
                        },
                        ticks: {
                            display: false,
                            stepSize: 1,
                            backdropColor: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'rgba(0, 0, 0, 0)' : Chart.defaults.scales.radialLinear.ticks.backdropColor;
                            }
                        },
                        angleLines: {
                            color: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'rgba(255, 255, 255, 0.2)' : Chart.defaults.scales.radialLinear.angleLines.color;
                            }
                        },
                        grid: {
                            color: function(context) {
                                const isDarkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                                return isDarkMode ? 'rgba(255, 255, 255, 0.2)' : Chart.defaults.scales.radialLinear.grid.color;
                            }
                        }
                    }
                }
            }
        });

        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', () => {
                membershipTypeChart.update();
            });
        }

        // Section Doughnut Chart 
        const sectionCtx = document.getElementById('sectionChart').getContext('2d');
        const sectionData = {
            labels: @json(array_keys($sectionCounts)),
            datasets: [{
                data: @json(array_values($sectionCounts)),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(199, 199, 199, 0.7)',
                    'rgba(83, 102, 255, 0.7)',
                    'rgba(40, 159, 64, 0.7)',
                    'rgba(210, 99, 132, 0.7)',
                    'rgba(20, 162, 235, 0.7)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(199, 199, 199, 1)',
                    'rgba(83, 102, 255, 1)',
                    'rgba(40, 159, 64, 1)',
                    'rgba(210, 99, 132, 1)',
                    'rgba(20, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        };

        const sectionChart = new Chart(sectionCtx, {
            type: 'doughnut',
            data: sectionData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: getTextColor()
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        },
                        backgroundColor: getTooltipBg(), 
                        titleColor: getTextColor(), 
                        bodyColor: getTextColor(), 
                        borderColor: getTextColor(), 
                        borderWidth: isDarkMode() ? 0 : 1 
                    }
                },
                cutout: '60%',
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        });

        function updateAllChartColors() {
            updateChartColors(); 
            membershipTypeChart.update(); 
            sectionChart.update(); 
        }

        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', updateAllChartColors);
        }

        const observer = new MutationObserver(updateAllChartColors);
        observer.observe(document.documentElement, { 
            attributes: true, 
            attributeFilter: ['class'] 
        });
    });
</script>
</x-app-layout>