<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('devices.index') }}" class="text-light/60 hover:text-light-blue transition-colors">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h2 class="font-semibold text-xl text-light leading-tight">
                        {{ $device->name }}
                    </h2>
                    <p class="text-sm text-light/60">{{ __('Device Logs') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-light/60">
                    <i class="fas fa-list-ul mr-1"></i>
                    {{ $logs->total() }} {{ __('total logs') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($logs->count() > 0)
                <div class="space-y-4">
                    @foreach($logs as $log)
                        <x-device-log-card :log="$log" />
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="bg-light/5 rounded-lg shadow-lg p-12 text-center">
                    <i class="fas fa-inbox text-4xl text-light/30 mb-4"></i>
                    <p class="text-light/60">{{ __('No logs found for this device.') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

