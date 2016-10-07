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
use App\Scopes\UnsoldProductScope;

class ProductsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        factory(Product::class, 200)->create();
        factory(Product::class, 50)->create(['sold_at' => new DateTime]);
    }

    /** @test */
    public function it_gets_the_featured_products()
    {
        $products = Product::featured()->get();

        $this->assertCount(4, $products);
    }

    /** @test */
    public function it_gets_all_unsold_products()
    {
        $products = Product::all();

        $this->assertCount(200, $products);
    }

    /** @test */
    public function it_can_have_multiple_categories()
    {
        /** @var Product $product */
        $product = factory(Product::class)->create();

        $this->assertEmpty($product->categories()->get());

        factory(Category::class)->create(['id' => 1337]);
        factory(Category::class)->create(['id' => 1338]);

        $product->categories()->attach(1337);
        $product->categories()->attach(1338);

        $this->assertCount(2, $product->categories()->get());
        $this->assertEquals(1337, $product->categories()->get()[0]->id);
        $this->assertEquals(1338, $product->categories()->get()[1]->id);

        $product->categories()->sync([]);

        $this->assertEmpty($product->categories()->get());
    }

    /** @test */
    public function it_provides_the_currency()
    {
        $product = new Product(['price' => 124]);
        $this->assertEquals('$1,24', $product->asCurrency());

        $product = new Product(['price' => -45]);
        $this->assertEquals('$(0,45)', $product->asCurrency());
    }

    /** @test */
    public function it_doesnt_show_sold_products()
    {
        $products = Product::all();

        $this->assertCount(200, $products);

        $products = Product::withoutGlobalScope(UnsoldProductScope::class)->get();

        $this->assertCount(250, $products);
    }
}
