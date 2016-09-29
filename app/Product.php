<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'description',
    ];

    public function scopeFeatured(Builder $query)
    {
        return $query->latest()->take(4);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
