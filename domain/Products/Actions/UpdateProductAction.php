<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\ProductData;
use Domain\Products\Models\Product;

readonly class UpdateProductAction
{
    public function execute(Product $product, ProductData $data): Product
    {
        $product->update([
            'name' => $data->name,
            'code' => $data->code,
            'description' => $data->description,
            'price' => $data->price,
            'category_id' => $data->categoryId,
            'seller_id' => $data->sellerId,
            'quantity' => $data->quantity,
        ]);

        return $product;
    }
}
