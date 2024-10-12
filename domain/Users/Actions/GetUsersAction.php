<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

readonly class GetUsersAction
{
    public function execute(
        User $askingUser,
        ?int $perPage = null,
        ?int $page = null,
        ?string $search = null,
        ?string $role = null,
    ): LengthAwarePaginator|Collection {

        $userQuery = User::with('roles')
            ->when($askingUser->onlySeeHimself(), fn ($query) => $query->where('id', $askingUser->getKey()))
            ->when($role, fn ($query) => $query->role($role))
            ->when($search, fn ($query, $search) => $query->search($search));

        return $page ? $userQuery
            ->paginate($perPage, ['*'], 'page', $page)
            : $userQuery->get();
    }
}
