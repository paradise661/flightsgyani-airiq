<?php

namespace App\Models\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticFlightCommission extends Model
{
    use HasFactory;

    protected $fillable = [
        'domestic_airline_id',
        'domestic_airline',
        'domestic_airline_code',
        'domestic_airline_class',
        'commission_type',
        'commission',
        'agent_commission',
        'status'
    ];
}
