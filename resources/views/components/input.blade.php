@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => '
        rounded-md shadow-sm focus:ring focus:ring-opacity-50
        border-gray-800 focus:border-indigo-900  focus:ring-indigo-900
        dark:border-gray-800 dark:focus:border-blue dark:focus:ring dark:focus:ring-blue dark:text-black
    ']) !!}>
