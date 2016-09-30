<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LayoutTest extends TestCase
{
    use DatabaseTransactions, DatabaseMigrations;

    /** @test */
    public function it_shows_the_logged_in_user()
    {
        $this->visit('/')->see('Connexion')->dontSee('Déconnexion');

        $this->actingAs($user = factory(App\User::class)->create());

        $this->visit('/')->see('Déconnexion')->see($user->name);
    }

    /** @test */
    public function it_shows_the_users_cart()
    {
        $this->visit('/')->see('Panier')->seeElement('span.fa.fa-shopping-cart');
    }

}
