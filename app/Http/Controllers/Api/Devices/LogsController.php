<?php

namespace App\Http\Controllers\Api\Devices;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Log;
use Illuminate\Http\Request;

class LogsController extends Controller {

    public function receive_logs(Request $request): \Illuminate\Http\JsonResponse
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

        $mac = $request->has('mac')
            ? $request->input('mac')
            : null;
        $token = $request->has('token')
            ? $request->input('token')
            : null;

        $device = Device::withoutGlobalScope('user')
            ->where('mac_address', $mac)
            ->first();

        if(!isset($mac)) {
            return $this->response([
                'code' => 10,
                'message' => 'mac_missing',
            ]);
        }

        // no device found
        if(!isset($device)) {
            return $this->response([
                'code' => 11,
                'message' => 'no_device',
            ]);
        }

        // check token
        if($device->token != $token) {
            return $this->response([
                'code' => 12,
                'message' => 'wrong_token',
            ]);
        }


        $logs = $request->has('logs')
            ? $request->input('logs')
            : [];

        Log::create([
            'device_id' => $device->id,
            'type' => 'logs',
            'message' => json_encode($logs),
        ]);
//        $logs = json_decode($logs);

//        foreach($logs as $log_data) {
//            Log::create([
//                'device_id' => $device->id,
//                'type' => $log_data->key,
//                'message' => $log_data->value,
//            ]);
//        }

        return $this->response([
            'code' => 0,
            'message' => 'success',
        ]);
    }

    private function response($response): \Illuminate\Http\JsonResponse
    {
        return response()->json($response);
    }
}
