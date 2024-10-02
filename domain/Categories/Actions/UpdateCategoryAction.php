<?php

namespace Domain\Categories\Actions;

use Domain\Categories\Models\Category;

readonly class UpdateCategoryAction
{
    public function execute(Category $category, array $data): Category
    {
        $category->update($data);

        return $category;
    }
}
