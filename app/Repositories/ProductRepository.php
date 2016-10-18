<?php

namespace App\Repositories;

use App\Product;
use Cache;

class ProductRepository
{
    public function paginate($limit)
    {
        $page = request()->input('page', 1);

        return Cache::remember("products.{$limit}-per-page.page-{$page}", 10, function() use ($limit) {
            return Product::with('categories')->latest()->paginate($limit);
        });
    }
}