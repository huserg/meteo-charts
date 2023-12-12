@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-900 dark:border-light-blue text-sm font-medium leading-5 text-gray-100 dark:text-light focus:outline-none focus:border-indigo-700 dark:focus:border-blue transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent dark:border-transparent text-sm font-medium leading-5 text-gray-50 dark:text-light hover:text-indigo-500 dark:hover:text-light-blue hover:border-indigo-500 dark:hover:border-blue focus:outline-none focus:text-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
