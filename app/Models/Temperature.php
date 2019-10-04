<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temperature extends Model
{
    protected $table = 'temperature';

    protected $fillable = [
        'degree', 'created_at'
    ];

    public function sensor() {
        return $this->belongsTo(Rpi::class);
    }
}
