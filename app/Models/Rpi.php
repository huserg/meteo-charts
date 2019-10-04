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


}
