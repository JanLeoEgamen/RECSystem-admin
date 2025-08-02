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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Custom left-side scrollbar for right sidebar */
        .scrollbar-left {
            scrollbar-width: thin;             
            scrollbar-color: #5E6FFB #101966;  
            direction: rtl;                    
        }
        .scrollbar-left > * {
            direction: ltr;                    
        }
        .scrollbar-left::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        .scrollbar-left::-webkit-scrollbar-track {
            background: #101966;
            border-radius: 8px;
        }
        .scrollbar-left::-webkit-scrollbar-thumb {
            background-color: #5E6FFB;
            border-radius: 8px;
        }

        .header-container {
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 2rem;
        }

        .header-content {
            transition: all 0.3s ease;
            margin-left: auto;
            margin-right: auto;
            padding: 1.5rem 1rem;
            max-width: 85%;
            background-color: #1A25A1;
            border-radius: 0.5rem;
        }

        .table-row-hover:hover {
            background-color: #3142CE !important;
            color: white !important;
        }

        .table-row-hover:hover a,
        .table-row-hover:hover button {
            color: white !important;
        }

        .assignments-cell {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }

        .assignments-cell:hover::after {
            content: attr(data-full-text);
            position: absolute;
            left: 0;
            top: 100%;
            z-index: 100;
            background: white;
            color: black;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            white-space: normal;
            width: 300px;
            max-height: 200px;
            overflow: auto;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50" 
      x-data="{ sidebarOpen: false, rightSidebarOpen: false, headerWidth: 'max-w-7xl px-4 sm:px-6 lg:px-8' }">

    <div class="min-h-screen flex flex-col">

        <!-- Navigation -->
        <x-navigation />

        <!-- Header Section -->
        <div class="header-container pt-16"> 
            @isset($header)
                <header class="w-full">
                    <div class="header-content mx-auto transition-all duration-300 ease-in-out" :class="headerWidth">
                        {{ $header }}
                    </div>
                </header>
            @endisset
        </div>

        <div class="flex flex-1">

            <!-- Main content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 bg-gray-50">
                    {{ $slot }}
                </main>
                <x-footer />
            </div>

            <!-- Right Sidebar -->
            <x-right-sidebar>
                @include('partials.right-sidebar-content')
            </x-right-sidebar>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    @isset($script)
        {{ $script }}
    @endisset

</body>
</html>
