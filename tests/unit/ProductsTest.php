<?php

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        factory(Product::class, 200)->create();
    }

    /** @test */
    public function it_gets_the_featured_products()
    {
        $products = Product::featured()->get();

        $this->assertCount(4, $products);
    }

    /** @test */
    public function it_gets_all_products()
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
    public function it_calculates_the_currency()
    {
        $product = new Product(['price' => 124]);
        $this->assertEquals("$1,24 CAD", $product->asCurrency());

        $product = new Product(['price' => -45]);
        $this->assertEquals("$(0,45 CAD)", $product->asCurrency());
    }

}