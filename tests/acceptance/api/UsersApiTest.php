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

use App\User;

class UsersApiTest extends ApiTestCase
{
    /** @test */
    public function it_lists_all_users()
    {
        $regularUser = factory(User::class)->create();
        $adminUser = factory(User::class)->create(['is_admin' => true]);

        $this->ajax('GET', '/api/users')->seeJson(['error' => 'Unauthenticated.']);

        $this->actingAs($regularUser, 'api');

        $this->ajax('GET', '/api/users')->seeJson(['error' => 'Vous ne pouvez pas voir la liste des utilisateurs.']);

        $this->actingAs($adminUser, 'api');

        // Picked up by unit/UsersTest, just testing the authorization here.
        $this->ajax('GET', '/api/users')->seeJsonStructure([
            'data' => [
                [],
                [],
            ],
        ]);
    }

    /** @test */
    public function it_shows_a_user()
    {
        $regularUser = factory(User::class)->create(['id' => 1]);
        $regularUser = $regularUser->withAccessToken($regularUser->createToken('Testing', ['view-user'])->token);
        $adminUser = factory(User::class)->create(['id' => 2, 'is_admin' => true]);
        $adminUser = $adminUser->withAccessToken($adminUser->createToken('Testing', ['view-user'])->token);

        $this->ajax('GET', '/api/users/1')
            ->seeStatusCode(401)
            ->seeJson(['error' => 'Unauthenticated.']);

        $this->actingAs($regularUser, 'api');

        $this->ajax('GET', '/api/users/2')
            ->seeJson([
                'error' => 'Vous ne pouvez pas voir un utilisateur autre que vous-même.',
            ]);
        $this->ajax('GET', '/api/users/1')
            ->seeJsonStructure([
                'data' => [],
            ]);

        $this->actingAs($adminUser, 'api');

        $this->ajax('GET', '/api/users/1')
            ->seeJsonStructure([
                'data' => [],
            ]);
        $this->ajax('GET', '/api/users/2')
            ->seeJsonStructure([
                'data' => [],
            ]);
    }

    /** @test */
    public function it_updates_a_user()
    {
        $regularUser = factory(User::class)->create(['id' => 1]);
        $regularUser = $regularUser->withAccessToken($regularUser->createToken('Testing', ['edit-user'])->token);
        $adminUser = factory(User::class)->create(['id' => 2, 'is_admin' => true]);
        $adminUser = $adminUser->withAccessToken($adminUser->createToken('Testing', ['edit-user'])->token);

        $parameters = ['name' => 'Hello World'];

        $this->ajax('PATCH', '/api/users/1', $parameters)->seeJson(['error' => 'Unauthenticated.']);

        $this->actingAs($regularUser, 'api');

        $this->ajax('PATCH', '/api/users/1', $parameters)
            ->seeJsonContains($parameters)
            ->seeJsonSubset([
                'meta' => [
                    'success' => true,
                    'message' => "L'utilisateur a été modifié.",
                ],
            ]);
        $this->ajax('PATCH', '/api/users/2', $parameters)
            ->seeJson([
                'error' => 'Vous ne pouvez pas modifier un utilisateur autre que vous-même.',
            ]);

        $this->actingAs($adminUser, 'api');

        $this->ajax('PATCH', '/api/users/1', $parameters)
            ->seeJsonContains($parameters)
            ->seeJsonSubset([
                'meta' => [
                    'success' => true,
                    'message' => "L'utilisateur a été modifié.",
                ],
            ]);
        $this->ajax('PATCH', '/api/users/2', $parameters)
            ->seeJsonContains($parameters)
            ->seeJsonSubset([
                'meta' => [
                    'success' => true,
                    'message' => "L'utilisateur a été modifié.",
                ],
            ]);
    }

    /** @test */
    public function it_stores_a_new_user()
    {
        $regularUser = factory(User::class)->create();
        $adminUser = factory(User::class)->create(['is_admin' => true]);
        $userData = factory(User::class)->make()->setHidden([])->toArray();

        $this->ajax('POST', '/api/users', $userData)->seeJson(['error' => 'Unauthenticated.']);

        $this->actingAs($regularUser, 'api');

        $this->ajax('POST', '/api/users',
            $userData)->seeJson(['error' => 'Vous ne pouvez pas créer de nouveaux utilisateurs.']);

        $this->actingAs($adminUser, 'api');

        $this->ajax('POST', '/api/users', $userData)
            ->seeJsonStructure([
                'data' => [],
            ])->seeJsonSubset([
                'meta' => [
                    'success' => true,
                    'message' => "L'utilisateur a été créé.",
                ],
            ]);
    }

    /** @test */
    public function it_deletes_a_user()
    {
        $regularUser = factory(User::class)->create(['id' => 1]);
        $regularUser = $regularUser->withAccessToken($regularUser->createToken('Testing', ['delete-user'])->token);
        $adminUser = factory(User::class)->create(['id' => 2, 'is_admin' => true]);
        $adminUser = $adminUser->withAccessToken($adminUser->createToken('Testing', ['delete-user'])->token);
        factory(User::class)->create(['id' => 3]);

        $this->ajax('DELETE', '/api/users/1')->seeJson(['error' => 'Unauthenticated.']);

        $this->actingAs($regularUser, 'api');

        $this->ajax('DELETE', '/api/users/2')
            ->seeJson([
                'error' => 'Vous ne pouvez pas supprimer un utilisateur autre que vous-même.',
            ]);
        $this->ajax('DELETE', '/api/users/1')
            ->seeJsonStructure([
                'data' => [],
            ])
            ->seeJsonSubset([
                'meta' => [
                    'success' => true,
                    'message' => "L'utilisateur a été supprimé.",
                ],
            ]);

        $this->actingAs($adminUser, 'api');

        $this->ajax('DELETE', '/api/users/3')
            ->seeJsonStructure([
                'data' => [],
            ])
            ->seeJsonSubset([
                'meta' => [
                    'success' => true,
                    'message' => "L'utilisateur a été supprimé.",
                ],
            ]);
    }
}
