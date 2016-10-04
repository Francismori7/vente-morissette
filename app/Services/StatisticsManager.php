<?php

/*
 * Copyright (c) 2016 Mori7 Technologie inc.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associated documentation files (the "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF
 * CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE
 * OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace App\Services;

use App\Category;
use App\Product;
use App\User;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\Cache;

class StatisticsManager
{
    /**
     * @var CacheRepository
     */
    private $cache;

    /**
     * @var array
     */
    private $statistics = [];

    /**
     * StatisticsManager constructor.
     * @param CacheRepository $cache
     */
    public function __construct(CacheRepository $cache)
    {
        $this->cache = $cache;

        $this->refreshIfNecessary()->retrieve();
    }

    /**
     * Retrieves the data from the cache store.
     *
     * @return $this
     */
    private function retrieve()
    {
        $this->statistics = [
            'products' => $this->cache->get('stats.products'),
            'categories' => $this->cache->get('stats.categories'),
            'users' => $this->cache->get('stats.users'),
        ];

        return $this;
    }

    /**
     * Refreshes the statistics in the cache store if necessary.
     *
     * @return $this
     */
    private function refreshIfNecessary()
    {
        $this->cache->remember('stats.products', $this->cacheFor(), function () {
            return Product::count();
        });

        $this->cache->remember('stats.categories', $this->cacheFor(), function () {
            return Category::count();
        });

        $this->cache->remember('stats.users', $this->cacheFor(), function () {
            return User::count();
        });

        return $this;
    }

    /**
     * Gets the underlying statistics counters.
     *
     * @return object
     */
    public function toObject()
    {
        return (object) $this->statistics;
    }

    /**
     * Gets the underlying statistics counters.
     *
     * @return object
     */
    public function __invoke()
    {
        return $this->toObject();
    }

    /**
     * Cache the stats for 60 minutes.
     *
     * @return int
     */
    private function cacheFor()
    {
        return 60;
    }
}
