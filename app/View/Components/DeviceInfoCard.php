<?php

namespace App\View\Components;

use App\Models\Device;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeviceInfoCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Device $device,
    )
    {
        $device->load('owner');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.device-info-card');
    }
}
