<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class ConnectIps extends Model
{
    protected $fillable = [
        'merchant_id', 'app_id', 'process_url', 'validation_url', 'transaction_url', 'status'
    ];
}
