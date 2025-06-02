<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Send Email to Members
            </h2>
            <a href="{{ route('emails.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Emails
            </a>   
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            @if (session('success'))
                <div 
                    x-data="{ show: true }" 
                    x-init="setTimeout(() => show = false, 3000)" 
                    x-show="show"
                    class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow"
                >
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg shadow">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('emails.send') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Select Member</label>
                    <select id="member_select" name="member_id" class="w-full border-gray-300 rounded-lg shadow-sm mt-1">
                        <option value="" disabled selected hidden>Select a member</option>
                        <option value="all">All Members</option> <!-- Optional all option -->
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->first_name }} {{ $member->last_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="template" class ="block text-sm font-medium text-gray-700 dark:text-gray-200">Choose Template</label>
                    <select name="template" id="template" class="w-full border-gray-300 rounded-lg shadow-sm mt-1">
                        <option value="" disabled selected hidden>Choose a template</option>
                        <option value="custom">Custom Email</option>
                        @foreach ($templates as $template)
                            <option value="{{ $template->id }}">{{ $template->name }}</option>
                        @endforeach
                    </select>
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

                <div class="mb-4" id="custom-message-wrapper">
                    <label for="custom_message" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Optional Custom Message</label>
                    <textarea name="custom_message" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm mt-1"></textarea>
                </div>
    
                <button type="submit"
                    class="px-6 py-2 bg-[#1e40af] text-white rounded-lg hover:bg-[#112244] focus:ring-2 focus:ring-offset-2 focus:ring-[#1e40af]">
                    Send Email
                </button>
            </form>
        </div>
    </div>

    <x-slot name="script">
        <!-- CSS and JS for Select2 and validation -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        <script>
            $(document).ready(function () {
                $('#member_select').select2({
                    placeholder: "Select a member",
                    width: '100%',
                    allowClear: true
                });

                $('#template').select2({
                    placeholder: "Choose a template",
                    width: '100%',
                    allowClear: true
                });

                function toggleCustomFields() {
                    const selectedTemplate = $('#template').val();
                    const isCustom = selectedTemplate === 'custom';

                    $('#custom-fields').toggleClass('hidden', !isCustom);         
                    $('#custom-message-wrapper').toggleClass('hidden', isCustom);
                }

                $('#template').on('change', toggleCustomFields);

                // Run on load in case of form repopulation
                toggleCustomFields();

                $('form').on('submit', function (e) {
                    const member = $('#member_select').val();
                    const template = $('#template').val();

                    if (!member || !template) {
                        e.preventDefault();
                        alert("Please select both a member and a template.");
                        return;
                    }

                    if (template === 'custom') {
                        const subject = $('#custom_subject').val().trim();
                        const message = $('#custom_message_body').val().trim();
                        if (!subject || !message) {
                            e.preventDefault();
                            alert("Please provide both a subject and message for the custom email.");
                        }
                    }
                });
            });
        </script>

    </x-slot>
</x-app-layout>
