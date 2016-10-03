<?php

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
