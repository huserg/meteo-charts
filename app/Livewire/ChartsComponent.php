<?php

namespace App\Livewire;

use App\Enums\ChartType;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ChartsComponent extends Component
{
    // Keep legacy constants for backwards compatibility
    public const TYPE_TEMPERATURE = 1;
    public const TYPE_HUMIDITY = 2;
    public const TYPE_PRESSURE = 3;
    public const TYPE_BATTERY = 4;

    public Device $device;
    public ChartType $chartType;
    public string $chartId;
    public array $labels = [];
    public array $data = [];
    public array $dataset = [];
    public Carbon $dateFrom;
    public Carbon $dateTo;

    public function mount(int $type, Device $device, Carbon $dateFrom, Carbon $dateTo): void
    {
        $this->device = $device;
        $this->chartType = ChartType::from($type);
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->chartId = "chart-{$device->id}-{$type}";

        $this->loadChartData();
    }

    public function render(): View
    {
        return view('livewire.charts-component');
    }

    private function loadChartData(): void
    {
        $relation = $this->chartType->relation();
        $valueKey = $this->chartType->valueKey();

        $records = $this->device->{$relation}()
            ->whereBetween('created_at', [$this->dateFrom, $this->dateTo])
            ->orderBy('created_at')
            ->get();

        $this->labels = $records->pluck('created_at')
            ->map(fn($date) => $date->format('Y-m-d H:i:s'))
            ->toArray();

        $this->data = $records->pluck($valueKey)->toArray();

        $this->dataset = [
            [
                'label' => $this->chartType->label(),
                'data' => $this->data,
                'borderColor' => $this->chartType->color(),
                'backgroundColor' => $this->chartType->backgroundColor(),
                'fill' => true,
                'tension' => 0.3,
            ],
        ];
    }

    public function getChartConfigProperty(): array
    {
        return [
            'type' => 'line',
            'data' => [
                'labels' => $this->labels,
                'datasets' => $this->dataset,
            ],
            'options' => $this->getChartOptions(),
        ];
    }

    private function getChartOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true,
            'aspectRatio' => 2,
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'color' => 'rgba(249, 255, 254, 0.8)',
                    ],
                ],
                'title' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'type' => 'time',
                    'time' => [
                        'unit' => 'day',
                        'parser' => 'yyyy-MM-dd HH:mm:ss',
                        'tooltipFormat' => 'EEEE dd MMMM yyyy - HH:mm',
                        'displayFormats' => [
                            'day' => 'EEE, d.M.yy',
                        ],
                    ],
                    'grid' => [
                        'color' => 'rgba(249, 255, 254, 0.1)',
                    ],
                    'ticks' => [
                        'color' => 'rgba(249, 255, 254, 0.6)',
                    ],
                ],
                'y' => [
                    'grid' => [
                        'color' => 'rgba(249, 255, 254, 0.1)',
                    ],
                    'ticks' => [
                        'color' => 'rgba(249, 255, 254, 0.6)',
                    ],
                ],
            ],
        ];
    }
}
