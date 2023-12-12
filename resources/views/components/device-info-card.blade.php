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
    <div class="flex flex-col md:flex-row justify-between md:items-end">
        <div class="flex justify-center items-center">
            <div class="flex flex-col items-center">
                <div class="flex flex-row justify-items-center">
                    <img class="h-10 w-10 rounded-full" src="{{ $device->imageFailsafe }}" alt="{{ $device->name }}">
                </div>
                <div class="text-sm font-medium text-gray-200 mt-2">
                    {{ $device->name }}
                </div>

            </div>
        </div>
        <div class="flex justify-center items-center mt-4 md:mt-0 ">
            <div class="flex flex-col items-start">
                <div class="flex justify-between w-full text-sm font-medium text-gray-200 dark:text-light mt-auto">
                    <span>{{ __('Power source') }}</span>
                    <span class="ps-1 text-end min-w-fit">
                        @if($device->has_battery)
                            <i class="fas
                                        @switch($device->last_battery_level?->state)
                                            @case(\App\Models\BatteryLevel::STATE_FULL)
                                                text-green-500 fa-battery-full
                                                @break
                                            @case(\App\Models\BatteryLevel::STATE_HIGH)
                                                text-green-500 fa-battery-three-quarters
                                                @break
                                            @case(\App\Models\BatteryLevel::STATE_MEDIUM)
                                                text-yellow-500 fa-battery-half
                                                @break
                                            @case(\App\Models\BatteryLevel::STATE_LOW)
                                                text-yellow-500 fa-battery-quarter
                                                @break
                                            @case(\App\Models\BatteryLevel::STATE_CRITICAL)
                                                text-red-500 fa-battery-empty
                                                @break
                                            @default
                                                text-gray-500 fa-battery-empty
                                        @endswitch
                                    "></i>
                        @else
                            <i class="fas fa-plug text-yellow-300"></i>
                        @endif
                    </span>
                </div>
                <div class="md:flex justify-center md:justify-between w-full text-sm font-medium text-gray-200 dark:text-light mt-auto">
                    <span class="block text-center mt-4 md:flex md:mt-0 md:text-start">
                        {{ __('Last sync') }}
                    </span>
                    <span class="text-gray-400 ps-1 block text-center md:flex md:text-end min-w-fit">
                        @if($device->last_sync)
                            {{ $device->last_sync->diffForHumans() }}
                        @else
                            <span class="md:ms-4">
                                {{ __('Never') }}
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="hidden md:flex justify-center mt-4">
            <div class="flex-shrink-0 mr-3">
                <img class="h-10 w-10 rounded-full" src="{{ $device->owner->imageFailsafe }}" alt="{{ $device->owner->name }}">
            </div>
            <div class="flex flex-col">
                <div class="text-sm font-medium text-gray-200">
                    {{ $device->owner->name }}
                </div>
                <div class="text-sm text-gray-400">
                    {{ $device->owner->email }}
                </div>
            </div>
        </div>
        <div class="flex flex-row md:flex-col justify-between md:justify-end mt-4">
            <div class="flex md:hidden flex-shrink-0">
                <img class="h-10 w-10 rounded-full" src="{{ $device->owner->imageFailsafe }}" alt="{{ $device->owner->name }}">
            </div>
            <x-button-link :href="route('devices.edit', $device->id)">
                <i class="fas fa-sm fa-edit"></i>
            </x-button-link>
            <form id="delete-device-form" action="{{ route('devices.destroy', $device->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button id="delete-device-{{$device->id}}" type="button" class="md:mt-2 h-full inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150
                                                text-red-400 hover:text-light hover:border-red-500 hover:bg-red-500 ring-red-500">
                    <i class="fas fa-sm fa-trash"></i>
                </button>
                {!! $deleteDeviceAlert() !!}
            </form>
        </div>
    </div>
</div>

