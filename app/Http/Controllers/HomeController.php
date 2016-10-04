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
        $products = \Cache::remember('products.featured', 5, function () {
            return Product::featured()->with('categories')->get();
        });
        $categories = \Cache::remember('categories.homepage', 5, function () {
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
