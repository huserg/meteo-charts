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
                                    <div class="flex">
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
                                    <div class="flex">
                                        <div class="flex-shrink-0 mr-3">
                                            <img class="h-10 w-10 rounded-full" src="{{ $device->imageFailsafe }}" alt="{{ $device->name }}">
                                        </div>
                                        <div class="flex flex-col">
                                            <div class="text-sm font-medium text-gray-200">
                                                {{ $device->name }}
                                            </div>
                                            <div class="text-sm text-gray-400">
                                                {{ $device->mac_address }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end mt-4">
                                    <x-button-link class="mr-2" :href="route('devices.edit', $device->id)">
                                        <i class="fas fa-sm fa-edit"></i>
                                    </x-button-link>
                                    <form action="{{ route('devices.destroy', $device->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-sm fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                        @endforeach
                    @else
                        {{ __('No devices linked with your account found, add one first.') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
