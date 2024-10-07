<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('roles', [RolesController::class, 'index']);

// Categories
Route::get('categories', [CategoriesController::class, 'index']);

// Products
Route::get('products', [ProductsController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    // File Upload
    Route::post('file-upload', [MediaController::class, 'store']);

    // Users
    Route::get('users', [UsersController::class, 'index'])->middleware('permission:view-any-user|view-own-user|view-himself');
    Route::post('users', [UsersController::class, 'store'])->middleware('permission:create-user');
    Route::put('users/{user}', [UsersController::class, 'update'])->middleware('permission:update-user');

    // Categories
    Route::post('categories', [CategoriesController::class, 'store'])->middleware('permission:create-category');
    Route::put('categories/{category}', [CategoriesController::class, 'update'])->middleware('permission:update-category');

    // Products
    Route::post('products', [ProductsController::class, 'store'])->middleware('permission:create-product');
    Route::put('products/{product}', [ProductsController::class, 'update'])->middleware('permission:update-product')->can('update', 'product');
    Route::delete('products/{product}', [ProductsController::class, 'destroy'])->middleware('permission:delete-product')->can('delete', 'product');
});
