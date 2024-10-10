<?php

namespace Domain\Products\Actions;

use Domain\Products\Models\Product;
use Domain\Users\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GetProductsAction
{
    public function execute(
        User $user,
        int $perPage,
        int $page,
        ?string $search = null,
    ): LengthAwarePaginator {
        return Product::query()
            ->when($user->onlySeesOwnProducts(), fn ($query) => $query->whereBelongsTo($user, 'seller'))
            ->when($search, fn ($query, $search) => $query->search($search))
            ->paginate($perPage, ['*'], 'page', $page);
    }
}
