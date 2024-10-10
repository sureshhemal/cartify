<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\ProductData;
use Domain\Products\Models\Product;

readonly class StoreProductAction
{
    public function execute(ProductData $data): Product
    {
        return Product::create([
            'name' => $data->name,
            'code' => $data->code,
            'description' => $data->description,
            'price' => $data->price,
            'category_id' => $data->categoryId,
            'seller_id' => $data->sellerId,
            'quantity' => $data->quantity,
        ]);
    }
}
