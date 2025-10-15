<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-6 rounded-lg"> 
            <div class="flex items-center space-x-4">
                <div class="bg-white/10 p-3 rounded-full backdrop-blur-sm">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-3xl md:text-4xl text-white leading-tight">
                        Send Certificate
                    </h2>
                    <p class="text-blue-100 text-lg font-medium mt-1">{{ $certificate->title }}</p>
                </div>
            </div>

            <a href="{{ route('certificates.preview', $certificate->id) }}" 
               class="group inline-flex items-center justify-center px-6 py-3 text-white hover:text-[#101966] 
                      bg-white/10 hover:bg-white backdrop-blur-sm border border-white/30 hover:border-[#101966] 
                      font-medium rounded-xl text-lg transition-all duration-300 transform hover:scale-105 
                      shadow-lg hover:shadow-xl w-full md:w-auto">
                <svg class="h-5 w-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Preview
            </a>                
        </div>
    </x-slot>

    <div class="py-8 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <x-message></x-message>
            
            <!-- Send to Members Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-[#101966] to-[#1a237e] p-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white">Send to Members</h3>
                    </div>
                    <p class="text-blue-100 mt-2">Select members to receive this certificate</p>
                </div>
                
                <div class="p-8">
                    <form action="{{ route('certificates.send-certificate', $certificate->id) }}" method="post" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Available Members</label>
                            @if($members->count() > 0)
                                <div class="space-y-4">
                                    <!-- Search Input with Enhanced Styling -->
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <input 
                                            type="text" 
                                            id="member-search" 
                                            placeholder="Search members by name or email..." 
                                            class="block w-full pl-12 pr-4 py-4 text-lg border-2 border-gray-200 dark:border-gray-600 rounded-xl 
                                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400
                                                   focus:ring-2 focus:ring-[#101966] focus:border-[#101966] transition-all duration-200
                                                   shadow-sm hover:shadow-md"
                                        >
                                    </div>
                                    
                                    <!-- Members Selection Box -->
                                    <div class="border-2 border-gray-200 dark:border-gray-600 rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-700 shadow-inner">
                                        <!-- Select All Header -->
                                        <div class="bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-600 dark:to-gray-700 p-4 border-b border-gray-200 dark:border-gray-600">
                                            <label class="flex items-center cursor-pointer group">
                                                <div class="relative">
                                                    <input 
                                                        type="checkbox" 
                                                        id="select-all-members" 
                                                        class="h-5 w-5 rounded border-2 border-gray-300 text-[#101966] 
                                                               focus:ring-2 focus:ring-[#101966] focus:ring-offset-0 transition-all duration-200"
                                                    >
                                                </div>
                                                <span class="ml-3 font-semibold text-gray-900 dark:text-gray-100 group-hover:text-[#101966] dark:group-hover:text-blue-400 transition-colors duration-200">
                                                    Select All Members
                                                </span>
                                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">({{ $members->count() }} available)</span>
                                            </label>
                                        </div>
                                        
                                        <!-- Members List -->
                                        <div id="member-checkboxes" class="max-h-80 overflow-y-auto">
                                            @foreach($members as $member)
                                                <div class="member-item p-4 hover:bg-blue-50 dark:hover:bg-gray-600 cursor-pointer transition-all duration-200 border-b border-gray-100 dark:border-gray-600 last:border-b-0 group">
                                                    <label class="flex items-center cursor-pointer w-full">
                                                        <div class="relative">
                                                            <input 
                                                                type="checkbox" 
                                                                name="members[]" 
                                                                value="{{ $member->id }}" 
                                                                class="member-checkbox h-5 w-5 rounded border-2 border-gray-300 text-[#101966] 
                                                                       focus:ring-2 focus:ring-[#101966] focus:ring-offset-0 transition-all duration-200"
                                                            >
                                                        </div>
                                                        <div class="ml-4 flex-1">
                                                            <div class="flex items-center justify-between">
                                                                <div>
                                                                    <span class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-[#101966] dark:group-hover:text-blue-400 transition-colors duration-200">
                                                                        {{ $member->first_name }} {{ $member->last_name }}
                                                                    </span>
                                                                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                                        {{ $member->email }}
                                                                    </div>
                                                                </div>
                                                                <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                                    <svg class="h-5 w-5 text-[#101966]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-12 bg-gray-50 dark:bg-gray-700 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-xl font-medium text-gray-500 dark:text-gray-400">All members have already received this certificate</p>
                                    <p class="text-gray-400 dark:text-gray-500 mt-2">Check the "Sent Certificates" section below to manage existing certificates</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($members->count() > 0)
                        <div class="pt-6 border-t border-gray-200 dark:border-gray-600">
                            <button type="submit" class="group w-full md:w-auto inline-flex items-center justify-center px-8 py-4 
                                                        text-white bg-gradient-to-r from-[#101966] to-[#1a237e] hover:from-[#0f1654] hover:to-[#151b6b]
                                                        font-bold text-lg rounded-xl transition-all duration-300 transform hover:scale-105 
                                                        shadow-lg hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 group-hover:animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Send Certificates
                                <span class="ml-2 text-sm opacity-80">to selected members</span>
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
            
            <!-- Sent Certificates Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden transform transition-all duration-300 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 p-6">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-white">Sent Certificates</h3>
                            <p class="text-green-100 mt-1">Manage previously sent certificates</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-8">
                    @if($sentMembers->count() > 0)
                        <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-600 shadow-lg">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600">
                                        <tr>
                                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <span>Member</span>
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                                    </svg>
                                                    <span>Email</span>
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Issued At</span>
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    <span>Last Sent</span>
                                                </div>
                                            </th>
                                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                    </svg>
                                                    <span>Actions</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($sentMembers as $member)
                                        <tr data-certificate-id="{{ $certificate->id }}" data-member-id="{{ $member->id }}" 
                                            class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-200 group">
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm mr-3">
                                                        {{ strtoupper(substr($member->first_name, 0, 1) . substr($member->last_name, 0, 1)) }}
                                                    </div>
                                                    <div class="text-left">
                                                        <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                            {{ $member->first_name }} {{ $member->last_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="text-sm text-gray-900 dark:text-gray-100 font-medium">{{ $member->email_address }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex items-center justify-center">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($member->pivot->issued_at)->format('M d, Y') }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @if($member->pivot->sent_at)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($member->pivot->sent_at)->format('M d, Y H:i') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">
                                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <div class="flex justify-center items-center space-x-1">
                                                    <!-- View Button -->
                                                    <a href="{{ route('certificates.view-member', ['certificate' => $certificate->id, 'member' => $member->id]) }}" 
                                                       class="group inline-flex items-center justify-center w-10 h-10 text-blue-600 hover:text-white hover:bg-blue-600 rounded-lg transition-all duration-200 transform hover:scale-110 shadow-sm hover:shadow-md" 
                                                       title="View Certificate" target="_blank">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                                                                -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>

                                                    <!-- Resend Button -->
                                                    <a href="{{ route('certificates.resend', ['certificate' => $certificate->id, 'member' => $member->id]) }}" 
                                                       class="group inline-flex items-center justify-center w-10 h-10 text-green-600 hover:text-white hover:bg-green-600 rounded-lg transition-all duration-200 transform hover:scale-110 shadow-sm hover:shadow-md" 
                                                       title="Resend Certificate">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7
                                                                a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                        </svg>
                                                    </a>

                                                    <!-- Download Dropdown Button -->
                                                    <!-- <div class="relative dropdown-container" id="dropdown-container-{{ $certificate->id }}-{{ $member->id }}">
                                                        <button onclick="toggleDownloadMenu('{{ $certificate->id }}-{{ $member->id }}')" 
                                                                class="group inline-flex items-center justify-center w-10 h-10 text-yellow-600 hover:text-white hover:bg-yellow-600 rounded-lg transition-all duration-200 transform hover:scale-110 shadow-sm hover:shadow-md" 
                                                                title="Download Certificate">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                                            </svg>
                                                        </button>
                                                    </div> -->

                                                    <!-- Delete Button -->
                                                    <button onclick="confirmDelete({{ $certificate->id }}, {{ $member->id }}, '{{ $member->first_name }} {{ $member->last_name }}')"
                                                            class="group inline-flex items-center justify-center w-10 h-10 text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200 transform hover:scale-110 shadow-sm hover:shadow-md" 
                                                            title="Delete Certificate">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4
                                                                a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16 bg-gray-50 dark:bg-gray-700 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600">
                            <svg class="mx-auto h-20 w-20 text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">No certificates sent yet</h3>
                            <p class="text-gray-500 dark:text-gray-400 text-lg">Start by selecting members above to send certificates to them</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown Portal Container -->
    <div id="dropdown-portal" style="position: fixed; top: 0; left: 0; z-index: 10000; pointer-events: none;"></div>

    <style>
        /* Enhanced animations */
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% { transform: translateY(0); }
            40%, 43% { transform: translateY(-10px); }
            70% { transform: translateY(-5px); }
            90% { transform: translateY(-2px); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        
        .notification {
            animation: slideIn 0.3s ease-out forwards;
        }
        
        .notification.hide {
            animation: fadeOut 0.5s ease-out forwards;
        }

        .member-item:hover {
            transform: translateX(4px);
        }

        .card-hover:hover {
            transform: translateY(-2px);
        }

        .btn-pulse:hover {
            animation: pulse 1s infinite;
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }

        /* Custom scrollbar for member list */
        #member-checkboxes::-webkit-scrollbar {
            width: 8px;
        }

        #member-checkboxes::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-600 rounded-lg;
        }

        #member-checkboxes::-webkit-scrollbar-thumb {
            @apply bg-gray-300 dark:bg-gray-500 rounded-lg;
        }

        #member-checkboxes::-webkit-scrollbar-thumb:hover {
            @apply bg-gray-400 dark:bg-gray-400;
        }

        /* Dropdown styles */
        .dropdown-menu {
            position: absolute !important;
            z-index: 9999 !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
            backdrop-filter: blur(10px);
        }

        .dropdown-container {
            position: relative;
            z-index: 50;
        }

        .dropdown-container.active {
            z-index: 9999 !important;
        }

        /* Enhanced table row hover */
        tbody tr:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Loading states */
        .loading-pulse {
            animation: pulse 2s infinite;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(45deg, #101966, #1a237e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* SweetAlert Custom Styles */
        .swal-custom-popup {
            border-radius: 16px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
        }

        .swal-custom-title {
            color: #fff !important;
            font-weight: 700 !important;
            font-size: 1.5rem !important;
        }

        .swal-custom-content {
            color: #e5e7eb !important;
            font-size: 1rem !important;
        }

        .swal-custom-confirm {
            background: linear-gradient(45deg, #dc2626, #b91c1c) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .swal-custom-confirm:hover {
            background: linear-gradient(45deg, #b91c1c, #991b1b) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 8px 16px rgba(220, 38, 38, 0.3) !important;
        }

        .swal-custom-cancel {
            background: linear-gradient(45deg, #6b7280, #4b5563) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 10px 24px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
            color: #fff !important;
        }

        .swal-custom-cancel:hover {
            background: linear-gradient(45deg, #4b5563, #374151) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 8px 16px rgba(107, 114, 128, 0.3) !important;
        }

        /* Override SweetAlert icon colors for better visibility */
        .swal2-icon.swal2-warning {
            border-color: #f59e0b !important;
            color: #f59e0b !important;
        }

        .swal2-icon.swal2-warning .swal2-icon-content {
            color: #f59e0b !important;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Enhanced delete confirmation with SweetAlert
    function confirmDelete(certificateId, memberId, memberName) {
        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to delete the certificate for ${memberName}? This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            background: '#101966',
            color: '#fff',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal-custom-title',
                content: 'swal-custom-content',
                confirmButton: 'swal-custom-confirm',
                cancelButton: 'swal-custom-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
            // Show enhanced loading state
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'fixed top-4 right-4 z-50 p-6 rounded-xl shadow-2xl bg-gradient-to-r from-blue-500 to-purple-600 text-white notification';
            loadingDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="animate-spin h-8 w-8 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <div>
                        <div class="font-bold text-lg">Deleting certificate...</div>
                        <div class="text-sm opacity-90">Please wait while we process your request</div>
                    </div>
                </div>
            `;
            document.body.appendChild(loadingDiv);

            fetch(`/certificates/${certificateId}/member/${memberId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                // Remove loading notification
                loadingDiv.classList.add('hide');
                setTimeout(() => loadingDiv.remove(), 500);

                // Show enhanced result notification
                const messageDiv = document.createElement('div');
                messageDiv.className = `fixed top-4 right-4 z-50 p-6 rounded-xl shadow-2xl text-white notification ${
                    data.success ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-red-500 to-pink-600'
                }`;
                messageDiv.innerHTML = `
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${data.success ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z'}"/>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-lg">${data.success ? 'Success!' : 'Error!'}</div>
                            <div class="text-sm opacity-90">${data.message}</div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(messageDiv);
                
                // Auto-remove after 5 seconds
                setTimeout(() => {
                    messageDiv.classList.add('hide');
                    setTimeout(() => messageDiv.remove(), 500);
                }, 5000);
                
                // If successful, remove the table row with enhanced animation
                if (data.success) {
                    const row = document.querySelector(`tr[data-certificate-id="${certificateId}"][data-member-id="${memberId}"]`);
                    if (row) {
                        row.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(100%) scale(0.9)';
                        setTimeout(() => {
                            row.remove();
                            // Reload if this was the last row
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                window.location.reload();
                            }
                        }, 500);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Remove loading notification
                loadingDiv.classList.add('hide');
                setTimeout(() => loadingDiv.remove(), 500);

                // Show enhanced error notification
                const messageDiv = document.createElement('div');
                messageDiv.className = 'fixed top-4 right-4 z-50 p-6 rounded-xl shadow-2xl bg-gradient-to-r from-red-500 to-pink-600 text-white notification';
                messageDiv.innerHTML = `
                    <div class="flex items-center">
                        <svg class="h-8 w-8 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div>
                            <div class="font-bold text-lg">Error!</div>
                            <div class="text-sm opacity-90">${error.message || 'An error occurred while deleting the certificate'}</div>
                        </div>
                    </div>
                `;
                document.body.appendChild(messageDiv);
                setTimeout(() => {
                    messageDiv.classList.add('hide');
                    setTimeout(() => messageDiv.remove(), 500);
                }, 5000);
            });
            }
        });
    }

    // Enhanced download dropdown functionality (similar to list.blade.php)
    window.toggleDownloadMenu = function(id) {
        const button = document.querySelector(`#dropdown-container-${id} button`);
        const portal = document.getElementById('dropdown-portal');
        const existingMenu = document.getElementById(`download-menu-${id}`);
        
        // Close any existing dropdown
        portal.innerHTML = '';
        
        if (existingMenu) {
            return;
        }
        
        // Create enhanced dropdown menu
        const dropdown = document.createElement('div');
        dropdown.id = `download-menu-${id}`;
        dropdown.className = 'bg-white rounded-xl shadow-2xl border border-gray-200 dark:bg-gray-800 dark:border-gray-600 overflow-hidden backdrop-blur-lg';
        
        const updatePosition = () => {
            const rect = button.getBoundingClientRect();
            const isMobile = window.innerWidth <= 768;
            const viewportHeight = window.innerHeight;
            const viewportWidth = window.innerWidth;
            
            if (rect.bottom < 0 || rect.top > viewportHeight || rect.right < 0 || rect.left > viewportWidth) {
                dropdown.style.display = 'none';
                return;
            } else {
                dropdown.style.display = 'block';
            }
            
            if (isMobile) {
                dropdown.className = dropdown.className.replace(/w-\d+/, 'w-64');
                const dropdownWidth = 256;
                
                const tableContainer = document.querySelector('.overflow-x-auto');
                const containerRect = tableContainer ? tableContainer.getBoundingClientRect() : null;
                
                let left;
                
                if (containerRect) {
                    const containerLeft = containerRect.left + 8;
                    const containerRight = containerRect.right - 8;
                    
                    let preferredLeft = rect.left - (dropdownWidth / 2) + (rect.width / 2);
                    
                    if (preferredLeft < containerLeft) {
                        left = containerLeft;
                    } else if (preferredLeft + dropdownWidth > containerRight) {
                        left = containerRight - dropdownWidth;
                    } else {
                        left = preferredLeft;
                    }
                } else {
                    left = rect.left - (dropdownWidth / 2) + (rect.width / 2);
                    left = Math.max(16, Math.min(left, viewportWidth - dropdownWidth - 16));
                }
                
                let top = rect.bottom + 8;
                if (top + 200 > viewportHeight) {
                    top = rect.top - 200 - 8;
                }
                
                dropdown.style.cssText = `
                    position: fixed;
                    top: ${top}px;
                    left: ${left}px;
                    z-index: 10000;
                    pointer-events: auto;
                    display: block;
                    max-width: calc(100vw - 32px);
                    width: 256px;
                `;
            } else {
                dropdown.className = dropdown.className.replace(/w-\d+/, 'w-72');
                const dropdownWidth = 288;
                let left = rect.right - dropdownWidth;
                
                if (left < 16) {
                    left = rect.left;
                }
                if (left + dropdownWidth > viewportWidth - 16) {
                    left = viewportWidth - dropdownWidth - 16;
                }
                
                let top = rect.bottom + 8;
                if (top + 200 > viewportHeight) {
                    top = rect.top - 200 - 8;
                }
                
                dropdown.style.cssText = `
                    position: fixed;
                    top: ${top}px;
                    left: ${left}px;
                    z-index: 10000;
                    pointer-events: auto;
                    display: block;
                `;
            }
        };
        
        // Extract certificate and member IDs from the combined ID
        const [certificateId, memberId] = id.split('-');
        
        dropdown.innerHTML = `
            <div class="bg-gradient-to-r from-[#101966] to-[#5e6ffb] px-4 py-3 text-white">
                <div class="flex items-center space-x-2">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">Download Certificate</span>
                </div>
                <p class="text-xs opacity-90 mt-1">Choose your preferred format</p>
            </div>
            <div class="p-2">
                <a href="/certificates/${certificateId}/download-image/${memberId}" 
                   class="group block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500 group-hover:text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400">PNG Format</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Perfect quality • Transparent background</div>
                        </div>
                        <svg class="h-4 w-4 text-gray-400 group-hover:text-blue-500 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
                <a href="/certificates/${certificateId}/download-image/${memberId}/jpeg" 
                   class="group block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-purple-50 dark:hover:bg-gray-700 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-purple-500 group-hover:text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-purple-600 dark:group-hover:text-purple-400">JPEG Format</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Smaller file size • Universal compatibility</div>
                        </div>
                        <svg class="h-4 w-4 text-gray-400 group-hover:text-purple-500 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>
        `;
        
        portal.appendChild(dropdown);
        updatePosition();
        
        dropdown.updatePosition = updatePosition;
        
        const addScrollListeners = () => {
            window.addEventListener('scroll', updatePosition, { passive: true });
            window.addEventListener('resize', updatePosition, { passive: true });
            const scrollContainer = document.querySelector('.overflow-x-auto');
            if (scrollContainer) {
                scrollContainer.addEventListener('scroll', updatePosition, { passive: true });
            }
        };
        
        const removeScrollListeners = () => {
            window.removeEventListener('scroll', updatePosition);
            window.removeEventListener('resize', updatePosition);
            const scrollContainer = document.querySelector('.overflow-x-auto');
            if (scrollContainer) {
                scrollContainer.removeEventListener('scroll', updatePosition);
            }
        };
        
        dropdown.cleanup = removeScrollListeners;
        addScrollListeners();
    };

    $(document).ready(function() {
        // Enhanced member selection functionality
        $('#select-all-members').on('change', function() {
            let checked = $(this).prop('checked');
            $('.member-checkbox:visible').each(function() {
                $(this).prop('checked', checked);
                // Add visual feedback
                if (checked) {
                    $(this).closest('.member-item').addClass('bg-blue-50 dark:bg-gray-600');
                } else {
                    $(this).closest('.member-item').removeClass('bg-blue-50 dark:bg-gray-600');
                }
            });
        });

        $('#member-checkboxes').on('change', '.member-checkbox', function() {
            let allVisible = $('.member-checkbox:visible').length;
            let checkedVisible = $('.member-checkbox:visible:checked').length;
            $('#select-all-members').prop('checked', allVisible === checkedVisible && allVisible > 0);
            
            // Visual feedback
            if ($(this).prop('checked')) {
                $(this).closest('.member-item').addClass('bg-blue-50 dark:bg-gray-600');
            } else {
                $(this).closest('.member-item').removeClass('bg-blue-50 dark:bg-gray-600');
            }
        });

        // Enhanced search functionality
        $('#member-search').on('keyup', function() {
            let searchTerm = $(this).val().toLowerCase();

            $('#member-checkboxes .member-item').each(function() {
                let memberText = $(this).text().toLowerCase();
                if (memberText.indexOf(searchTerm) !== -1) {
                    $(this).show().addClass('animate__fadeIn');
                } else {
                    $(this).hide().removeClass('animate__fadeIn');
                }
            });

            // Update select all checkbox state after search
            let allVisible = $('.member-checkbox:visible').length;
            let checkedVisible = $('.member-checkbox:visible:checked').length;
            $('#select-all-members').prop('checked', allVisible === checkedVisible && allVisible > 0);
        });

        // Add entrance animations to existing elements
        $('.member-item').each(function(index) {
            $(this).css('animation-delay', (index * 0.1) + 's');
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const portal = document.getElementById('dropdown-portal');
        if (!event.target.closest('[onclick^="toggleDownloadMenu"]') && !event.target.closest('#dropdown-portal')) {
            const dropdowns = portal.querySelectorAll('[id^="download-menu-"]');
            dropdowns.forEach(dropdown => {
                if (dropdown.cleanup) {
                    dropdown.cleanup();
                }
            });
            portal.innerHTML = '';
        }
    });
    </script>
</x-app-layout>