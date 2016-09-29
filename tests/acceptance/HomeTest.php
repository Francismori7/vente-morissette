<?php

use App\Category;
use App\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomeTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /** @test */
    public function it_shows_featured_products()
    {
        $this->visit('/');

        $featured = Product::featured()->get();

        foreach ($featured as $product) {
            $this->see($product->name);
            $this->see($product->asCurrency());
            $this->see($product->description);
            $this->seeLink('Détails', "/produits/{$product->id}");
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

    protected function setUp()
    {
        parent::setUp();

        factory(Product::class, 100)->create();
        factory(Category::class, 10)->create();
    }

}