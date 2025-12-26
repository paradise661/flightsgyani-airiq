<?php

namespace App\Models\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticFlightPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'payment_id',
        'pgw_reference_id',
        'pidx',
        'transaction_id',
        'total_booking_amount',
        'currency',
        'payment_date',
        'payment_status',
        'payment_type'
    ];
}
