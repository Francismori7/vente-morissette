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

use App\Category;
use App\Product;
use App\User;

class HomeTest extends TestCase
{
    /** @test */
    public function it_shows_featured_products()
    {
        $this->visit('/');

        $featured = Product::featured()->get();

        foreach ($featured as $product) {
            $this->see($product->name);
            $this->see($product->asCurrency());
            $this->see($product->description);
            $this->seeElement('img', ['alt' => $product->name]);
            $this->seeElement('a', ['href' => route('products.show', $product)]);
        }
    }

    /** @test */
    public function it_shows_some_categories()
    {
        $this->visit('/');

        $categories = Category::forHomepage()->get();

        foreach ($categories as $category) {
            $this->see($category->name);
        }

        $this->see('Plus de catégories...');
    }

    /** @test */
    public function it_shows_the_basic_stats()
    {
        $this->visit('/');

        $this->seeElement('stats');
    }

    public function setUp()
    {
        parent::setUp();

        factory(Product::class, 100)->create();
        factory(Category::class, 10)->create();
        factory(User::class, 10)->create();
    }
}
