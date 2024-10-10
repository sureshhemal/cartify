<?php

namespace Domain\Products\QueryBuilders;

use Domain\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductQueryBuilder extends Builder
{
    public function search(string $search): static
    {
        return $this->where(function ($query) use ($search) {
            collect(Product::SEARCHABLE_FIELDS)
                ->each(fn ($field) => $query->orWhere($field, 'LIKE', "%{$search}%"));
        });
    }
}
