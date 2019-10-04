<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pressure extends Model
{
    protected $table = 'pressure';

    protected $fillable = [
        'hpa', 'created_at'
    ];

    public function sensor() {
        return $this->belongsTo(Rpi::class);
    }
}
