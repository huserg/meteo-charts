<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-light leading-tight">
            {{ __('Graphs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                    @foreach($devices as $device)
                <div class="p-6">
                        <div class="ml-4 text-lg leading-7 font-semibold text-light">
                            {{ $device->name }}
                        </div>
                        <hr class="mb-2">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            @livewire('charts-component', ['device' => $device, 'type' => App\Livewire\ChartsComponent::TYPE_TEMPERATURE])
                            @livewire('charts-component', ['device' => $device, 'type' => App\Livewire\ChartsComponent::TYPE_HUMIDITY])
                            @livewire('charts-component', ['device' => $device, 'type' => App\Livewire\ChartsComponent::TYPE_PRESSURE])
                            @if($device->has_battery)
                                @livewire('charts-component', ['device' => $device, 'type' => App\Livewire\ChartsComponent::TYPE_BATTERY])
                            @endif
                        </div>
                </div>
                    @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
