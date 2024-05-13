<?php

namespace App\Http\Controllers\Graph;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    public function index(){
        $devices = auth()->user()?->devices()->get();
        $dateFrom = Carbon::now()->subDays(7);
        $dateTo = Carbon::now();
        return view('graphs.index', compact('devices', 'dateTo', 'dateFrom'));
    }
}
