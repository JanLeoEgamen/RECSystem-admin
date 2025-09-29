<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Certificate Templates / Create
            </h2>
            <a href="{{ route('certificates.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Certificates
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="createCertificateForm" action="{{ route('certificates.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="title" class="text-sm font-medium">Title</label>
                            <div class="my-3">    
                                <input value="{{ old('title') }}" name="title" id="title" placeholder="Enter certificate title" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('title')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <span class="text-sm font-medium">Content</span>
                            <div class="my-3">    
                                <textarea id="content" name="content" class="border-gray-300 shadow-sm w-full rounded-lg">{{ old('content') }}</textarea>
                                @error('content')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <span class="text-sm font-medium">Signatories</span>
                            <div class="my-3" id="signatories-container">
                                <div class="signatory-row flex items-center space-x-4 mb-2">
                                    <input type="text" name="signatories[0][name]" placeholder="Name" class="border-gray-300 shadow-sm rounded-lg w-1/3" required>
                                    <input type="text" name="signatories[0][position]" placeholder="Position" class="border-gray-300 shadow-sm rounded-lg w-1/3">
                                    <button type="button" class="remove-signatory text-red-600 hover:text-red-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-signatory" 
                                class="mt-4 flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                    bg-[#10b981] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-[#10b981] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-sm leading-normal transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Signatory
                            </button>

                            <div class="mt-6">
                                <button type="button" id="createCertificateButton"
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-xl leading-normal transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create Certificate Template
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <style>
        .btn-disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
        </style>
        <script>
            CKEDITOR.replace('content');

            let signatoryCount = 1;
            const MAX_SIGNATORIES = 3;

            $('#add-signatory').click(function() {
                const currentCount = $('.signatory-row').length;
                
                if (currentCount >= MAX_SIGNATORIES) {
                    Swal.fire({
                        icon: "warning",
                        title: "Maximum Reached",
                        text: `You can only add up to ${MAX_SIGNATORIES} signatories.`,
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                const newRow = `
                    <div class="signatory-row flex items-center space-x-4 mb-2">
                        <input type="text" name="signatories[${signatoryCount}][name]" placeholder="Name" class="border-gray-300 shadow-sm rounded-lg w-1/3" required>
                        <input type="text" name="signatories[${signatoryCount}][position]" placeholder="Position" class="border-gray-300 shadow-sm rounded-lg w-1/3">
                        <button type="button" class="remove-signatory text-red-600 hover:text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                `;
                $('#signatories-container').append(newRow);
                signatoryCount++;
                
                // Hide add button if max reached
                if ($('.signatory-row').length >= MAX_SIGNATORIES) {
                    $('#add-signatory').hide();
                }
            });

            $(document).on('click', '.remove-signatory', function() {
                if ($('.signatory-row').length > 1) {
                    $(this).closest('.signatory-row').remove();
                    // Show add button if below max
                    if ($('.signatory-row').length < MAX_SIGNATORIES) {
                        $('#add-signatory').show();
                    }
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: "Cannot Remove",
                        text: "At least one signatory is required.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                }
            });

            $('#createCertificateButton').click(function(e) {
                e.preventDefault();

                for (let instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }

                const title = $('input[name="title"]').val().trim();
                const content = CKEDITOR.instances.content.getData().trim();
                
                if (!title) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Title",
                        text: "Please provide a certificate title.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                if (!content) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Content",
                        text: "Please provide certificate content.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                let hasValidSignatory = false;
                $('.signatory-row input[name*="[name]"]').each(function() {
                    if ($(this).val().trim()) {
                        hasValidSignatory = true;
                        return false; 
                    }
                });

                if (!hasValidSignatory) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Signatory",
                        text: "Please provide at least one signatory name.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                // Validate signatory count
                const signatoryCount = $('.signatory-row').length;
                if (signatoryCount > MAX_SIGNATORIES) {
                    Swal.fire({
                        icon: "warning",
                        title: "Too Many Signatories",
                        text: `You can only have up to ${MAX_SIGNATORIES} signatories.`,
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Create Certificate Template?',
                    text: "Are you sure you want to create this certificate template?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5e6ffb',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, create it!',
                    cancelButtonText: 'Cancel',
                    background: '#101966',
                    color: '#fff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Creating...',
                            text: 'Please wait',
                            timer: 1500,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                            willClose: () => {
                                document.getElementById('createCertificateForm').submit();
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
                    title: "Created!",
                    text: "{{ session('success') }}",
                    confirmButtonColor: "#101966",
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
        </script>
    </x-slot>
</x-app-layout>