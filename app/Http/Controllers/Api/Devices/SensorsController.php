<?php

namespace App\Http\Controllers\Api\Devices;

use App\Http\Controllers\Controller;
use App\Models\BatteryLevel;
use App\Models\Device;
use App\Models\Humidity;
use App\Models\Pressure;
use App\Models\Temperature;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SensorsController extends Controller
{
    public function raw_status(Request $request): \Illuminate\Http\JsonResponse
    {

        if(empty($request->all())) {
            return $this->response([
                'code' => 9,
                'message' => 'invalid_payload',
            ]);
        }

        if(!$request->has('mac')) {
            return $this->response([
                'code' => 10,
                'message' => 'mac_missing',
            ]);
        }

        $mac = $request->input('mac');

        $device = Device::withoutGlobalScope('user')
            ->where('mac_address', $mac)
            ->first();

        $device->last_sync = now('Europe/Zurich');
        $device->save();

        $values['device_id'] = $device->id;

        $values['temperature'] = $request->has('temperature')
            ? $request->input('temperature')
            : [];
        $values['humidity'] = $request->has('humidity')
            ? $request->input('humidity')
            : null;
        $values['pressure'] = $request->has('pressure')
            ? $request->input('pressure')
            : null;
        $values['battery'] = $request->has('battery')
            ? $request->input('battery')
            : null;
        $token = $request->has('token')
            ? $request->input('token')
            : null;


        // no device found
        if(!isset($device)) {
            return $this->response([
                'code' => 11,
                'message' => 'no_device',
            ]);
        }

        // if no token, then generate one
        if(!isset($device->token) || !isset($token)) {
            $device->token = Str::random(16);
            $device->save();

            return $this->response([
                'code' => 50,
                'message' => 'fresh_token',
                'register_token' => $device->token,
            ]);
        }

        // check token
        if($device->token != $token) {
            return $this->response([
                'code' => 12,
                'message' => 'wrong_token',
            ]);
        }

        $this->registerData($values);

        return $this->response([
            'code' => 0,
            'message' => 'success',
        ]);

    }

    private function registerData(array $values): void
    {
        // if data then create
        if(isset($values['temperature'])) {
            Temperature::create([
                'device_id' => $values['device_id'],
                'degree' => $values['temperature'],
            ]);
        }
        if (isset($values['humidity'])) {
            Humidity::create([
                'device_id' => $values['device_id'],
                'percent' => $values['humidity'],
            ]);
        }
        if (isset($values['pressure'])) {
            Pressure::create([
                'device_id' => $values['device_id'],
                'hpa' => $values['pressure'],
            ]);
        }
        if (isset($values['battery'])) {
            BatteryLevel::create([
                'device_id' => $values['device_id'],
                'percent' => BatteryLevel::convertToPercent($values['battery']),
            ]);
        }
    }

    private function response($response): \Illuminate\Http\JsonResponse
    {
        return response()->json($response);
    }

}
