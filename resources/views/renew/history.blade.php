<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center flex-wrap gap-4">
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Renewal History
            </h2>

            <div class="flex items-center flex-wrap gap-4">
                <a href="{{ route('renew.index') }}" 
                class="inline-block px-5 py-2 text-white hover:text-[#101966] hover:border-[#101966] bg-[#101966] hover:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#101966] border border-white font-medium dark:border-[#3E3E3A] dark:hover:bg-black dark:hover:border-[#3F53E8] rounded-lg text-xl leading-normal">
                    Pending Requests
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="p-6">
                    <table id="historyTable" class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr class="border-b text-center">
                                <th>#</th>
                                <th>Member</th>
                                <th>Reference #</th>
                                <th>Status</th>
                                <th>Processed By</th>
                                <th>Processed At</th>
                                <th>Receipt</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($renewals as $renewal)
                            <tr class="border-b text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $renewal->member->user->name }}</td>
                                <td>{{ $renewal->reference_number }}</td>
                                <td>
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        {{ $renewal->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($renewal->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $renewal->processor 
                                        ? $renewal->processor->first_name . ' ' . $renewal->processor->last_name 
                                        : 'System' }}
                                </td>
                                <td>{{ $renewal->processed_at?->format('M d, Y h:i A') ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ Storage::url($renewal->receipt_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                        View Receipt
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>