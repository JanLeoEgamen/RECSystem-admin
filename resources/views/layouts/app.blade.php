<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .dataTables_length select {
                padding-right: 10px !important; /* reduce from 25px */
                padding-left: 10px !important;
                appearance: none !important;
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                background-image: url("data:image/svg+xml;charset=US-ASCII,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20width='10'%20height='6'%20viewBox='0%200%2010%206'%3e%3cpath%20fill='none'%20stroke='%23333'%20stroke-width='1.5'%20d='M1%201l4%204%204-4'/%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: center 14px center; /* moved closer */
                background-size: 10px 6px; /* slightly bigger arrow */
                background-color: white;
                border: 1px solid #ccc;
                border-radius: 4px;
                height: 33px;
                line-height: 1.5;
                font-size: 1rem;
            }

             /* Your existing DataTables styles */
            .dataTables_length select {
                padding-right: 10px !important;
                /* ... other existing styles ... */
            }

            /* Add the new overlay styles here */
            body.overflow-hidden {
                overflow: hidden;
            }

            #paymentOverlay {
                transition: opacity 0.3s ease;
            }

            #paymentOverlay.hidden {
                opacity: 0;
                pointer-events: none;
            }

            #paymentOverlay:not(.hidden) {
                opacity: 1;
                pointer-events: auto;
            }

            .border-b {
                margin-bottom: 2rem;
                padding-bottom: 2rem;
            }

            /* Add spacing between form fields */
            .space-y-8 > * + * {
                margin-top: 2rem;
            }

            /* Add spacing between grid items */
            .gap-4 {
                gap: 1.5rem;
            }

            /* Add spacing for input fields */
            input, select {
                margin-bottom: 0.5rem;
}
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-[#5E6FFB] dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.js" ></script>

        @isset($script)
            {{ $script }}
        @endisset
    </body>
</html>
