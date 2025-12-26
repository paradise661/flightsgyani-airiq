<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = ['id'];

    public function author()
    {
        return $this->hasOne(Author::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
