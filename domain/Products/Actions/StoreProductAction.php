<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\ProductData;
use Domain\Products\Models\Product;
use Domain\Support\Media\MediaHandler;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class StoreProductAction
{
    public function execute(ProductData $data): Product
    {
        DB::beginTransaction();

        try {
            $product = $this->saveProduct($data);

            MediaHandler::syncModelWithMedia($product, $data->media);

            DB::commit();

            return $product;
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    protected function saveProduct(ProductData $data)
    {
        $product = Product::create([
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
