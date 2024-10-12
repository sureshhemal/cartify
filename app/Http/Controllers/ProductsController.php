<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Domain\Products\Actions\DeleteProductAction;
use Domain\Products\Actions\GetProductsAction;
use Domain\Products\Actions\StoreProductAction;
use Domain\Products\Actions\UpdateProductAction;
use Domain\Products\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    public function index(GetProductsAction $getProductsAction): JsonResponse
    {
        return response()->json($getProductsAction->execute(
            user: auth()->user(),
            perPage: request('per_page', 20),
            page: request('page', 1),
            search: request('search')
        ));
    }

    public function store(ProductRequest $request, StoreProductAction $storeProductAction): JsonResponse
    {
        $storeProductAction->execute($request->data());

        return response()->json();
    }

    public function update(Product $product, ProductRequest $request, UpdateProductAction $updateProductAction): JsonResponse
    {
        $updateProductAction->execute($product, $request->data());

        return response()->json();
    }

    public function destroy(Product $product, DeleteProductAction $deleteProductAction): JsonResponse
    {
        $deleteProductAction->execute($product);

        return response()->json();
    }
}
