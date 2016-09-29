<?php

use App\Category;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatisticsManagerTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        factory(Category::class, 15)->create();
        factory(Product::class, 5)->create();
        factory(User::class, 10)->create();
    }

    /** @test */
    public function it_can_retrieve_the_proper_stats()
    {
        $statisticsManager = $this->app->make(\App\Services\StatisticsManager::class);

        $this->assertEquals((object) [
            'categories' => 15,
            'products' => 5,
            'users' => 10,
        ], $statisticsManager());
    }

}
