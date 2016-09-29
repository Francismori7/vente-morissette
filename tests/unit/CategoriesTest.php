<?php

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CategoriesTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        factory(Category::class, 15)->create();
    }

    /** @test */
    public function it_gets_all_categories()
    {
        $categories = Category::all();

        $this->assertCount(15, $categories);
    }

    /** @test */
    public function it_can_contain_products()
    {
        /** @var Category $category */
        $category = Category::first();

        factory(Product::class, 20)->create();

        $category->products()->sync(Product::take(10)->pluck('id')->toArray());

        $this->assertCount(10, $category->products()->get());
    }
}
