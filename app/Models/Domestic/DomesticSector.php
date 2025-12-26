<?php

namespace App\Models\Domestic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomesticSector extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'image',
        'text',
        'status',
        'order'
    ];
}
