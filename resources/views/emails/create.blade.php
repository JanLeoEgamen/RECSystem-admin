<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                Emails / Create
            </h2>

            <a href="{{ route('emails.index') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                      bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                      focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                      dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                      w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Emails
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="createEmailForm" action="{{ route('emails.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="name" class="text-sm font-medium">Template Name</label>
                            <div class="my-3">    
                                <input name="name" id="name" value="{{ old('name') }}" placeholder="Enter template name" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="subject" class="text-sm font-medium">Email Subject</label>
                            <div class="my-3">    
                                <input name="subject" id="subject" value="{{ old('subject') }}" placeholder="Enter email subject" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('subject')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <label for="body" class="text-sm font-medium">Email Body</label>
                            <div class="my-3">    
                                <textarea name="body" id="body" placeholder="Enter email body" class="border-gray-300 shadow-sm w-full rounded-lg">{{ old('body') }}</textarea>
                                @error('body')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6">
                                <button type="submit" 
                                    class="inline-flex items-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                                           bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                                           focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] 
                                           dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.getElementById('createEmailForm').addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "Do you want to create this email template?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#5e6ffb",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, create it!",
                    cancelButtonText: "Cancel",
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
                                e.target.submit();
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
        </script>
    </x-slot>
</x-app-layout>