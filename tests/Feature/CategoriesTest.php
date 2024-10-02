<?php

use Domain\Categories\Models\Category;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

dataset('all user roles', ['SUPER_ADMIN', 'ADMIN', 'BUYER', 'SELLER']);

test('anyone can list categories', function ($role) {
    Category::factory(2)->create(['name' => 'test']);
    Category::factory(8)->create(['name' => 'next']);

    actingAsRole($role);

    $response = getJson('api/categories?'.http_build_query([
        'search' => 'test',
    ]));

    $response->assertOk();

    $response->assertJsonCount(2);
})->with('all user roles');

test('can update categories if user has permission', function ($role) {
    $category = Category::factory()->create();

    actingAsRole($role);

    $response = $this->putJson('api/categories/'.$category->id, [
        'name' => 'test',
        'code' => 'code',
    ]);

    $response->assertOk();

    assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'test',
        'code' => 'code',
    ]);
})->with(['SUPER_ADMIN', 'ADMIN']);

test('can not update categories if user does\'nt have permissions', function ($role) {
    $category = Category::factory()->create();

    actingAsRole($role);

    $response = $this->putJson('api/categories/'.$category->id, [
        'name' => 'test',
        'code' => 'code',
    ]);

    $response->assertForbidden();
})->with(['SELLER', 'BUYER']);

test('can create categories if user has permission', function ($role) {
    actingAsRole($role);

    $response = postJson('api/categories', [
        'name' => 'test',
        'code' => 'code',
    ]);

    $response->assertOk();

    assertDatabaseHas('categories', [
        'name' => 'test',
        'code' => 'code',
    ]);
})->with(['SUPER_ADMIN', 'ADMIN']);

test('can not create categories if user does not have permissions', function ($role) {
    actingAsRole($role);

    $response = postJson('api/categories', [
        'name' => 'test',
        'code' => 'code',
    ]);

    $response->assertForbidden();

    assertDatabaseCount('categories', 0);
})->with(['SELLER', 'BUYER']);
