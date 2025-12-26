<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'order',
        'status'
    ];

    protected $table = 'f_a_qs';
}
