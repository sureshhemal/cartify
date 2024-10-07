<?php

namespace Domain\Products\Actions;

use Domain\Products\DTOs\ProductData;
use Domain\Products\Models\Product;
use Domain\Support\Media\MediaHandler;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class UpdateProductAction
{
    public function execute(Product $product, ProductData $data): Product
    {
        DB::beginTransaction();

        try {
            $product->update([
                'name' => $data->name,
                'code' => $data->code,
                'description' => $data->description,
                'price' => $data->price,
                'category_id' => $data->categoryId,
                'seller_id' => $data->sellerId,
                'quantity' => $data->quantity,
            ]);

            MediaHandler::syncModelWithMedia($product, $data->media);

            DB::commit();

            return $product;
        } catch (Throwable $exception) {
            DB::rollBack();

            throw $exception;
        }

    }
}
