<?php

namespace App\Http\Controllers;

use App\Exceptions\UnknownChartModel;
use App\Models\Humidity;
use App\Models\Light;
use App\Models\Pressure;
use App\Models\Rpi;
use App\Models\Temperature;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */



    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        $rpi_id = $request->rpi_id;
        $interval = $request->interval;

        if(!isset($interval)){
            $interval = 24;
        }

        if(isset($rpi_id)) {
            $rpi = Rpi::find($rpi_id);
        }
        else {
            $rpi = Rpi::first();
            $rpi_id = $rpi->id;
        }

        $rpis = Rpi::all();

        try {
            $tempChart = ChartsController::GenerateChart($rpi_id, new Temperature(), $interval, 'red');
            $humChart = ChartsController::GenerateChart($rpi_id, new Humidity(), $interval, 'blue');
            $pressureChart = ChartsController::GenerateChart($rpi_id, new Pressure(), $interval, 'purple');
            $lightChart = ChartsController::GenerateChart($rpi_id, new Light(), $interval, 'orange');
        }
        catch (UnknownChartModel $e) {
            echo $e->errorMessage();
            return view('dashboard', [
                'rpi' => $rpi,
                'rpis' => $rpis,
            ]);
        }

        return view('dashboard', [
            'rpi' => $rpi,
            'rpis' => $rpis,
            'interval' => $interval,
            'tempChart' => $tempChart,
            'humChart' => $humChart,
            'pressureChart' => $pressureChart,
            'lightChart' => $lightChart,
        ]);
    }

}
