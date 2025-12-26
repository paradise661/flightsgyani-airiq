<?php

namespace App\Models;

use App\Models\B2B\Transaction;
use App\Models\Domestic\DomesticFlightBooking;
use App\Models\InternationalFlight\FlightBooking;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    // use LaratrustUserTrait;
    // use SoftDeletes;
    use ThrottlesLogins;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phonenumber',
        'active',
        'provider_id',
        'provider_type',
        'provider_token',
        'user_type',
        'address',
        'pan_vat_number',
        'contact_person',
        'agent_group_id',
        'verified',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $dates = ['deleted_at'];


    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // public function sendEmailVerificationNotification()
    // {
    //     $this->notify(new CustomVerifyEmail);  // Use the custom notification
    // }

    public function agentGroup()
    {
        return $this->belongsTo('App\Models\B2B\AgentGroup', 'agent_group_id');
    }

    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, 'agent_id', 'id');
    }

    public function domesticBookings()
    {
        return $this->hasMany(DomesticFlightBooking::class, 'user_id')->latest();
    }

    public function internationalBookings()
    {
        return $this->hasMany(FlightBooking::class, 'user_id')->latest();
    }
}
