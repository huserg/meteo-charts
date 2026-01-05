<?php

namespace App\Enums;

enum ChartType: int
{
    case Temperature = 1;
    case Humidity = 2;
    case Pressure = 3;
    case Battery = 4;

    public function label(): string
    {
        return match($this) {
            self::Temperature => __('Temperature (°C)'),
            self::Humidity => __('Humidity (%)'),
            self::Pressure => __('Pressure (hPa)'),
            self::Battery => __('Battery (%)'),
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Temperature => 'fa-temperature-half',
            self::Humidity => 'fa-droplet',
            self::Pressure => 'fa-gauge',
            self::Battery => 'fa-battery-half',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::Temperature => 'rgb(255, 99, 132)',
            self::Humidity => 'rgb(54, 162, 235)',
            self::Pressure => 'rgb(75, 192, 192)',
            self::Battery => 'rgb(255, 205, 86)',
        };
    }

    public function backgroundColor(): string
    {
        return match($this) {
            self::Temperature => 'rgba(255, 99, 132, 0.2)',
            self::Humidity => 'rgba(54, 162, 235, 0.2)',
            self::Pressure => 'rgba(75, 192, 192, 0.2)',
            self::Battery => 'rgba(255, 205, 86, 0.2)',
        };
    }

    public function valueKey(): string
    {
        return match($this) {
            self::Temperature => 'degree',
            self::Humidity, self::Battery => 'percent',
            self::Pressure => 'hpa',
        };
    }

    public function relation(): string
    {
        return match($this) {
            self::Temperature => 'temperatures',
            self::Humidity => 'humidities',
            self::Pressure => 'pressures',
            self::Battery => 'batteryLevels',
        };
    }
}
