@props(['period', 'periods', 'dateFrom', 'dateTo'])

<div x-data="{ showCustom: @js($period === 'custom') }" class="bg-light bg-opacity-5 rounded-lg shadow-lg p-4">
    <form method="GET" action="{{ route('graphs.index') }}" class="flex flex-col sm:flex-row sm:items-center gap-4">
        {{-- Preset periods --}}
        <div class="flex flex-wrap gap-2">
            @foreach($periods as $p)
                <button
                    type="submit"
                    name="period"
                    value="{{ $p }}"
                    @click="showCustom = false"
                    class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors
                        {{ $period === $p
                            ? 'bg-light-blue text-dark-blue'
                            : 'bg-light/10 text-light hover:bg-light/20' }}"
                >
                    {{ $p }}
                </button>
            @endforeach
            <button
                type="button"
                @click="showCustom = !showCustom"
                class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors
                    {{ $period === 'custom'
                        ? 'bg-light-blue text-dark-blue'
                        : 'bg-light/10 text-light hover:bg-light/20' }}"
            >
                <i class="fas fa-calendar-alt mr-1"></i>
                {{ __('Custom') }}
            </button>
        </div>

        {{-- Custom date range --}}
        <div x-show="showCustom" x-collapse class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
            <input type="hidden" name="period" value="custom" x-bind:disabled="!showCustom">
            <div class="flex items-center gap-2">
                <label class="text-sm text-light/60">{{ __('From') }}</label>
                <input
                    type="date"
                    name="from"
                    value="{{ $dateFrom->format('Y-m-d') }}"
                    class="bg-light/10 border-light/20 text-light text-sm rounded-lg focus:ring-light-blue focus:border-light-blue"
                >
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-light/60">{{ __('To') }}</label>
                <input
                    type="date"
                    name="to"
                    value="{{ $dateTo->format('Y-m-d') }}"
                    class="bg-light/10 border-light/20 text-light text-sm rounded-lg focus:ring-light-blue focus:border-light-blue"
                >
            </div>
            <button
                type="submit"
                class="px-3 py-1.5 text-sm font-medium rounded-lg bg-light-blue text-dark-blue hover:bg-light-blue/80 transition-colors"
            >
                <i class="fas fa-check"></i>
            </button>
        </div>

        {{-- Current range display --}}
        <div class="sm:ml-auto text-sm text-light/60">
            <i class="fas fa-clock mr-1"></i>
            {{ $dateFrom->format('d.m.Y') }} - {{ $dateTo->format('d.m.Y') }}
        </div>
    </form>
</div>
