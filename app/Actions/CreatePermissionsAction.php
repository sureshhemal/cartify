<?php

namespace App\Actions;

use Domain\RolesAndPermissions\Models\Permission;
use Illuminate\Support\Collection;

class CreatePermissionsAction
{
    public function execute(Collection $permissions): Collection
    {
        return $permissions->map(function (array $roles, string $permission) {
            /** @var Permission $createdPermission */
            $createdPermission = Permission::create(['name' => $permission]);

            $createdPermission->assignRole($roles);
        });
    }
}
