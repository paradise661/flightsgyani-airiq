<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children($id)
    {
        return Category::whereParentId($id)->get();
    }
}
