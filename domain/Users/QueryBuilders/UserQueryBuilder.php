<?php

namespace Domain\Users\QueryBuilders;

use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function search(string $search): static
    {
        return $this->where(function ($query) use ($search) {
            collect(User::SEARCHABLE_FIELDS)
                ->each(fn ($field) => $query->orWhere($field, 'LIKE', "%{$search}%"));
        });
    }
}
