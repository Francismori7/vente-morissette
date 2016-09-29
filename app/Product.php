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

    /**
     * Featured products.
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeFeatured(Builder $query)
    {
        return $query->latest()->take(4);
    }

    /**
     * A product can be a part of multiple categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Returns the currency string for the product's price.
     *
     * @return string
     */
    public function asCurrency()
    {
        return money_format("$%i", $this->price / 100);
    }
}
