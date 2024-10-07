<?php

namespace Domain\Products\DTOs;

use Brick\Money\Money;

readonly class ProductData
{
    public function __construct(
        public string $name,
        public string $code,
        public string $sellerId,
        public string $categoryId,
        public string $description,
        public int $quantity,
        public Money $price,
        public array $media,
        public ?string $id = null,
    ) {}
}
