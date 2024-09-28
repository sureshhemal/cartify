<?php

use Domain\RolesAndPermissions\Models\Role;
use Domain\Users\Models\User;

test('can list users', function () {
    User::factory(3)->create(['name' => 'first sample']);
    User::factory(7)->create(['name' => 'second sample']);

    actingAsAdmin();

    $response = $this->getJson('api/users?'.http_build_query([
        'per_page' => 5,
        'page' => 1,
        'search' => 'irst',
    ]));

    $response->assertOk();

    $response->assertJsonCount(3, 'data');
});

test('can create user', function () {
    $data = [
        'name' => 'example user',
        'email' => 'example@example.com',
        'roles' => [Role::first()],
    ];

    actingAsAdmin();

    $this->postJson('api/users', $data);

    $this->assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);

    $user = User::firstWhere('email', $data['email']);

    $this->assertTrue($user->hasRole($data['roles']));
});

test('send invitation to newly created user', function () {
    //
})->skip('to be implemented');

test('can update user', function () {
    /** @var User $user */
    $user = User::factory()->create();

    $user->assignRole($firstRole = Role::first());

    $role = Role::create(['name' => 'sample role']);

    $data = [
        'id' => $user->id,
        'name' => 'updated user',
        'email' => 'updated@example.com',
        'roles' => [['id' => $role->id, 'name' => $role->name]],
    ];

    actingAsAdmin();

    $response = $this->putJson('api/users/'.$user->id, $data);

    $response->assertOk();

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $data['name'],
        'email' => $data['email'],
    ]);

    $this->assertTrue($user->fresh()->hasRole($data['roles']));
    $this->assertFalse($user->fresh()->hasRole($firstRole));
});
