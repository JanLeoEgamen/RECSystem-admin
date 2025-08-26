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
                    focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                    dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Emails
            </a>   
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('emails.send') }}" method="POST" enctype="multipart/form-data" id="sendEmailForm">
                @csrf

                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200">Select Members</span>
                    <div class="relative mt-1">
                        <input 
                            type="text" 
                            id="member-search" 
                            placeholder="Search members..." 
                            class="w-full border-gray-300 rounded-lg shadow-sm"
                        >
                        <div class="mt-2 border border-gray-300 rounded-lg shadow-sm max-h-60 overflow-y-auto">
                            <div class="p-2">
                                <label class="inline-flex items-center">
                                    <input 
                                        type="checkbox" 
                                        id="select-all-members" 
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    >
                                    <span class="ml-2">Select All Members</span>
                                </label>
                            </div>
                            <div id="member-checkboxes" class="divide-y divide-gray-200">
                                @foreach ($members as $member)
                                    <div class="p-2 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <label class="inline-flex items-center">
                                            <input 
                                                type="checkbox" 
                                                name="member_ids[]" 
                                                value="{{ $member->id }}" 
                                                class="member-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            >
                                            <span class="ml-2">{{ $member->first_name }} {{ $member->last_name }} ({{ $member->email }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="template" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Choose Template</label>
                    <select name="template" id="template" class="w-full border-gray-300 rounded-lg shadow-sm mt-1">
                        <option value="" disabled selected hidden>Choose a template</option>
                        <option value="custom">Custom Email</option>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="custom-fields" class="mb-4 hidden">
                    <div class="mb-4">
                        <label for="custom_subject" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Custom Subject</label>
                        <input type="text" name="custom_subject" id="custom_subject" class="w-full border-gray-300 rounded-lg shadow-sm mt-1">
                    </div>
                    <div class="mb-4">
                        <label for="custom_message_body" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Custom Message</label>
                        <textarea name="custom_message_body" id="custom_message_body" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm mt-1"></textarea>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="attachments" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Attach Files</label>
                    <input type="file" name="attachments[]" id="attachments" class="w-full border-gray-300 rounded-lg shadow-sm mt-1" multiple>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">You can attach multiple files.</p>
                </div>

                <div class="mb-4 hidden" id="custom-message-wrapper">
                    <label for="custom_message" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Optional Custom Message</label>
                    <textarea name="custom_message" id="custom_message" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm mt-1"></textarea>
                </div>
    
                <button type="button" id="sendEmailButton"
                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                        dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26c.67.36 1.45.36 2.12 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Send Email
                </button>
            </form>
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