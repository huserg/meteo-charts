<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Humidity extends Model
{
    use HasFactory, SoftDeletes;

    protected array $fillable = [
        'percent',
        'device_id',
    ];

    public function device() : HasOne {
        return $this->hasOne(Device::class);
    }
}
