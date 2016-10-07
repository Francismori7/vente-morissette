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

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can index the users.
     *
     * @param User $current
     * @return mixed
     */
    public function index(User $current)
    {
        $this->deny('Vous ne pouvez pas voir la liste des utilisateurs.');
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param User $current
     * @param User $user
     * @return mixed
     */
    public function view(User $current, User $user)
    {
        if (! $current->tokenCan('view-user')) {
            $this->deny("Vous n'avez pas autorisé l'application à voir votre compte.");
        }

        if ($current->id !== $user->id) {
            $this->deny('Vous ne pouvez pas voir un utilisateur autre que vous-même.');
        }

        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  User $current
     * @return mixed
     */
    public function create(User $current)
    {
        $this->deny('Vous ne pouvez pas créer de nouveaux utilisateurs.');
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  User $current
     * @param  User $user
     * @return mixed
     */
    public function update(User $current, User $user)
    {
        if (! $current->tokenCan('edit-user')) {
            $this->deny("Vous n'avez pas autorisé l'application à modifier votre compte.");
        }

        if ($current->id !== $user->id) {
            $this->deny('Vous ne pouvez pas modifier un utilisateur autre que vous-même.');
        }

        return true;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  User $current
     * @param  User $user
     * @return mixed
     */
    public function delete(User $current, User $user)
    {
        if (! $current->tokenCan('delete-user')) {
            $this->deny("Vous n'avez pas autorisé l'application à supprimer votre compte.");
        }

        if ($current->id !== $user->id) {
            $this->deny('Vous ne pouvez pas supprimer un utilisateur autre que vous-même.');
        }

        return true;
    }
}
