<?php

namespace App\Models\B2B;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'created_by',
        'status',
        'order'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
