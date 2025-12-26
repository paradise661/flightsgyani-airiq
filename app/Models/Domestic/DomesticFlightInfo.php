<?php

namespace App\Models\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticFlightInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'flight_type',
        'pnr_no',
        'airline',
        'flight_date',
        'flight_no',
        'flight_id',
        'departure',
        'departure_time',
        'arrival',
        'arrival_time',
        'aircraft_type',
        'adult',
        'child',
        'infant',
        'flight_class_code',
        'currency',
        'adult_fare',
        'child_fare',
        'infant_fare',
        'res_fare',
        'fuel_surcharge',
        'tax',
        'refundable',
        'free_baggage',
        'agency_commission',
        'child_commission',
        'calling_station_id',
        'calling_station',
        'status'
    ];
}
