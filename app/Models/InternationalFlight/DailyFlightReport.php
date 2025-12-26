<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class DailyFlightReport extends Model
{
    protected $fillable = [
        'date', 'pnr', 'time', 'amount', 'currency', 'pax', 'commission', 'ticket', 'status', 'void_amount', 'airline', 'commission_percent'
    ];
}
