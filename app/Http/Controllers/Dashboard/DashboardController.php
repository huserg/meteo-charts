<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $devices = Device::all();
        return view('dashboard.index', compact('devices'));
    }
}
