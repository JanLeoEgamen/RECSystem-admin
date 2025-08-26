<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-2xl sm:text-4xl text-white dark:text-gray-200 leading-tight text-center sm:text-left">
                {{ __('Edit Bureau or Section') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('bureau-section.store') }}" method="POST" id="createForm">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                                <option value="">Select Type</option>
                                <option value="bureau" {{ old('type') == 'bureau' ? 'selected' : '' }}>Bureau</option>
                                <option value="section" {{ old('type') == 'section' ? 'selected' : '' }}>Section</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="bureauFields">
                            <div class="mb-6">
                                <label for="bureau_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bureau Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="bureau_name" id="bureau_name" value="{{ old('bureau_name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                    placeholder="Enter bureau name">
                                @error('bureau_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="sectionFields" class="hidden">
                            <div class="mb-6">
                                <label for="bureau_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Bureau <span class="text-red-500">*</span>
                                </label>
                                <select name="bureau_id" id="bureau_id"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300">
                                    <option value="">Select Bureau</option>
                                    @foreach($bureaus as $bureau)
                                        <option value="{{ $bureau->id }}" {{ old('bureau_id') == $bureau->id ? 'selected' : '' }}>
                                            {{ $bureau->bureau_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bureau_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="section_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Section Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="section_name" id="section_name" value="{{ old('section_name') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                    placeholder="Enter section name">
                                @error('section_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('bureau-section.index') }}"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition">
                                Cancel
                            </a>
                            <button type="button" id="createButton"
                                class="px-4 py-2 bg-[#101966] dark:bg-blue-600 text-white rounded-lg hover:bg-[#0e1552] dark:hover:bg-blue-700 transition">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-slot name="script">
        <script>
            document.getElementById("createButton").addEventListener("click", function() {
                const typeSelect = document.getElementById('type');
                const selectedType = typeSelect.value;
                
                if (!selectedType) {
                    Swal.fire({
                        icon: "warning",
                        title: "Please select a type",
                        text: "You must select either Bureau or Section before creating.",
                        confirmButtonColor: "#101966",
                        background: '#101966',
                        color: '#fff'
                    });
                    return;
                }

                const itemType = selectedType.charAt(0).toUpperCase() + selectedType.slice(1);
                
                Swal.fire({
                    title: `Create ${itemType}?`,
                    text: `Are you sure you want to create this ${selectedType}?`,
                    icon: 'question',
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
                                document.getElementById('createForm').submit();
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
                    confirmButtonColor: "#101966",
                    background: '#101966',
                    color: '#fff'
                });
            @endif

            $(document).ready(function() {
                $('#type').change(function() {
                    const type = $(this).val();
                    
                    if (type === 'bureau') {
                        $('#bureauFields').removeClass('hidden');
                        $('#sectionFields').addClass('hidden');
                        $('#bureau_name').prop('required', true);
                        $('#bureau_id').prop('required', false);
                        $('#section_name').prop('required', false);
                    } else if (type === 'section') {
                        $('#bureauFields').addClass('hidden');
                        $('#sectionFields').removeClass('hidden');
                        $('#bureau_name').prop('required', false);
                        $('#bureau_id').prop('required', true);
                        $('#section_name').prop('required', true);
                    } else {
                        $('#bureauFields').addClass('hidden');
                        $('#sectionFields').addClass('hidden');
                        $('#bureau_name').prop('required', false);
                        $('#bureau_id').prop('required', false);
                        $('#section_name').prop('required', false);
                    }
                });

                $('#type').trigger('change');
            });
        </script>
    </x-slot>
</x-app-layout>