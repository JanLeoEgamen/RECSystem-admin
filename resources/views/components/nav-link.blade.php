@props(['active' => false])

@php
$classes = ($active ?? false)
            ? 'nav-link active text-white'
            : 'nav-link text-gray-300 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>