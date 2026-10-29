<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Every authenticated account may browse products.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Every authenticated account may view a product.
     */
    public function view(User $user, Product $product): bool
    {
        return true;
    }

    /**
     * Only administrators may create products.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only administrators may update products.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }

    /**
     * Only administrators may delete products.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->isAdmin();
    }
}
