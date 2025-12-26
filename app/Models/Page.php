<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'description',
        'short_description',
        'link',
        'slug',
        'order',
        'unique_id',
        'status',

        'seo_title',
        'meta_description',
        'meta_keywords'
    ];
}
