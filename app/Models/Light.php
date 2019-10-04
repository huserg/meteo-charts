<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Light extends Model
{
    protected $table = 'light';

    protected $fillable = [
        'lux', 'created_at'
    ];

    public function sensor() {
        return $this->belongsTo(Rpi::class);
    }
}
