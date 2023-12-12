@props(['secondary' => false])


<a {{ $attributes->merge([
    'class' => '
        inline-flex items-center px-4 py-2
        border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150
        bg-indigo-800 hover:bg-indigo-900 active:bg-indigo-500 text-gray-50 focus:border-indigo-900 ring-indigo-300 focus:text-indigo-300
        ' . ($secondary ? 'dark:bg-dark-gray dark:hover:bg-dark-blue dark:active:bg-dark-blue dark:text-light dark:hover:text-light dark:focus:text-light dark:active:text-light dark:focus:ring-blue'
                        : 'dark:bg-light-blue dark:hover:bg-dark-blue dark:active:bg-dark-blue dark:text-dark-gray dark:hover:text-light dark:focus:text-light dark:active:text-light dark:focus:ring-blue')
    ]) }}

>
    {{ $slot }}
</a>
