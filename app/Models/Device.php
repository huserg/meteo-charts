<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected array $fillable = [
        'name',
        'mac_address',
        'token',
        'is_registrating',
        'owner_id'
    ];

    public function owner(): HasOne {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }

    public function temperatures(): BelongsToMany {
        return $this->belongsToMany(Temperature::class);
    }
    public function humidities(): BelongsToMany {
        return $this->belongsToMany(Humidity::class);
    }
    public function pressures(): BelongsToMany {
        return $this->belongsToMany(Pressure::class);
    }
    public function battery_levels(): BelongsToMany {
        return $this->belongsToMany(BatteryLevel::class);
    }


    protected static function booted()
    {
        static::addGlobalScope('user', function (Builder $builder) {
            $builder->where('owner_id', auth()->id());
        });
    }

}
