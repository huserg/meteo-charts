<?php


namespace App\Http\Controllers;


use App\Charts\MeteoChart;
use App\Exceptions\UnknownChartModel;
use App\Models\Humidity;
use App\Models\Light;
use App\Models\Pressure;
use App\Models\Temperature;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Frappe\Chart;
use Illuminate\Database\Eloquent\Model;

class ChartsController extends Controller
{

    public static function GenerateChart(int $rpi_id, Model $model, int $interval, string $color) : Chart {

        switch (get_class($model)) {
            case Temperature::class :
                $col_name = 'degree';
                $unity = 'Celsius';
                break;
            case Humidity::class :
                $col_name = 'percentage';
                $unity = 'Percent';
                break;
            case Pressure::class :
                $col_name = 'hpa';
                $unity = 'Hectopascals';
                break;
            case Light::class :
                $col_name = 'lux';
                $unity = 'Lux';
                break;
            default :
                throw new UnknownChartModel("Undefined Eloquent Model '" . get_class($model) . "'");
                break;
        }

        return self::ChartGenerator($rpi_id, $model, $col_name, $unity, $interval, $color);
    }

    private static function ChartGenerator(int $rpi_id, Model $model, String $column_name, String $unity, int $interval, string $color) : Chart {

        $collection =
            $model::select('created_at', $column_name)
                ->where('rpi_id', $rpi_id)
                ->where('created_at', '>=', Carbon::now()->subHours($interval))
                ->get();

        $stamps = array();
        $values = $collection->pluck($column_name)->toArray();

        foreach ($collection->pluck('created_at')->toArray() as $key=>$d){
            $stamps[$key] = date('d.m H:i', strtotime($d));
        }

        $chart = new MeteoChart();
        $chart->labels($stamps)
            ->dataset($unity, 'line', $values)->color($color);
        $chart->hideDots(true)
            ->heatline(true)
            ->isNavigable(true);
        $chart->options([
            'axisOptions' => [
                'xAxisMode' => 'span',
                'yAxisMode' => 'span',
                'xIsSeries' => true,
            ],
            'lineOptions' => [
                'regionFill' => true,
            ],
            'height' => 200,
        ]);
        return $chart;
    }

}
