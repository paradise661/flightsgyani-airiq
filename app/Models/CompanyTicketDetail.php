<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTicketDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_logo',
        'company_email',
        'company_contact',
        'emergency_contact',
        'company_address',
        'contact_details',
        'domestic_flight_rules',
        'international_flight_rules',
        'user_id',
        'status'
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
