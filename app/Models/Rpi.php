<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rpi extends Model
{
    use SoftDeletes;

    protected $table = 'rpi';

    protected $fillable = [
        'location', 'local_ip', 'created_at', 'cancelled_at'
    ];


    public function temperature() {
        return $this->hasMany(Temperature::class);
    }

    public function light() {
        return $this->hasMany(Light::class);
    }

    public function humidity() {
        return $this->hasMany(Humidity::class);
    }

    public function pressure() {
        return $this->hasMany(Pressure::class);
    }
}
