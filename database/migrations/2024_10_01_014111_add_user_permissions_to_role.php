<?php

use Domain\RolesAndPermissions\Models\Permission;
use Domain\RolesAndPermissions\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            'view-any-user',
            'view-own-user',
            'create-user',
            'update-user',
            'delete-user',
            'restore-user',
            'force-delete-user',
        ];

        $permissions = collect($permissions)
            ->map(fn ($permission) => Permission::create(['name' => $permission]));

        $roles = Role::query()->whereIn('name', ['SUPER_ADMIN', 'ADMIN'])->get();

        $roles->each(fn (Role $role) => $role->givePermissionTo($permissions));
    }
};
