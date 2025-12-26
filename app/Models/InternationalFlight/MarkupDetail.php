<?php

namespace App\Models\InternationalFlight;

use Illuminate\Database\Eloquent\Model;

class MarkupDetail extends Model
{
    protected $fillable = [
        'adt_margin', 'chd_margin', 'inf_margin', 'std_margin', 'lbr_margin',
        'adt_calc_type', 'chd_calc_type', 'inf_calc_type', 'std_calc_type', 'lbr_calc_type',
        'adt_amount_type', 'chd_amount_type', 'inf_amount_type', 'std_amount_type', 'lbr_amount_type',
        'markup_id', 'currency'
    ];

    public function markup()
    {
        return $this->belongsTo('App\Models\InternationalFlight\Markup', 'markup_id');
    }
}
