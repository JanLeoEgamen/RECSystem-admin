<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                Send Certificate: {{ $certificate->title }}
            </h2>
            <a href="{{ route('certificates.preview', $certificate->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
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
                            <label class="block text-sm font-medium mb-2">Available Members</label>
                            @if($members->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($members as $member)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="members[]" id="member-{{ $member->id }}" value="{{ $member->id }}" class="rounded">
                                        <label for="member-{{ $member->id }}" class="ml-2">{{ $member->first_name }} {{ $member->last_name }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">All members have already received this certificate.</p>
                            @endif
                        </div>
                        
                        @if($members->count() > 0)
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
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
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issued At</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Sent</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($sentMembers as $member)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->first_name }} {{ $member->last_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->email_address }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->pivot->issued_at->format('M d, Y H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->pivot->sent_at ? $member->pivot->sent_at->format('M d, Y H:i') : 'Not sent yet' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('certificates.view', ['certificate' => $certificate->id, 'member' => $member->id]) }}" 
                                               class="text-blue-600 hover:text-blue-900" target="_blank">View</a>
                                            <a href="{{ route('certificates.resend', ['certificate' => $certificate->id, 'member' => $member->id]) }}" 
                                               class="text-green-600 hover:text-green-900 ml-4">Resend</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">No certificates have been sent yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>