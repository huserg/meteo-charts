<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Humidity extends Model
{
    protected $table = 'humidity';

    protected $fillable = [
        'percentage', 'created_at'
    ];

    public function sensor() {
        return $this->belongsTo(Rpi::class);
    }
}
