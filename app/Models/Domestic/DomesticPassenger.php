<?php

namespace App\Models\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticPassenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'title',
        'first_name',
        'last_name',
        'pax_type',
        'gender',
        'nationality',
        'status'
    ];
}
