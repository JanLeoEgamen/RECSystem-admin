@props(['title'])

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
    <h2 class="font-semibold text-4xl text-white dark:text-gray-200 leading-tight text-center md:text-left">
        {{ $title }}
    </h2>

    @isset($createButton)
        {{ $createButton }}
    @endisset
</div>