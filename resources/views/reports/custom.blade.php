<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center"> 
            <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight">
                {{ __('Custom Report Generator') }}
            </h2>
            <a href="{{ route('reports.index') }}" 
                class="bg-white text-[#101966] hover:bg-[#101966] hover:text-white px-4 py-2 rounded-md flex items-center justify-center font-medium border border-white hover:border-white transition w-full md:w-auto">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <form id="customReportForm" action="{{ route('reports.custom.export') }}" method="GET">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <option value="">All Statuses</option>
                                <option value="active" {{ old('status', $filters['status'] ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $filters['status'] ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <!-- Bureau Filter -->
                        <div>
                            <label for="bureau_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bureau</label>
                            <select name="bureau_id" id="bureau_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <option value="">All Bureaus</option>
                                @foreach($bureaus as $bureau)
                                    <option value="{{ $bureau->id }}" {{ old('bureau_id', $filters['bureau_id'] ?? '') == $bureau->id ? 'selected' : '' }}>{{ $bureau->bureau_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Section Filter -->
                        <div>
                            <label for="section_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Section</label>
                            <select name="section_id" id="section_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <option value="">All Sections</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ old('section_id', $filters['section_id'] ?? '') == $section->id ? 'selected' : '' }}>{{ $section->section_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Membership Type Filter -->
                        <div>
                            <label for="membership_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Membership Type</label>
                            <select name="membership_type_id" id="membership_type_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <option value="">All Types</option>
                                @foreach($membershipTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('membership_type_id', $filters['membership_type_id'] ?? '') == $type->id ? 'selected' : '' }}>{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- License Class Filter -->
                        <div>
                            <label for="license_class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">License Class</label>
                            <select name="license_class" id="license_class" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <option value="">All Classes</option>
                                <option value="A" {{ old('license_class', $filters['license_class'] ?? '') == 'A' ? 'selected' : '' }}>Class A</option>
                                <option value="B" {{ old('license_class', $filters['license_class'] ?? '') == 'B' ? 'selected' : '' }}>Class B</option>
                                <option value="C" {{ old('license_class', $filters['license_class'] ?? '') == 'C' ? 'selected' : '' }}>Class C</option>
                            </select>
                        </div>
                        
                        <!-- Gender Filter -->
                        <div>
                            <label for="sex" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                            <select name="sex" id="sex" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <option value="">All Genders</option>
                                <option value="male" {{ old('sex', $filters['sex'] ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('sex', $filters['sex'] ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        
                        <!-- Civil Status Filter -->
                        <div>
                            <label for="civil_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Civil Status</label>
                            <select name="civil_status" id="civil_status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <option value="">All Statuses</option>
                                <option value="single" {{ old('civil_status', $filters['civil_status'] ?? '') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ old('civil_status', $filters['civil_status'] ?? '') == 'married' ? 'selected' : '' }}>Married</option>
                                <option value="widowed" {{ old('civil_status', $filters['civil_status'] ?? '') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="separated" {{ old('civil_status', $filters['civil_status'] ?? '') == 'separated' ? 'selected' : '' }}>Separated</option>
                            </select>
                        </div>
                        
                        <!-- Lifetime Member Filter -->
                        <div>
                            <label for="is_lifetime_member" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lifetime Member</label>
                            <select name="is_lifetime_member" id="is_lifetime_member" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                <option value="">All Members</option>
                                <option value="1" {{ old('is_lifetime_member', $filters['is_lifetime_member'] ?? '') == '1' ? 'selected' : '' }}>Lifetime Only</option>
                                <option value="0" {{ old('is_lifetime_member', $filters['is_lifetime_member'] ?? '') == '0' ? 'selected' : '' }}>Regular Only</option>
                            </select>
                        </div>
                    </div>

                    <!-- Date Filters Row - Placed on a new line -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Date From Filter -->
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date From</label>
                            <input type="date" name="date_from" id="date_from" value="{{ old('date_from', $filters['date_from'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        </div>
                        
                        <!-- Date To Filter -->
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date To</label>
                            <input type="date" name="date_to" id="date_to" value="{{ old('date_to', $filters['date_to'] ?? '') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600">
                        </div>
                    </div>
                        
                        <div class="flex justify-end space-x-3">
                            <button type="reset" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                Reset Filters
                            </button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 dark:bg-indigo-700 text-white rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                                Export to PDF
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
    <script>
        // Add some interactivity
        document.getElementById('customReportForm').addEventListener('submit', function(e) {
            // You can add validation or confirmation here if needed
            // e.preventDefault();
        });
    </script>
    @endsection
</x-app-layout> 