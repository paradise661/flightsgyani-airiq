<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class FlightBookingDetail extends Model
{
    protected $fillable = [
        'flight_booking_id', 'pax_name', 'pax_type', 'pax_gender', 'dob', 'nationality', 'doc_type',
        'doc_number', 'doc_expiry_date', 'doc_issued_by', 'pricing', 'pax_mid_name', 'pax_last_name',
        'meal_code', 'ssr_request', 'freq_flyer', 'request', 'freq_flyer_airline'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];
    protected $appends = ['full_name'];

    public function ofBooking()
    {
        return $this->belongsTo('App\Models\InternationalFlight\FlightBooking');
    }

    public function getFullNameAttribute()
    {
        return $this->pax_name . ' ' . $this->pax_mid_name . ' ' . $this->pax_last_name;
    }
}
