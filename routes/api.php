<?php

use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('roles', [RolesController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    // Users
    Route::get('users', [UsersController::class, 'index']);
    Route::post('users', [UsersController::class, 'store']);
    Route::put('users/{user}', [UsersController::class, 'update']);
});
