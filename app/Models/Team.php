<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'image',
        'short_description',
        'fb',
        'instagram',
        'twitter',
        'position',
        'order',
        'status'
    ];
}
