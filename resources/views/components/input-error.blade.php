@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge([
        'class' => 'text-sm text-red-600 dark:text-red-400 space-y-1 bg-red-100 dark:bg-red-900/30 p-3 rounded-md'
    ]) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
