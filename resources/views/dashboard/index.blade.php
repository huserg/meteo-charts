<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-light leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        @foreach($devices as $device)
                            <x-device-data-card :device="$device" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>



</x-app-layout>
