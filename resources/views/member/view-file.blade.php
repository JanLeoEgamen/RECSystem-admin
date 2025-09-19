<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
                File: {{ $file->title }}
            </h2>
            <a href="{{ route('member.my-files') }}" 
               class="inline-flex items-center justify-center px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] 
                    bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-[#101966] border border-white font-medium dark:bg-gray-900 dark:text-white dark:border-gray-100 
                    dark:hover:bg-gray-700 dark:hover:text-white dark:hover:border-gray-100 rounded-lg text-lg md:text-xl leading-normal transition-colors duration-200 
                    w-full md:w-auto mt-4 md:mt-0">

                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to My Files
            </a>                
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-medium mb-2">File Details</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</dt>
                                    <dd class="text-sm">{{ $file->title }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                    <dd class="text-sm">{{ $file->description ?? 'No description' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned By</dt>
                                    <dd class="text-sm">{{ $file->assigner->full_name ?? 'Unknown' }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium mb-2">Assignment Details</h3>
                            <dl class="space-y-2">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Due Date</dt>
                                    <dd class="text-sm">{{ $file->due_date ? $file->due_date->format('M d, Y') : 'No due date' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Required</dt>
                                    <dd class="text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $file->is_required ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $file->is_required ? 'Required' : 'Optional' }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                                    <dd class="text-sm">{{ $file->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mb-6">
                        <h3 class="text-lg font-medium mb-4">Upload File</h3>
                        
                        <form action="{{ route('member.upload-file', $file->id) }}" method="post" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label for="file" class="block text-sm font-medium mb-1">File *</label>
                                <input type="file" name="file" id="file" required 
                                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <p class="text-xs text-gray-500 mt-1">Supported formats: PDF, Word, JPEG, PNG, GIF, TXT (Max: 2MB)</p>
                                @error('file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium mb-1">Notes (Optional)</label>
                                <textarea name="notes" id="notes" rows="3" 
                                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                          placeholder="Add any notes about this upload">{{ old('notes') }}</textarea>
                                @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Upload File
                            </button>
                        </form>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-medium mb-4">Upload History</h3>
                        
                        @if($file->uploads->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-900">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                File Name
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Type
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Size
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Uploaded At
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Notes
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($file->uploads as $upload)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $upload->file_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $upload->file_type }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $upload->file_size }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ date('M d, Y H:i', strtotime($upload->uploaded_at)) }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $upload->notes ?? 'No notes' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('member.download-file', ['id' => $file->id, 'uploadId' => $upload->id]) }}" 
                                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                        Download
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No files have been uploaded yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success'))
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: "{{ session('success') }}",
                    confirmButtonColor: "#5e6ffb",
                    background: '#101966',
                    color: '#fff'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "{{ session('error') }}",
                    confirmButtonColor: "#5e6ffb",
                    background: '#101966',
                    color: '#fff'
                });
            @endif
        </script>
    </x-slot>
</x-app-layout>