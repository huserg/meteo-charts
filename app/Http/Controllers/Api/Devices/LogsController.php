<?php

namespace App\Http\Controllers\Api\Devices;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Log;
use App\Models\LogEntry;
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


        $rawLogs = $request->has('logs')
            ? $request->input('logs')
            : "";

        $rawLogs = str_replace(array("'", "\\\""), array('"', "\""), $rawLogs); // Unescape previously escaped double quotes within strings

        $logEntries = json_decode($rawLogs, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            // Handle JSON errors (e.g., logging, throwing an exception)
//            Log::error("JSON decode error: " . json_last_error_msg());
            return response()->json(['error' => 'Invalid log format'], 400);
        }
        foreach ($logEntries as $entry) {
            foreach ($entry as $type => $message) {
                $log = Log::create([
                    'device_id' => $request->device->id, // Ensure you have this variable available
                ]);
                LogEntry::create([
                    'log_id' => $log->id,
                    'type' => $type,
                    'message' => $message,
                ]);
            }
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
