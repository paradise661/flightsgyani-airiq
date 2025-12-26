<?php

namespace App\Models\B2B;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'agent_id',
        'invoice_id',
        'transaction_type',
        'currency_type',
        'amount',
        'load_by',
        'load_type',
        'status',
        'invoice_date',
        'due_date',
        'remaining_balance_npr',
        'remaining_balance_usd',
        'remarks',
    ];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'load_by');
    }
}
