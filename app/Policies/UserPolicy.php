<?php

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
        if (!$current->tokenCan('view-user')) {
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
        if (!$current->tokenCan('edit-user')) {
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
        if (!$current->tokenCan('delete-user')) {
            $this->deny("Vous n'avez pas autorisé l'application à supprimer votre compte.");
        }

        if ($current->id !== $user->id) {
            $this->deny('Vous ne pouvez pas supprimer un utilisateur autre que vous-même.');
        }

        return true;
    }
}
