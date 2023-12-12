<x-app-layout>
    <x-slot name="header">
        <x-button-link class="float-right font-bold mt-0 rounded-full" :href="route('devices.create')">
            <i class="fas fa-sm fa-plus"></i>
        </x-button-link>
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Devices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    @isset($devices)
                        @foreach($devices as $device)
                            <x-device-info-card :device="$device" />
                        @endforeach
                    @else
                        {{ __('No devices linked with your account found, add one first.') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
