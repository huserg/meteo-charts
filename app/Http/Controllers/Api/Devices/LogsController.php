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

        $mac = $request->input('mac');

        $device = Device::withoutGlobalScope('user')
            ->where('mac_address', $mac)
            ->first();

        $logs = $request->has('logs')
            ? $request->input('logs')
            : [];

        // parse logs, logs is a json [{"key": "value"},{"key":...}] where key is the log type and value is the message
        foreach($logs as $log_data) {
            $log_data = json_decode($log_data);
            Log::create([
                'device_id' => $device->id,
                'type' => $log_data->key,
                'message' => $log_data->value,
            ]);
        }

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
