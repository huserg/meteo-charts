<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-light leading-tight">
            {{ __('Graphs') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @forelse($devices as $device)
                <div class="bg-light bg-opacity-5 rounded-lg shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-light/10">
                        <div class="flex items-center gap-3">
                            <img class="h-8 w-8 rounded-full" src="{{ $device->imageFailsafe }}" alt="{{ $device->name }}">
                            <h3 class="text-lg font-semibold text-light">{{ $device->name }}</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            @livewire('charts-component', [
                                'device' => $device,
                                'type' => App\Livewire\ChartsComponent::TYPE_TEMPERATURE,
                                'dateFrom' => $dateFrom,
                                'dateTo' => $dateTo
                            ], key("temp-{$device->id}"))

                            @livewire('charts-component', [
                                'device' => $device,
                                'type' => App\Livewire\ChartsComponent::TYPE_HUMIDITY,
                                'dateFrom' => $dateFrom,
                                'dateTo' => $dateTo
                            ], key("hum-{$device->id}"))

                            @livewire('charts-component', [
                                'device' => $device,
                                'type' => App\Livewire\ChartsComponent::TYPE_PRESSURE,
                                'dateFrom' => $dateFrom,
                                'dateTo' => $dateTo
                            ], key("pres-{$device->id}"))

                            @if($device->has_battery)
                                @livewire('charts-component', [
                                    'device' => $device,
                                    'type' => App\Livewire\ChartsComponent::TYPE_BATTERY,
                                    'dateFrom' => $dateFrom,
                                    'dateTo' => $dateTo
                                ], key("bat-{$device->id}"))
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-light bg-opacity-5 rounded-lg shadow-lg p-12 text-center">
                    <i class="fas fa-chart-line text-4xl text-light/30 mb-4"></i>
                    <p class="text-light/60">{{ __('No devices found. Add a device to see graphs.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
