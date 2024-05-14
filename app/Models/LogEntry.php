<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'log_id',
        'type',
        'message',
    ];



    public function log() {
        return $this->belongsTo(Log::class);
    }


    public function getTypeColorAttribute(): string
    {
        $type = strtoupper(explode(':', $this->message)[0]); // Convert to upper case for case-insensitive comparison
        return match ($type) {
            'DEBUG' => 'text-light-blue',
            'INFO' => 'text-white',
            'WARN' => 'text-yellow-400',
            'ERROR' => 'text-red-600',
            default => 'text-gray-200',
        };
    }

}
