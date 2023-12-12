@props(['label', 'name', 'value', 'disabled' => false])

<label for="{{ $name }}" {{ $attributes->merge(['class' => 'inline-flex items-center']) }}>
    <input id="{{ $name }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} type="checkbox" {{ $value ? 'checked="checked"' : '' }} {!! $attributes->merge(['class' => 'rounded border-gray-300 text-indigo-600 dark:border-gray-800 dark:text-blue shadow-sm focus:border-indigo-300 dark:focus:border-blue focus:ring focus:ring-indigo-200 dark:focus:ring-blue focus:ring-opacity-50']) !!}>
    <span class="ml-2 text-sm text-gray-600 dark:text-light">{{ $label ?? $slot }}</span>
</label>
