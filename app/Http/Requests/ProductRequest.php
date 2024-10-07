<?php

namespace App\Http\Requests;

use Brick\Money\Money;
use Domain\Products\DTOs\ProductData;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function data(): ProductData
    {
        return new ProductData(
            name: $this->input('name'),
            code: $this->input('code'),
            sellerId: $this->input('seller_id'),
            categoryId: $this->input('category_id'),
            description: $this->input('description'),
            quantity: $this->input('quantity'),
            price: Money::ofMinor(
                $this->input('price.amount'),
                $this->input('price.currency')
            ),
            id: $this->input('id'),
        );
    }
}
