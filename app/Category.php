<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeForHomepage(Builder $query)
    {
        $query->take(Category::countOnHomepage())->orderBy('name');
    }

    public static function countOnHomepage()
    {
        return 6;
    }
}
