<div
    x-data="{ tooltip: false }"
    x-on:mouseover="tooltip = true" x-on:mouseleave="tooltip = false"
>
    <i class="fas
    @switch($device->last_battery_level?->state)
        @case(\App\Models\BatteryLevel::STATE_CHARGED)
            text-green-500 fa-plug
            @break
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
    @endswitch"
    ></i>
    <span class="text-sm text-white absolute bg-dark-blue rounded-lg p-2 transform -translate-y-4 translate-x-2"
          x-show="tooltip">{{ $device->last_battery_level->percent }}{{ __('%') }}</span>
</div>
