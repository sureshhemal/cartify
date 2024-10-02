<?php

namespace App\Http\Controllers;

use Domain\Categories\Actions\GetCategoriesAction;
use Domain\Categories\Actions\StoreCategoryAction;
use Domain\Categories\Actions\UpdateCategoryAction;
use Domain\Categories\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    public function index(GetCategoriesAction $getCategoriesAction): JsonResponse
    {
        return response()->json($getCategoriesAction->execute(
            search: request('search')
        ));
    }

    public function store(StoreCategoryAction $storeCategoryAction): JsonResponse
    {
        $storeCategoryAction->execute(request()->all());

        return response()->json();
    }

    public function update(Category $category, UpdateCategoryAction $updateCategoryAction): JsonResponse
    {
        $updateCategoryAction->execute($category, request()->all());

        return response()->json();
    }
}
