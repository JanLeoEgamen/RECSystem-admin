<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Send Certificate: {{ $certificate->title }}
            </h2>
            <a href="{{ route('certificates.preview', $certificate->id) }}" class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Preview
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Send to Members</h3>
                    <form action="{{ route('certificates.send-certificate', $certificate->id) }}" method="post">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Available Members</label>
                            @if($members->count() > 0)
                                <div class="relative mt-1">
                                    <input 
                                        type="text" 
                                        id="member-search" 
                                        placeholder="Search members..." 
                                        class="w-full border-gray-300 rounded-lg shadow-sm"
                                    >
                                    <div class="mt-2 border border-gray-300 rounded-lg shadow-sm max-h-60 overflow-y-auto bg-white dark:bg-gray-800">
                                        <div class="p-2">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input 
                                                    type="checkbox" 
                                                    id="select-all-members" 
                                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                >
                                                <span class="ml-2 select-none">Select All Members</span>
                                            </label>
                                        </div>
                                        <div id="member-checkboxes" class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($members as $member)
                                                <div class="p-2 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                                                    <label class="inline-flex items-center w-full cursor-pointer">
                                                        <input 
                                                            type="checkbox" 
                                                            name="members[]" 
                                                            value="{{ $member->id }}" 
                                                            class="member-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                        >
                                                        <span class="ml-2 select-none">{{ $member->first_name }} {{ $member->last_name }} ({{ $member->email }})</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">All members have already received this certificate.</p>
                            @endif
                        </div>
                        
                        @if($members->count() > 0)
                        <button type="submit" class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                            bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                            focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                            dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                            w-full md:w-auto mt-4 md:mt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Send Certificate
                        </button>
                        @endif
                    </form>
                </div>
            </div>
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-xl font-semibold mb-4">Sent Certificates</h3>
                    @if($sentMembers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Member</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Issued At</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Last Sent</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($sentMembers as $member)
                                    <tr data-certificate-id="{{ $certificate->id }}" data-member-id="{{ $member->id }}">
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $member->first_name }} {{ $member->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ $member->email_address }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">{{ \Carbon\Carbon::parse($member->pivot->issued_at)->format('M d, Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center dark:text-gray-300">
                                            {{ $member->pivot->sent_at ? \Carbon\Carbon::parse($member->pivot->sent_at)->format('M d, Y H:i') : 'Not sent yet' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center space-x-2">
                                                <!-- View Button -->
                                                <a href="{{ route('certificates.view-member', ['certificate' => $certificate->id, 'member' => $member->id]) }}" 
                                                class="p-2 text-blue-600 hover:text-white hover:bg-blue-600 rounded-full transition-colors duration-200" 
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
                                                class="p-2 text-green-600 hover:text-white hover:bg-green-600 rounded-full transition-colors duration-200" 
                                                title="Resend Certificate">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7
                                                            a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </a>

                                                <!-- Download Button -->
                                                <a href="{{ route('certificates.download', ['certificate' => $certificate->id, 'member' => $member->id]) }}" 
                                                class="p-2 text-yellow-600 hover:text-white hover:bg-yellow-600 rounded-full transition-colors duration-200" 
                                                title="Download Certificate">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                                    </svg>
                                                </a>

                                                <!-- Delete Button -->
                                                <a href="javascript:void(0)" 
                                                onclick="confirmDelete({{ $certificate->id }}, {{ $member->id }}, '{{ $member->first_name }} {{ $member->last_name }}')"
                                                class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-full transition-colors duration-200" 
                                                title="Delete Certificate">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4
                                                            a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">No certificates have been sent yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        .notification {
            animation: slideIn 0.3s ease-out forwards;
        }
        
        .notification.hide {
            animation: fadeOut 0.5s ease-out forwards;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script>
    function confirmDelete(certificateId, memberId, memberName) {
        if (confirm(`Are you sure you want to delete the certificate for ${memberName}?`)) {
            // Show loading state
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg bg-blue-500 text-white notification';
            loadingDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="animate-spin h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Deleting certificate...</span>
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

                // Show result notification
                const messageDiv = document.createElement('div');
                messageDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg text-white notification ${
                    data.success ? 'bg-green-500' : 'bg-red-500'
                }`;
                messageDiv.innerHTML = `
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${data.success ? 'M5 13l4 4L19 7' : 'M6 18L18 6M6 6l12 12'}"/>
                        </svg>
                        <span>${data.message}</span>
                    </div>
                `;
                
                document.body.appendChild(messageDiv);
                
                // Auto-remove after 5 seconds
                setTimeout(() => {
                    messageDiv.classList.add('hide');
                    setTimeout(() => messageDiv.remove(), 500);
                }, 5000);
                
                // If successful, remove the table row with animation
                if (data.success) {
                    const row = document.querySelector(`tr[data-certificate-id="${certificateId}"][data-member-id="${memberId}"]`);
                    if (row) {
                        row.style.transition = 'all 0.3s ease';
                        row.style.opacity = '0';
                        row.style.transform = 'translateX(100%)';
                        setTimeout(() => row.remove(), 300);
                    }
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Remove loading notification
                loadingDiv.classList.add('hide');
                setTimeout(() => loadingDiv.remove(), 500);

                // Show error notification
                const messageDiv = document.createElement('div');
                messageDiv.className = 'fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg bg-red-500 text-white notification';
                messageDiv.innerHTML = `
                    <div class="flex items-center">
                        <svg class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        <span>${error.message || 'An error occurred while deleting the certificate'}</span>
                    </div>
                `;
                document.body.appendChild(messageDiv);
                setTimeout(() => {
                    messageDiv.classList.add('hide');
                    setTimeout(() => messageDiv.remove(), 500);
                }, 5000);
            });
        }
    }

    $(document).ready(function() {
        // Select/Deselect all members when "Select All" is toggled
        $('#select-all-members').on('change', function() {
            let checked = $(this).prop('checked');
            $('.member-checkbox').prop('checked', checked);
        });

        // If any individual member checkbox is toggled, update "Select All" accordingly
        $('#member-checkboxes').on('change', '.member-checkbox', function() {
            let allChecked = $('.member-checkbox').length === $('.member-checkbox:checked').length;
            $('#select-all-members').prop('checked', allChecked);
        });

        $('#member-search').on('keyup', function() {
            let searchTerm = $(this).val().toLowerCase();

            $('#member-checkboxes > div').each(function() {
                let memberText = $(this).text().toLowerCase();
                if (memberText.indexOf(searchTerm) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
    </script>
</x-app-layout>