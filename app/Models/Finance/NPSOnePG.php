<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class NPSOnePG extends Model
{
    protected $table = 'nps_onepg';

    protected $fillable = [
        'redirection_url',
        'process_id_url',
        'instrument_url',
        'transaction_url',
        'username',
        'password',
        'merchant_id',
        'merchant_name',
        'secret_key',
        'status',
        'additional_charge'
    ];

}
