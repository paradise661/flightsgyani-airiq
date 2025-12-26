<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalFlightCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'international_airline_id',
        'international_airline',
        'international_airline_code',
        'international_airline_class',
        'commission_type',
        'commission',
        'agent_commission',
        'status',
        'child_commission',
        'infant_commission',
        'agent_child_commission',
        'agent_infant_commission',
    ];
}
