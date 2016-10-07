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

class LayoutTest extends TestCase
{
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

    /** @test */
    public function it_shows_admin_links_for_admins()
    {
        $this->visit('/')->dontSee('Administration');

        $this->actingAs(factory(App\User::class)->create(['is_admin' => true]));

        $this->visit('/')->see('Administration');
    }
}
