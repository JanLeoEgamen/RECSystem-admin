<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Send Email <span class="block md:hidden">to Members</span>
                <span class="hidden md:inline">to Members</span>
            </h2>

            <a href="{{ route('emails.index') }}" 
            class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Emails
            </a>   
        </div>
    </x-slot>

    <div class="py-4 sm:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 overflow-hidden shadow-2xl sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Header Section -->
                    <div class="mb-6 sm:mb-8">
                        <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                            <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-blue-500 to-cyan-600 shadow-md">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26c.67.36 1.45.36 2.12 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Send Email Campaign</h3>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 p-4 sm:p-5 rounded-lg border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20">
                            <p class="text-sm font-semibold text-red-800 dark:text-red-300 mb-3 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                                </svg>
                                <strong>Please fix the following errors:</strong>
                            </p>
                            <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-400 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

            <form action="{{ route('emails.send') }}" method="POST" enctype="multipart/form-data" id="sendEmailForm">
                @csrf

                <!-- Members Selection Section -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                        <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Select Members</h4>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-5 rounded-lg border border-gray-200 dark:border-gray-600">
                        <div class="mb-4">
                            <input 
                                type="text" 
                                id="member-search" 
                                placeholder="Search members by name or email..." 
                                class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-purple-500 dark:focus:border-purple-500 focus:ring-purple-500 dark:focus:ring-purple-500 transition-colors duration-200 shadow-sm hover:shadow-md"
                            >
                        </div>

                        <div class="border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm overflow-hidden">
                            <div class="p-3 sm:p-4 border-b border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800/50">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        id="select-all-members" 
                                        class="rounded border-gray-300 dark:border-gray-600 text-purple-600 dark:text-purple-500 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 dark:focus:ring-purple-900 focus:ring-opacity-50 transition-colors"
                                    >
                                    <span class="ml-2 font-semibold text-gray-700 dark:text-gray-200">Select All Members</span>
                                </label>
                            </div>
                            <div id="member-checkboxes" class="divide-y divide-gray-200 dark:divide-gray-600 max-h-72 overflow-y-auto">
                                @foreach ($members as $member)
                                    <div class="p-3 sm:p-4 hover:bg-purple-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input 
                                                type="checkbox" 
                                                name="member_ids[]" 
                                                value="{{ $member->id }}" 
                                                class="member-checkbox rounded border-gray-300 dark:border-gray-600 text-purple-600 dark:text-purple-500 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 dark:focus:ring-purple-900 focus:ring-opacity-50 transition-colors"
                                            >
                                            <span class="ml-2 text-sm text-gray-900 dark:text-gray-100">
                                                <span class="font-medium">{{ $member->first_name }} {{ $member->last_name }}</span>
                                                <span class="text-gray-500 dark:text-gray-400">({{ $member->email }})</span>
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Template Selection Section -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                        <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 shadow-md">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">Choose Template</h4>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-5 rounded-lg border border-gray-200 dark:border-gray-600">
                        <label for="template" class="block text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Email Template *</label>
                        <select name="template" id="template" class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-amber-500 dark:focus:border-amber-500 focus:ring-amber-500 dark:focus:ring-amber-500 transition-colors duration-200 font-medium bg-white shadow-sm hover:shadow-md">
                            <option value="" disabled selected hidden>-- Select a template --</option>
                            <option value="custom">📝 Custom Email</option>
                            @foreach ($templates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Custom Email Section -->
                <div id="custom-fields" class="mb-6 sm:mb-8 hidden">
                    <div class="space-y-4 sm:space-y-6">
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-5 rounded-lg border border-gray-200 dark:border-gray-600">
                            <label for="custom_subject" class="block text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Email Subject *</label>
                            <input type="text" name="custom_subject" id="custom_subject" placeholder="Enter email subject..." class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-amber-500 dark:focus:border-amber-500 focus:ring-amber-500 dark:focus:ring-amber-500 transition-colors duration-200 shadow-sm hover:shadow-md">
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-5 rounded-lg border border-gray-200 dark:border-gray-600">
                            <label for="custom_message_body" class="block text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Email Message *</label>
                            <textarea name="custom_message_body" id="custom_message_body" rows="6" placeholder="Enter your email message..." class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-amber-500 dark:focus:border-amber-500 focus:ring-amber-500 dark:focus:ring-amber-500 transition-colors duration-200 shadow-sm hover:shadow-md resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Optional Custom Message Section -->
                <div class="mb-6 sm:mb-8 hidden" id="custom-message-wrapper">
                    <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                        <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 shadow-md">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <h4 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Additional Notes</h4>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-5 rounded-lg border border-gray-200 dark:border-gray-600">
                        <label for="custom_message" class="block text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Optional Custom Message</label>
                        <textarea name="custom_message" id="custom_message" rows="4" placeholder="Add any additional notes or customizations..." class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-emerald-500 dark:focus:border-emerald-500 focus:ring-emerald-500 dark:focus:ring-emerald-500 transition-colors duration-200 shadow-sm hover:shadow-md resize-none"></textarea>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div class="mb-6 sm:mb-8">
                    <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                        <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-gradient-to-br from-rose-500 to-red-600 shadow-md">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg sm:text-xl font-bold bg-gradient-to-r from-rose-600 to-red-600 bg-clip-text text-transparent">Attachments</h4>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 p-4 sm:p-5 rounded-lg border border-gray-200 dark:border-gray-600 border-dashed">
                        <label for="attachments" class="block text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-3">Attach Files (Optional)</label>
                        <input type="file" name="attachments[]" id="attachments" class="w-full px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-rose-500 dark:focus:border-rose-500 focus:ring-rose-500 dark:focus:ring-rose-500 transition-colors duration-200 shadow-sm hover:shadow-md" multiple>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">💡 You can attach multiple files to send with your email.</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row items-center justify-start gap-3 sm:gap-4 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" id="sendEmailButton"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 sm:px-8 py-2.5 sm:py-3 text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 border-2 border-transparent font-bold rounded-xl text-base sm:text-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26c.67.36 1.45.36 2.12 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Send Email Campaign
                    </button>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <x-slot name="script">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <script>
            $(document).ready(function () {
                $('#member-search').on('keyup', function() {
                    const searchText = $(this).val().toLowerCase();
                    $('#member-checkboxes div').each(function() {
                        const memberText = $(this).text().toLowerCase();
                        $(this).toggle(memberText.includes(searchText));
                    });
                });

                $('#select-all-members').change(function() {
                    const isChecked = $(this).prop('checked');
                    $('.member-checkbox').prop('checked', isChecked);
                    
                    if (isChecked) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'select_all',
                            value: '1'
                        }).appendTo('form');
                    } else {
                        $('input[name="select_all"]').remove();
                    }
                });

                $('#member-checkboxes').on('change', '.member-checkbox', function() {
                    if (!$(this).prop('checked')) {
                        $('#select-all-members').prop('checked', false);
                        $('input[name="select_all"]').remove();
                    }
                    
                    const allChecked = $('.member-checkbox:checked').length === $('.member-checkbox').length;
                    $('#select-all-members').prop('checked', allChecked);
                    if (allChecked) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'select_all',
                            value: '1'
                        }).appendTo('form');
                    }
                });

                function toggleCustomFields() {
                    const selectedTemplate = $('#template').val();
                    const isCustom = selectedTemplate === 'custom';

                    $('#custom-fields').toggleClass('hidden', !isCustom);         
                    $('#custom-message-wrapper').toggleClass('hidden', isCustom);
                }

                $('#template').on('change', toggleCustomFields);
                toggleCustomFields();

                $('#sendEmailButton').click(function(e) {
                    e.preventDefault();
                    
                    const selectedMembers = $('input[name="member_ids[]"]:checked').length;
                    const template = $('#template').val();
                    const isSelectAll = $('input[name="select_all"]').length > 0;

                    if ((selectedMembers === 0 && !isSelectAll) || !template) {
                        Swal.fire({
                            icon: "warning",
                            title: "Incomplete Selection",
                            text: "Please select at least one member and a template.",
                            confirmButtonColor: "#5e6ffb",
                            background: '#101966',
                            color: '#fff'
                        });
                        return;
                    }

                    if (template === 'custom') {
                        const subject = $('#custom_subject').val().trim();
                        const message = $('#custom_message_body').val().trim();
                        if (!subject || !message) {
                            Swal.fire({
                                icon: "warning",
                                title: "Custom Email Incomplete",
                                text: "Please provide both a subject and message for the custom email.",
                                confirmButtonColor: "#5e6ffb",
                                background: '#101966',
                                color: '#fff'
                            });
                            return;
                        }
                    }

                    Swal.fire({
                        title: 'Send Email?',
                        text: "Are you sure you want to send this email to the selected members?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#5e6ffb',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, send it!',
                        cancelButtonText: 'Cancel',
                        background: '#101966',
                        color: '#fff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Sending Email...',
                                text: 'Please wait while we send your email',
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                                willClose: () => {
                                    document.getElementById('sendEmailForm').submit();
                                },
                                background: '#101966',
                                color: '#fff',
                                allowOutsideClick: false
                            });
                        }
                    });
                });

                @if(session('success'))
                    Swal.fire({
                        icon: "success",
                        title: "Email Sent!",
                        text: "{{ session('success') }}",
                        confirmButtonColor: "#5e6ffb",
                        background: '#101966',
                        color: '#fff'
                    });
                @endif

                @if(session('error'))
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "{{ session('error') }}",
                        confirmButtonColor: "#5e6ffb",
                        background: '#101966',
                        color: '#fff'
                    });
                @endif
            });
        </script>
    </x-slot>
</x-app-layout>