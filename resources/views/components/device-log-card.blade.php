<div class="bg-gray-700 dark:bg-light dark:bg-opacity-5 rounded-lg shadow-lg p-6 mb-6"
     x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-90"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-90"
>
    <div class="flex flex-col space-y-4">
        <div class="flex items-center justify-between w-full text-sm font-medium text-gray-200 dark:text-light mt-auto">
            <div>
                @if($log->created_at->diffInDays() < 1)
                    {{ $log->created_at->diffForHumans() }}
                @else
                    {{ $log->created_at }}
                @endif
            </div>
        </div>
        <div class="md:flex justify-center md:justify-between w-full text-sm font-medium text-gray-200 dark:text-light mt-auto">
            @foreach($log->entries as $entry)
                <div class="flex flex-col space-y-2">
                    <div class="flex items center justify-between">
                        <div class="text-sm font-medium text-gray-200 dark:text-light">
                            {{ $entry->type }}
                        </div>
                        <div class="text-sm font-medium text-gray-200 dark:text-light">
                            {{ $entry->message }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

