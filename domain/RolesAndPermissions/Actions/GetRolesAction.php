<?php

namespace Domain\RolesAndPermissions\Actions;

use Domain\RolesAndPermissions\Models\Role;
use Illuminate\Support\Collection;

class GetRolesAction
{
    public function execute(): Collection
    {
        return Role::query()->where('name', '!=', 'SUPER_ADMIN')->get();
    }
}
