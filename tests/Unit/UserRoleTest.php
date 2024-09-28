<?php

use Domain\RolesAndPermissions\Models\Permission;
use Domain\RolesAndPermissions\Models\Role;
use Domain\Users\Models\User;

test('can assign role to user', function () {
    $user = User::factory()->create();

    $role = Role::first();

    $user->assignRole($role);

    $this->assertTrue($user->hasRole($role));
});

test('can assign permission to role', function () {
    $role = Role::first();

    $permission = Permission::create(['name' => 'sample permission']);

    $role->givePermissionTo($permission);

    $this->assertTrue($role->hasPermissionTo($permission));
});

test('can assign permission to user', function () {
    $user = User::factory()->create();

    $permission = Permission::create(['name' => 'sample permission']);

    $user->givePermissionTo($permission);

    $this->assertTrue($user->hasPermissionTo($permission));
});

test('can check user has permission through role', function () {
    $role = Role::first();

    $permission = Permission::create(['name' => 'sample permission']);

    $role->givePermissionTo($permission);

    /** @var User $user */
    $user = User::factory()->create();

    $user->assignRole($role);

    $this->assertTrue($user->hasPermissionTo($permission));
});
