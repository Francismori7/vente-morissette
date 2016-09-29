<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\App\Category forHomepage()
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category whereUpdatedAt($value)
 */
class Category extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * A category contains multiple products.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Categories to display on the home page.
     *
     * @param Builder $query
     */
    public function scopeForHomepage(Builder $query)
    {
        $query->take(self::countOnHomepage())->orderBy('name');
    }

    /**
     * Maximum number of categories to display on home page.
     * @return int
     */
    public static function countOnHomepage()
    {
        return 6;
    }

    /**
     * Route model binding for categories should use the name field.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
