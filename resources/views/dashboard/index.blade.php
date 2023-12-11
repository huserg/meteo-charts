<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    @foreach($devices as $device)
                        <div class="bg-gray-700 rounded-lg shadow-lg p-6 mb-6"
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
                                        <img class="h-10 w-10 rounded-full" src="{{ $device->imageFailsafe }}" alt="{{ $device->name }}">
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
                                    </div>
                                </div>
                                <div class="flex justify-center items-center">
                                    <div class="flex flex-col items-center">
                                        <div class="text-sm font-medium text-gray-200">
                                            {{ $device->last_humidities?->percent ?? '-' }} %
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-center items-center">
                                    <div class="flex flex-col items-center">
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
