<?php

namespace Domain\Products\Policies;

use Domain\Products\Models\Product;
use Domain\Users\Models\User;

class ProductPolicy
{
    public function update(User $user, Product $product): bool
    {
        return $user->hasAnyRole('SUPER_ADMIN', 'ADMIN')
            || $product->seller_id === $user->getKey();
    }
}
