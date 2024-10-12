<?php

namespace App\Actions;

use Domain\RolesAndPermissions\Models\Permission;
use Illuminate\Support\Collection;

class CreatePermissionsAction
{
    /**
     * Assign roles to the corresponding permissions.
     *
     * This method creates a permission for each key in the given collection and assigns the specified roles to that permission.
     *
     * @param  Collection  $permissions  A collection of permissions where the key is the permission name and the value is an array of roles.
     *
     * Example input:
     * ```
     * $permissions = collect([
     *     'permission-name-1' => ['User type 1', 'User type 2'],
     *     'permission-name-2' => ['User type 1', 'User type 2'],
     * ]);
     * ```
     * @return Collection The updated collection after assigning roles to each permission.
     */
    public function execute(Collection $permissions): Collection
    {
        return $permissions->map(function (array $roles, string $permission) {
            Permission::create(['name' => $permission])->assignRole($roles);
        });
    }
}
