<?php

namespace App\Models\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plasma extends Model
{
    use HasFactory;

    protected $fillable = [
        'endpoint',
        'test_endpoint',
        'username',
        'test_username',
        'password',
        'test_password',
        'agencyid',
        'test_agencyid',
        'environment',
        'company'
    ];
}
