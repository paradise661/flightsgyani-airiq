<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class BSPCommission extends Model
{
    protected $fillable = [
        'airline', 'commission', 'with_origin', 'without_origin'
    ];
}
