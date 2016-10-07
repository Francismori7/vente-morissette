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

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\User\CreateUser;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('index', User::class);

        $limit = min($request->input('limit', 25), 100);
        $paginator = User::paginate($limit);
        $users = $paginator->getCollection();

        return fractal()
            ->collection($users)
            ->transformWith(new UserTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
    }

    /**
     * Display a user.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'name' => 'max:255',
            'city' => 'max:255',
            'email' => 'email|max:255|unique:users,email,'.$user->id,
            'password' => 'min:6|confirmed',
        ]);

        $user->update($request->except(['avatar']));

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta(['success' => true, 'message' => "L'utilisateur a été modifié."])
            ->toArray();
    }

    /**
     * Create a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $this->validate($request, [
            'name' => 'required|max:255',
            'city' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = $this->dispatch(new CreateUser([
            'name' => $request->get('name'),
            'city' => $request->get('city'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]));

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta(['success' => true, 'message' => "L'utilisateur a été créé."])
            ->toArray();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->addMeta(['success' => true, 'message' => "L'utilisateur a été supprimé."])
            ->toArray();
    }
}
