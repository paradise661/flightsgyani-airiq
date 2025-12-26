<?php

namespace App\Models\InternationalFlight;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SearchFlight extends Model
{
    protected $fillable = [
        'arrival', 'destination', 'adults', 'childs', 'infants', 'user_id', 'nationality', 'flight_date', 'return_date', 'flexible'
    ];

//    protected $appends = ['flight_date','return_date'];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getFlightDateAttribute($value)
    {
//        dd($value);
//        dd(Carbon::parse($value));
        return Carbon::parse($value);
    }

    public function getReturnDateAttribute($value)
    {

        if (isset($value)) {
            return Carbon::parse($value);
        } else {
            return null;
        }

    }

    public function searchedBy()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function haveBooking()
    {
        return $this->hasMany('App\Models\InternationalFlight\FlightBooking');
    }


}
