<?php

use Domain\RolesAndPermissions\Models\Role;
use Domain\Users\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

test('can not list all users if user doesnt have permissions', function () {
    User::factory(10)->create();

    $user = actingAsSeller();

    $response = getJson('api/users?'.http_build_query([
        'per_page' => 5,
        'page' => 1,
    ]));

    $response->assertOk();

    $response->assertJsonCount(1, 'data');
    $response->assertJsonFragment(['id' => $user->getKey()]);
});

test('can list users', function () {
    User::factory(3)->create(['name' => 'first sample']);
    User::factory(7)->create(['name' => 'second sample']);

    actingAsAdmin();

    $response = getJson('api/users?'.http_build_query([
        'per_page' => 5,
        'page' => 1,
        'search' => 'irst',
    ]));

    $response->assertOk();

    $response->assertJsonCount(3, 'data');
});

test('can not create user if user does not have permissions', function () {
    $data = [
        'name' => 'example user',
        'email' => 'example@example.com',
        'roles' => [Role::first()],
    ];

    actingAsSeller();

    $response = postJson('api/users', $data);

    $response->assertForbidden();
});

test('can create user', function () {
    $data = [
        'name' => 'example user',
        'email' => 'example@example.com',
        'roles' => [Role::first()],
    ];

    actingAsAdmin();

    postJson('api/users', $data);

    assertDatabaseHas('users', [
        'name' => $data['name'],
        'email' => $data['email'],
    ]);

    $user = User::firstWhere('email', $data['email']);

    $this->assertTrue($user->hasRole($data['roles']));
});

test('send invitation to newly created user', function () {
    //
})->skip('todo: to be implemented');

test('can not update if user does not have permission', function () {
    $user = User::factory()->create();

    $user->assignRole($firstRole = Role::first());

    $role = Role::create(['name' => 'sample role']);

    $data = [
        'id' => $user->id,
        'name' => 'updated user',
        'email' => 'updated@example.com',
        'roles' => [['id' => $role->id, 'name' => $role->name]],
    ];

    actingAsSeller();

    $response = putJson('api/users/'.$user->id, $data);

    $response->assertForbidden();
});

test('can update user', function () {
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

    $response = putJson('api/users/'.$user->id, $data);

    $response->assertOk();

    assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => $data['name'],
        'email' => $data['email'],
    ]);

    assertTrue($user->fresh()->hasRole($data['roles']));
    assertFalse($user->fresh()->hasRole($firstRole));
});

test('can list users by role', function () {
    $user1 = User::factory()->create(['name' => 'seller']);
    $user2 = User::factory()->create(['name' => 'buyer']);

    $user1->assignRole(Role::findByName('SELLER'));
    $user2->assignRole(Role::findByName('BUYER'));

    actingAsAdmin();

    $response = getJson('api/users?'.http_build_query([
        'role' => 'SELLER',
    ]));

    $response->assertOk();
    $response->assertJsonCount(1);
    $response->assertJsonFragment(['id' => $user1->getKey()]);
});
