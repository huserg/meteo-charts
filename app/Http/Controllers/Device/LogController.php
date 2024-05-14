<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request, int $device_id)
    {
        $device = Device::where('id', $device_id)
            ->first();
        return view('devices.logs.index', compact('device'));
    }
}
