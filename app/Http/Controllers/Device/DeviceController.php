<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(){
        $devices = auth()->user()->devices()->get();
        return view('devices.index', compact('devices'));
    }

    public function create() {
        return view('devices.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'mac_address' => 'required|string|max:255',

        ]);

        $device = auth()->user()->devices()->create([
            'name' => $request->name,
            'mac_address' => $request->mac_address,
            'is_registrating' => true,
        ]);

        return redirect()->route('devices.index');
    }
}
