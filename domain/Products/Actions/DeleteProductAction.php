<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\Product;

readonly class DeleteProductAction
{
    public function execute(Product $product): void
    {
        $product->delete();
    }
}
