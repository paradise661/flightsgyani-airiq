<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class HotDeal extends Model
{
    protected $fillable = [
        'airline', 'departure', 'arrival', 'class', 'amount', 'trip_type', 'pax_types', 'book_start_date',
        'book_end_date', 'ticket_start_date', 'ticket_end_date', 'user_id'
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
