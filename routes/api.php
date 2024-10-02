<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('roles', [RolesController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    // Users
    Route::get('users', [UsersController::class, 'index'])->middleware('permission:view-any-user|view-own-user');
    Route::post('users', [UsersController::class, 'store'])->middleware('permission:create-user');
    Route::put('users/{user}', [UsersController::class, 'update'])->middleware('permission:update-user');

    // Categories
    Route::get('categories', [CategoriesController::class, 'index'])->middleware('permission:view-category');
    Route::post('categories', [CategoriesController::class, 'store'])->middleware('permission:create-category');
    Route::put('categories/{category}', [CategoriesController::class, 'update'])->middleware('permission:update-category');
});
