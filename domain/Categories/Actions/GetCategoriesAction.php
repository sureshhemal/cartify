<?php

namespace Domain\Categories\Actions;

use Domain\Categories\Models\Category;
use Illuminate\Support\Collection;

readonly class GetCategoriesAction
{
    public function execute(?string $search = null): Collection
    {
        return Category::query()
            ->when($search, fn ($query, $search) => $query->search($search))
            ->get();
    }
}
