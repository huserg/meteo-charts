<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(){
        $devices = auth()->user()->devices();
        return view('devices.index', compact('devices'));
    }

    public function create() {
        return view('devices.create');
    }
}
