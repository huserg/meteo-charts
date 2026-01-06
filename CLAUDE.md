# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

MeteoCharts is a Laravel 12 web application for monitoring IoT meteorological sensors. It displays temperature, humidity, pressure, and battery data from devices through an interactive dashboard with Chart.js visualizations.

## Development Commands

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
php artisan migrate

# Development servers (run both in separate terminals)
php artisan serve          # PHP server at localhost:8000
npm run dev                # Vite dev server at localhost:5173

# Production build
npm run build

# Testing
./vendor/bin/phpunit
```

## Architecture

### Key Directories
- `app/Http/Controllers/Api/` - API endpoints for IoT device data ingestion
- `app/Http/Controllers/Dashboard/` - Main dashboard controller
- `app/Http/Controllers/Device/` - Device CRUD operations
- `app/Http/Controllers/Graph/` - Graph visualization
- `app/Livewire/` - Reactive components (ChartsComponent)
- `app/Models/` - Device, Temperature, Humidity, Pressure, BatteryLevel

### Data Flow
1. **IoT Ingestion**: Devices POST to `/api/devices/sensors` with MAC, token, and sensor readings
2. **Storage**: SensorsController validates and stores data in respective models
3. **Display**: Dashboard and Graph controllers fetch data scoped to authenticated user
4. **Visualization**: ChartsComponent (Livewire) renders Chart.js graphs with date filtering

### Routes
- `routes/web.php` - Dashboard, devices, graphs (auth required)
- `routes/api.php` - `POST /api/devices/sensors` (device token auth)
- `routes/auth.php` - Laravel Breeze authentication

### Device Model Scoping
The Device model has a global scope that automatically filters all queries by the authenticated user (`owner_id`). This affects all device-related data access.

### Device Registration Protocol
1. Device sends MAC without token → receives `fresh_token`
2. Subsequent requests include token for validation
3. Token stored on device for persistent authentication

### Battery Calculation
Voltage to percentage: `(voltage - 2.5) / (4.2 - 2.5) * 100`
- Range: 2.5V (0%) to 4.2V (100%)
- States: charged (≥100%), full (>80%), high (>60%), medium (>40%), low (>20%), critical (≤20%)

## Tech Stack
- **Backend**: Laravel 12, PHP 8.2+, MySQL
- **Frontend**: Blade, Tailwind CSS, Alpine.js, Chart.js
- **Reactivity**: Livewire 3
- **Auth**: Laravel Breeze + Sanctum
- **Build**: Vite

## Configuration
- Timezone: Europe/Zurich
- Custom Tailwind colors: light-blue (#15E8DE), dark-blue (#0B274D)
