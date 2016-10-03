<?php

namespace App;

use App\Scopes\UnsoldProductScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Product.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @method static \Illuminate\Database\Query\Builder|\App\Product featured()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $price
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Product whereDeletedAt($value)
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'price',
        'description',
    ];

    protected $dates = [
        'sold_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UnsoldProductScope);
    }

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
        return currency($this->price);
    }

    /**
     * Determines if the product is sold.
     *
     * @return bool
     */
    public function isSold()
    {
        return $this->sold_at !== null;
    }
}
