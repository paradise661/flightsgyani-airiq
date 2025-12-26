<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    protected $fillable = [
        'name', 'code', 'image'
    ];
}
