<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetUsersAction
{
    public function execute(int $perPage, int $page, ?string $search = null): LengthAwarePaginator
    {
        return User::with('roles')
            ->when($search, fn ($query, $search) => $query->search($search))
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
