<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::featured()->with('categories')->get();
        $categories = Category::forHomepage()->withCount('products')->get();

        $stats = new class {
            public $categories;
            public $products;

            public function __construct()
            {
                $this->categories = Category::count();
                $this->products = Product::count();
            }


        };

        return view('home', compact('products', 'categories', 'stats'));
    }
}
