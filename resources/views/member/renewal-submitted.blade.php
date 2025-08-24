<x-app-layout>
    <!-- Thank You Message -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-4xl p-8 text-center shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Renewal Submitted!</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed mb-6">
                Your application has been submitted successfully. Please wait while we review your details.<br>
                You will receive a confirmation email once your application has been approved. 
            </p>

            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-6">
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    <strong>Reference Number:</strong> {{ session('reference_number') }}<br>
                    <strong>Submitted on:</strong> {{ session('submission_date') }}
                </p>
            </div>

            <a href="{{ route('login') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 rounded-md text-white hover:bg-blue-700 transition-colors duration-300">
                Return to Login
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</x-app-layout>