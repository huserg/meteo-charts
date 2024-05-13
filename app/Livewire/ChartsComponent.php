<?php

namespace App\Livewire;

use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class ChartsComponent extends Component
{
    // DeviceChartType static constants
    public const TYPE_TEMPERATURE = 1;
    public const TYPE_HUMIDITY = 2;
    public const TYPE_PRESSURE = 3;
    public const TYPE_BATTERY = 4;


    public Device $device;
    public array $labels = [];
    public string $name = "";
    public string $chartId = "";
    public array $data = [];
    public array $dataset = [];
    public Carbon $dateFrom ;
    public Carbon $dateTo ;

    public function mount(int $type, Device $device, Carbon $dateFrom, Carbon $dateTo): void
    {
        $this->device = $device;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;

        $this->chartId = 'device-' . $this->device->id . '-' . $type . '-chart';

        $this->name = $this->device->name;
        $this->filterData($type);
    }

    public function render(): View|Application|Factory|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.charts-component');
    }

    private function filterData(int $type): void
    {
        switch ($type) {
            case self::TYPE_TEMPERATURE:
                $this->processData($this->device->temperatures()->where('created_at', '>=', $this->dateFrom)->where('created_at', '<=', $this->dateTo)->get(), 'degree', 'Temperature (°C)');
                break;
            case self::TYPE_HUMIDITY:
                $this->processData($this->device->humidities()->where('created_at', '>=', $this->dateFrom)->where('created_at', '<=', $this->dateTo)->get(), 'percent', 'Humidity (%)');
                break;
            case self::TYPE_PRESSURE:
                $this->processData($this->device->pressures()->where('created_at', '>=', $this->dateFrom)->where('created_at', '<=', $this->dateTo)->get(), 'hpa', 'Pressure (hPa)');
                break;
            case self::TYPE_BATTERY:
                $this->processData($this->device->batteryLevels()->where('created_at', '>=', $this->dateFrom)->where('created_at', '<=', $this->dateTo)->get(), 'percent', 'Battery (%)');
                break;
        }
    }

    private function processData($records, $valueKey, $labelDescription): void
    {
        $this->labels = $records->sortBy('created_at')->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d H:i:s');
        })->toArray();

        $this->data = $records->sortBy('created_at')->pluck($valueKey)->toArray();

        $this->dataset = [
            [
                'label' => __($labelDescription),
                'data' => $this->data,
                'borderColor' => $this->getColor($valueKey),
                'backgroundColor' => $this->getBackgroundColor($valueKey),
            ],
        ];
    }

    private function getColor($valueKey): string
    {
        return match($valueKey) {
            'degree' => 'rgb(255, 99, 132)',
            'percent' => 'rgb(54, 162, 235)',
            'hpa' => 'rgb(75, 192, 192)',
            default => 'rgb(201, 203, 207)'
        };
    }

    private function getBackgroundColor($valueKey): string
    {
        return match($valueKey) {
            'degree' => 'rgba(255, 99, 132, 0.5)',
            'percent' => 'rgba(54, 162, 235, 0.5)',
            'hpa' => 'rgba(75, 192, 192, 0.5)',
            default => 'rgba(201, 203, 207, 0.5)'
        };
    }
}
