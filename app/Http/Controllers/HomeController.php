<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Services\StatisticsManager;

class HomeController extends Controller
{
    /**
     * Show the home page.
     *
     * @param StatisticsManager $statisticsManager
     * @return \Illuminate\Http\Response
     */
    public function index(StatisticsManager $statisticsManager)
    {
        $products = \Cache::remember('products.featured', 5, function() {
            return Product::featured()->with('categories')->get();
        });
        $categories = \Cache::remember('categories.homepage', 5, function() {
            return Category::forHomepage()->withCount('products')->get();
        });

        $stats = $statisticsManager();

        return view('home', compact('products', 'categories', 'stats'));
    }

    /**
     * Shows the advanced search page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search()
    {
        return view('search');
    }
}
