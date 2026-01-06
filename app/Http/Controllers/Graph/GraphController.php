<?php

namespace App\Http\Controllers\Graph;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    private const PERIODS = [
        '24h' => 1,
        '7d' => 7,
        '30d' => 30,
        '3m' => 90,
        '6m' => 180,
        '1y' => 365,
    ];

    public function index(Request $request)
    {
        $devices = auth()->user()?->devices()->get();
        $period = $request->get('period', '7d');

        if ($period === 'custom') {
            $dateFrom = $request->has('from')
                ? Carbon::parse($request->get('from'))->startOfDay()
                : Carbon::now()->subDays(7)->startOfDay();
            $dateTo = $request->has('to')
                ? Carbon::parse($request->get('to'))->endOfDay()
                : Carbon::now()->endOfDay();
        } else {
            $days = self::PERIODS[$period] ?? 7;
            $dateFrom = Carbon::now()->subDays($days)->startOfDay();
            $dateTo = Carbon::now()->endOfDay();
        }

        $periods = array_keys(self::PERIODS);

        return view('graphs.index', compact('devices', 'dateTo', 'dateFrom', 'period', 'periods'));
    }
}
