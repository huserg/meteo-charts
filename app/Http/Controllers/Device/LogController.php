<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request, int $device_id)
    {
        $device = Device::findOrFail($device_id);
        $logs = Log::where('device_id', $device_id)
            ->orderByDesc('created_at')
            ->paginate(25);

        return view('devices.logs.index', compact('device', 'logs'));
    }
}
