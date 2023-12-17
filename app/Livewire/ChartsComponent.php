<?php

namespace App\Livewire;

use App\Models\Device;
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

    public function mount(Device $device, int $type): void
    {
        $this->device = $device;
        $this->chartId = 'device-' . $device->id . '-' . $type . '-chart';
        $this->name = $device->name;
        // take all battery, humidity, pressure, temperature records for this device, merge and delete duplicates
        switch ($type) {
            case self::TYPE_TEMPERATURE:
                $this->defineTemperatureLabels();
                $this->defineTemperatureData();
                $this->defineTemperatureDataset();
                break;
            case self::TYPE_HUMIDITY:
                $this->defineHumidityLabels();
                $this->defineHumidityData();
                $this->defineHumidityDataset();
                break;
            case self::TYPE_PRESSURE:
                $this->definePressureLabels();
                $this->definePressureData();
                $this->definePressureDataset();
                break;
            case self::TYPE_BATTERY:
                $this->defineBatteryLabels();
                $this->defineBatteryData();
                $this->defineBatteryDataset();
                break;
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.charts-component');
    }

    /* SWITCH TYPE METHODS */
    private function defineTemperatureLabels(): void
    {
        // get all temperature records for this device, sort by created_at, take created_at column and convert to array formatted to d.m.Y H:i
        $this->labels = $this->device->temperatures->sortBy('created_at')->pluck('created_at')->map(function ($item) {
            return $item->format('d-m-Y H:i');
        })->toArray();
    }
    private function defineHumidityLabels(): void
    {
        $this->labels = $this->device->humidities->sortBy('created_at')->pluck('created_at')->map(function ($item) {
            return $item->format('d-m-Y H:i');
        })->toArray();
    }
    private function definePressureLabels(): void
    {
        $this->labels = $this->device->pressures->sortBy('created_at')->pluck('created_at')->map(function ($item) {
            return $item->format('d-m-Y H:i');
        })->toArray();
    }
    private function defineBatteryLabels(): void
    {
        $this->labels = $this->device->batteryLevels->sortBy('created_at')->pluck('created_at')->map(function ($item) {
            return $item->format('d-m-Y H:i');
        })->toArray();
    }

    private function defineTemperatureData(): void
    {
        $this->data = $this->device->temperatures->sortBy('created_at')->pluck('degree')->toArray();
    }
    private function defineHumidityData(): void
    {
        $this->data = $this->device->humidities->sortBy('created_at')->pluck('percent')->toArray();
    }
    private function definePressureData(): void
    {
        $this->data = $this->device->pressures->sortBy('created_at')->pluck('hpa')->toArray();
    }
    private function defineBatteryData(): void
    {
        $this->data = $this->device->batteryLevels->sortBy('created_at')->pluck('percent')->toArray();
    }

    private function defineTemperatureDataset(): void
    {
        $this->dataset = [
            [
                'label' => __('Temperature') . ' (°C)',
                'data' => $this->data,
                'borderColor' => 'rgb(255, 99, 132)',
                'backgroundColor' => 'rgba(255, 99, 132, 0.5)',
            ],
        ];
    }
    private function defineHumidityDataset(): void
    {
        $this->dataset = [
            [
                'label' => __('Humidity') . ' (%)',
                'data' => $this->data,
                'borderColor' => 'rgb(54, 162, 235)',
                'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
            ],
        ];
    }
    private function definePressureDataset(): void
    {
        $this->dataset = [
            [
                'label' => __('Pressure') . ' (hPa)',
                'data' => $this->data,
                'borderColor' => 'rgb(75, 192, 192)',
                'backgroundColor' => 'rgba(75, 192, 192, 0.5)',
            ],
        ];
    }
    private function defineBatteryDataset(): void
    {
        $this->dataset = [
            [
                'label' => __('Battery') . ' (%)',
                'data' => $this->data,
                'borderColor' => 'rgb(255, 205, 86)',
                'backgroundColor' => 'rgba(255, 205, 86, 0.5)',
            ],
        ];
    }
}
