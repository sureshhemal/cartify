<?php

namespace Domain\Categories\QueryBuilders;

use Domain\Categories\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class CategoryQueryBuilder extends Builder
{
    public function search(string $search): static
    {
        return $this->where(function ($query) use ($search) {
            collect(Category::SEARCHABLE_FIELDS)
                ->each(fn ($field) => $query->orWhere($field, 'LIKE', "%{$search}%"));
        });
    }
}
