<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'country', 'city', 'airport', 'code'
    ];
}
