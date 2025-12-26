<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'payment_type', 'amount', 'transaction_id', 'booking_id', 'status', 'resp_code', 'fraud_code', 'invoice_no',
        'date_time', 'payment_gateway_id', 'approval_code', 'booking_type'
    ];

    public function ofPayment()
    {
        return $this->morphTo('booking');
    }
}
