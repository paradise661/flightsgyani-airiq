<?php

namespace App\Models\Domestic;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticFlightBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'booking_code',
        'coupon_code',
        'sector_from',
        'sector_to',
        'departure_date',
        'arrival_date',
        'flight_type',
        'adult_count',
        'child_count',
        'nationality',
        'total_booking_amount',
        'emergency_contact_title',
        'emergency_contact_fullname',
        'emergency_contact_email',
        'emergency_contact_phone',
        'ticket_status',
        'is_office_staff',
        'discount_amount',
    ];

    public function payment()
    {
        return $this->hasOne(DomesticFlightPayment::class, 'booking_id');
    }

    public function flightInfo()
    {
        return $this->hasMany(DomesticFlightInfo::class, 'booking_id');
    }

    public function flightTicket()
    {
        return $this->hasMany(DomesticFlightTicket::class, 'booking_id');
    }

    public function flightPassengers()
    {
        return $this->hasMany(DomesticPassenger::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
