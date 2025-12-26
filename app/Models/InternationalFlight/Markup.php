<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class Markup extends Model
{
    protected $fillable = [
        'type', 'airline', 'origin', 'destination', 'trip_type', 'user_id', 'priority', 'status', 'last_updated_by',
        'class', 'soto', 'siti'
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo('App\Models\User', 'last_updated_by');
    }

    public function details()
    {
        return $this->hasMany('App\Models\InternationalFlight\MarkupDetail', 'markup_id');
    }

    public function agentCommission()
    {
        return $this->hasMany('App\Models\InternationalFlight\AgentFlightCommission', 'rule_id');
    }
}
