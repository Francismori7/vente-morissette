<?php

namespace App\Policies;

use App\User;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Admins can do it all.
     *
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can create products.
     *
     * @param  User $user
     * @return mixed
     */
    public function create(User $user)
    {
        $this->deny('Vous ne pouvez pas créer de nouveaux produits.');
    }

    /**
     * Determine whether the user can update the product.
     *
     * @param  User $user
     * @param  Product $product
     * @return mixed
     */
    public function update(User $user, Product $product)
    {
        $this->deny('Vous ne pouvez pas modifier les produits.');
    }

    /**
     * Determine whether the user can delete the product.
     *
     * @param  User $user
     * @param  Product $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        $this->deny('Vous ne pouvez pas supprimer les produits.');
    }
}
