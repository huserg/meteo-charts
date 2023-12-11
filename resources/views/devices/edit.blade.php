<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Register device') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="p-6">
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form method="POST" action="{{ isset($device) ? route('devices.update', $device) : route('devices.store') }}">
                            @csrf
                            @if(isset($device))
                                @method('PUT')
                            @endif
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-gray-700 dark:bg-light dark:bg-opacity-5 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <x-label for="name" :value="__('Name')" />
                                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ?? (isset($device) ? $device->name : '')" required autofocus />
                                            <x-input-error name="name" :errors="$errors"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <x-label for="mac_address" :value="__('MAC address')" />
                                            <x-input id="mac_address" class="block mt-1 w-full" type="text" name="mac_address" :value="old('mac_address') ?? (isset($device) ? $device->mac_address : '')" required autofocus />
                                            <x-input-error name="mac_address" :errors="$errors"/>
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <x-checkbox :label="__('Has battery ?')" name="has_battery" :value="old('has_battery') ?? (isset($device) ? $device->has_battery : '')" />
                                            <x-input-error name="has_battery" :errors="$errors"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-700 dark:bg-light dark:bg-opacity-5 text-right sm:px-6">
                                    <x-button-link :secondary="true" class="mr-2" :href="route('devices.index')">
                                        {{ __('Cancel') }}
                                    </x-button-link>
                                    <x-button type="submit" class="">
                                        {{ isset($device) ? __('Save') : __('Add') }}
                                    </x-button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
