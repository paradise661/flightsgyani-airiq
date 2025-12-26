<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Model;

class Khalti extends Model
{
    protected $fillable = [
        'public_key', 'secret_key', 'status'
    ];
}
