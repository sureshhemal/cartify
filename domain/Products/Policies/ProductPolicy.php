<?php

namespace Domain\Products\Policies;

use Domain\Products\Models\Product;
use Domain\Users\Models\User;

class ProductPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->hasAnyRole('SUPER_ADMIN', 'ADMIN')) {
            return true;
        }

        return null;
    }

    public function update(User $user, Product $product): bool
    {
        return $product->seller_id === $user->getKey();
    }

    public function delete(User $user, Product $product): bool
    {
        return $product->seller_id === $user->getKey();
    }
}
