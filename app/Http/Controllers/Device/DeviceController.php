<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(){
        $devices = auth()->user()?->devices()->get();
        return view('devices.index', compact('devices'));
    }

    public function create() {
        return view('devices.edit');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mac_address' => 'required|string|max:255',
            'has_battery' => 'string',
        ]);

        $device = auth()->user()->devices()->create([
            'name' => $request->name,
            'mac_address' => $request->mac_address,
            'is_registrating' => true,
            'has_battery' => $request->has_battery === "on" ?? false,
        ]);

        return redirect()->route('devices.index');
    }

    public function edit(Device $device) {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mac_address' => 'required|string|max:255',
            'has_battery' => 'string',
        ]);

        $device->update([
            'name' => $request->name,
            'mac_address' => $request->mac_address,
            'has_battery' => $request->has_battery === "on" ?? false,
        ]);

        return redirect()->route('devices.index');
    }

}
