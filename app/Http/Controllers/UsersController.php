<?php

namespace App\Http\Controllers;

use Domain\Users\Actions\GetUsersAction;
use Domain\Users\Actions\StoreUserAction;
use Domain\Users\Actions\UpdateUserAction;
use Domain\Users\Models\User;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function index(GetUsersAction $getUsersAction): JsonResponse
    {
        return response()->json($getUsersAction->execute(
            askingUser: auth()->user(),
            perPage: request('per_page'),
            page: request('page'),
            search: request('search'),
            role: request('role'),
        ));
    }

    public function store(StoreUserAction $storeUserAction): JsonResponse
    {
        $storeUserAction->execute(request()->all());

        return response()->json();
    }

    public function update(User $user, UpdateUserAction $updateUserAction): JsonResponse
    {
        $updateUserAction->execute($user, request()->all());

        return response()->json();
    }
}
