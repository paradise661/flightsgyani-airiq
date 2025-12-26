<?php

namespace App\Models\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticFlightTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'airline',
        'pnr_no',
        'title',
        'gender',
        'first_name',
        'last_name',
        'pax_type',
        'nationality',
        'issue_from',
        'agency_name',
        'issue_date',
        'issue_by',
        'flight_no',
        'flight_date',
        'departure',
        'flight_time',
        'ticket_no',
        'arrival',
        'arrival_time',
        'sector',
        'class_code',
        'currency',
        'fare',
        'surcharge',
        'tax_currency',
        'tax',
        'commission_amount',
        'refundable',
        'invoice',
        'reporting_time',
        'free_baggage',
        'status'
    ];
}
