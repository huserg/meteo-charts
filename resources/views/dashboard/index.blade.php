<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @foreach($devices as $device)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-gray-50">
                <div class="overflow-hidden">
                    <div class="p-6">
                        {!! $device !!}

                        {!! $device->temperatures()->latest()!!}

                        {!! $device->humidities()->latest() !!}

                        {!! $device->pressures()->latest() !!}

                        {!! $device->battery_levels()->latest() !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
