<nav class="mb-4 text-sm" aria-label="Breadcrumb">
    <ol class="flex items-center space-x-2">

        <li>
            <a href="{{ url('/') }}" 
               class="flex items-center text-gray-500 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">

                <svg class="w-4 h-4 mr-1 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2L2 8h2v8h4V12h4v4h4V8h2L10 2z"/>
                </svg>
                Home
            </a>
        </li>

        @foreach ($segments as $index => $segment)
            <li class="text-gray-400 dark:text-gray-500">/</li>

            <li>
                @if (!$segment['is_last'])
                    <a href="{{ $segment['url'] }}" 
                       class="text-gray-500 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                        {{ $segment['name'] }}
                    </a>
                @else
                    <span class="text-gray-900 dark:text-gray-100 font-semibold">{{ $segment['name'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
