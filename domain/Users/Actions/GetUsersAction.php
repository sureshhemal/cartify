<?php

namespace Domain\Users\Actions;

use Domain\Users\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetUsersAction
{
    public function execute(int $perPage, int $page, ?string $search = null): LengthAwarePaginator
    {
        return User::with('roles')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    collect(User::SEARCHABLE_FIELDS)
                        ->each(fn ($field) => $query->orWhere($field, 'LIKE', "%{$search}%"));
                });
            })
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
