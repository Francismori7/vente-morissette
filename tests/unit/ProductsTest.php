<?php

use App\Category;
use App\Product;
use App\Scopes\UnsoldProductScope;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

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
