<div wire:key="{{ $chartId }}" class="bg-light/5 rounded-lg p-4">
    <div class="flex items-center gap-2 mb-3">
        <i class="fas {{ $chartType->icon() }} text-light/60"></i>
        <span class="text-sm font-medium text-light/80">{{ $chartType->label() }}</span>
    </div>

    @if(count($data) > 0)
        <div x-data="{
            chart: null,
            init() {
                const ctx = document.getElementById('{{ $chartId }}').getContext('2d');
                const existing = Chart.getChart('{{ $chartId }}');
                if (existing) existing.destroy();

                this.chart = new Chart(ctx, @js($this->chartConfig));
            }
        }" x-init="init()">
            <canvas id="{{ $chartId }}"></canvas>
        </div>
    @else
        <div class="flex items-center justify-center h-32 text-light/40">
            <span>{{ __('No data available') }}</span>
        </div>
    @endif
</div>
