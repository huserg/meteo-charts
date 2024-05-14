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

}
