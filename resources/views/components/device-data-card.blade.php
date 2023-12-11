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
    <div class="flex justify-between">
        <div class="flex justify-center items-center">
            <div class="flex flex-col items-center">
                <div class="flex flex-row justify-items-center">
                    <img class="h-10 w-10 rounded-full" src="{{ $device->imageFailsafe }}" alt="{{ $device->name }}">
                    <div class="text-sm font-medium text-gray-200 dark:text-light mt-auto">
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
                    </div>
                </div>
                <div class="text-sm font-medium text-gray-200 mt-2">
                    {{ $device->name }}
                </div>

            </div>
        </div>
        <div class="flex justify-center items-center">
            <div class="flex flex-col items-center">
                <div class="text-sm font-medium text-gray-200">
                    {{ $device->last_temperature?->degree ?? '-' }} °C
                </div>
                <div class="text-sm font-medium text-gray-200">
                    {{ $device->last_humidity?->percent ?? '-' }} %
                </div>
                <div class="text-sm font-medium text-gray-200">
                    {{ $device->last_pressure?->hpa ?? '-' }} hPa
                </div>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <div class="flex flex-col items-center">
                <img class="h-10 w-10 rounded-full" src="{{ $device->owner->imageFailsafe }}" alt="{{ $device->owner->name }}">
                <div class="text-sm font-medium text-gray-200">
                    {{ $device->owner->name }}
                </div>
            </div>
        </div>
    </div>
</div>
