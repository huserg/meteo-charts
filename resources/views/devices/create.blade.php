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
{{--                    Device form with name and mac address--}}
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form method="POST" action="{{ route('devices.store') }}">
                            @csrf
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-gray-700 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="name" class="block text-sm font-medium text-gray-200">Name</label>
                                            <input type="text" name="name" id="name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm bg-gray-600 text-gray-200 border-gray-300 rounded-md">
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="mac_address" class="block text-sm font-medium text-gray-200">Mac address</label>
                                            <input type="text" name="mac_address" id="mac_address" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm bg-gray-600 text-gray-200 border-gray-300 rounded-md">
                                        </div>
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="has_battery" class="block text-sm font-medium text-gray-200">Has battery</label>
                                            <input type="checkbox" name="has_battery" id="has_battery" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm bg-gray-600 text-gray-200 border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-700 text-right sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-200 bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
