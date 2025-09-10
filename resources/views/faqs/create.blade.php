<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                FAQs / Create
            </h2>
                    <a href="{{ route('faqs.index') }}" class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                        bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                        focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                        dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                        w-full md:w-auto mt-4 md:mt-0 text-center">

                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                        Back to Faqs
                    </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form id="faqForm" action="{{ route('faqs.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="question" class="text-sm font-medium">Question</label>
                            <div class="my-3">    
                                <input value="{{ old('question') }}" name="question" id="question" placeholder="Enter question" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('question')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <label for="answer" class="text-sm font-medium">Answer</label>
                            <div class="my-3">    
                                <textarea name="answer" id="answer" placeholder="Enter answer" class="border-gray-300 shadow-sm w-1/2 rounded-lg">{{ old('answer') }}</textarea>
                                @error('answer')
                                <p class="text-red-400 font-medium"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="my-3 flex items-center">
                                <input type="hidden" name="status" value="0">
                                <input type="checkbox" name="status" id="status" class="rounded" value="1" {{ old('status', true) ? 'checked' : '' }}>
                                <label for="status" class="ml-2">Active</label>
                            </div>


                        <div class="mt-6">
                            <button type="button" id="createFaqBtn"
                                class="inline-flex items-center px-5 py-2 text-white bg-[#101966] hover:bg-white hover:text-[#101966] 
                                    border border-white hover:border-[#101966] dark:bg-gray-900 dark:text-white dark:border-gray-100 
                                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg font-medium text-lg transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                Create FAQ
                            </button>
                        </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('createFaqBtn').addEventListener('click', function() {
            Swal.fire({
                title: 'Create FAQ?',
                text: "Are you sure you want to create this FAQ?",
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
                            document.getElementById('faqForm').submit();
                        },
                        background: '#101966',
                        color: '#fff',
                        allowOutsideClick: false
                    });
                }
            });
        });
    </script>
</x-app-layout>