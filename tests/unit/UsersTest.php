<?php

use App\Transformers\UserTransformer;
use App\User;

class UsersTest extends TestCase
{
    /** @test */
    public function it_transforms_a_user_properly()
    {
        /** @var User $user */
        $user = factory(User::class)->create();

        $this->assertEquals([
            "data" => [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
                "avatar" => $user->avatar,
                "city" => $user->city,
                "is_admin" => $user->is_admin,
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at,
                "deleted_at" => $user->deleted_at,
            ]
        ], fractal()->item($user)->transformWith(new UserTransformer)->toArray());
    }

}