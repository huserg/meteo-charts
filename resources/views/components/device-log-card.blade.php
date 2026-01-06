<div x-data="{ open: false }" class="bg-light bg-opacity-5 rounded-lg shadow-lg p-6">
    <div class="flex flex-col space-y-4">
        <div @click="open = !open" class="flex items-center justify-between w-full font-medium text-light mt-auto cursor-pointer hover:text-light-blue transition-colors">
            <div>
                @if($log->created_at->diffInDays() < 1)
                    {{ $log->created_at->diffForHumans() }}
                @else
                    {{ $log->created_at }}
                @endif
                <span class="text-light/60">{{ ' - ' . count($log->entries) . ' ' . __('entries')}}</span>
            </div>
            <div :class="{'transform -rotate-90 text-light-blue': open}" class="text-light p-3 transition-all duration-500">
                <i class="fas fa-caret-left"></i>
            </div>
        </div>
        <div x-show="open" class="flex flex-col w-full mt-auto"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-y-4"
        >
            @foreach($log->entries as $entry)
                <div class="grid grid-cols-6 text-sm font-medium text-light border border-light/20 p-2 rounded">
                    <div class="col-span-6 md:col-span-1 {{ $entry->type_color }}">{{ $entry->type }}</div>
                    <div class="col-span-6 md:col-span-5 text-light/80">{{ $entry->message }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

