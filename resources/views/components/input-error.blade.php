@props(['errors', 'name'])

@if ($errors->has($name))
    <div class="text-red-600 dark:text-red-600 text-sm mt-1">
        {{ $errors->first($name) }}
    </div>
@endif
