<?php

namespace Domain\Categories\Actions;

use Domain\Categories\Models\Category;

readonly class StoreCategoryAction
{
    public function execute(array $data): Category
    {
        return Category::create($data);
    }
}
