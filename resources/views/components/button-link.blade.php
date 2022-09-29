<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-indigo-800 hover:bg-indigo-900 active:bg-indigo-500 text-gray-50 focus:border-indigo-900 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring ring-indigo-300 focus:text-indigo-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
