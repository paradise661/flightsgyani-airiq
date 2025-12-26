<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class GroupFlightBooking extends Model
{
    protected $fillable = [
        'departure', 'arrival', 'depart_date', 'return_date', 'adults', 'childs', 'infants',
        'preferred_airline', 'contact_number', 'notes', 'user_id', 'status', 'confirmed_by'
    ];

    public function requestedBy()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function confirmedBy()
    {
        return $this->belongsTo('App\Models\User', 'confirmed_by');
    }

    public function getChildsAttribute($value)
    {
        if (isset($value)) {
            return $value;
        } else {
            return 0;
        }
    }

    public function getInfantsAttribute($value)
    {
        if (isset($value)) {
            return $value;
        } else {
            return 0;
        }
    }

    public function getReturnDateAttribute($value)
    {
        if (isset($value)) {
            return $value;
        } else {
            return 'One Way';
        }
    }


}
