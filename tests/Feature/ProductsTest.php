<?php

use Domain\Categories\Models\Category;
use Domain\Products\Models\Product;
use Domain\RolesAndPermissions\Models\Role;
use Domain\Users\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertNotSoftDeleted;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;

test('can list all products non seller users', function ($role) {
    Product::factory()->count(5)->create();

    actingAsRole($role);

    $response = getJson('/api/products');

    $response->assertOk();

    $response->assertJsonCount(5, 'data');

})->with(['SUPER_ADMIN', 'ADMIN', 'BUYER']);

test('seller only see products which owns himself', function () {
    $products = Product::factory(4)->create();

    $seller = actingAsSeller();

    $ownProducts = Product::factory(2)->for($seller, 'seller')->create();

    $response = getJson('/api/products');

    $response->assertOk();

    $response->assertJsonCount($ownProducts->count(), 'data');
});

test('permitted user can create products', function ($role) {
    $seller = User::factory()->create();
    $seller->assignRole(Role::findByName('SELLER'));

    $category = Category::factory()->create();

    $data = [
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'name' => 'product',
        'code' => 'cd',
        'description' => 'product description',
        'quantity' => 100,
        'media' => [
            'added' => [],
            'removed' => [],
        ],
        'price' => [
            'amount' => 123000,
            'currency' => 'LKR',
        ],
    ];

    actingAsRole($role);

    $response = postJson('/api/products', $data);

    $response->assertOk();
    assertDatabaseHas('products', [
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'name' => 'product',
        'code' => 'cd',
        'description' => 'product description',
        'quantity' => 100,
        'price' => 123000 * 100,
        'currency' => 'LKR',
    ]);
})->with(['SUPER_ADMIN', 'ADMIN', 'SELLER']);

test('non permitted user can not create products', function ($role) {
    $seller = User::factory()->create();
    $seller->assignRole(Role::findByName('SELLER'));

    $category = Category::factory()->create();

    $data = [
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'name' => 'product',
        'code' => 'cd',
        'description' => 'product description',
        'quantity' => 100,
        'media' => [
            'added' => [],
            'removed' => [],
        ],
        'price' => [
            'amount' => 123000,
            'currency' => 'LKR',
        ],
    ];

    actingAsRole($role);

    $response = postJson('/api/products', $data);
    $response->assertForbidden();
})->with(['BUYER']);

test('ADMIN users can update any product', function ($role) {
    /** @var Product $product */
    $product = Product::factory()->create();

    $seller = User::factory()->create();
    $seller->assignRole(Role::findByName('SELLER'));

    $category = Category::factory()->create();

    $data = [
        'id' => $product->getKey(),
        'name' => 'product',
        'code' => 'code',
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'description' => 'product description',
        'quantity' => 100,
        'media' => [
            'added' => [],
            'removed' => [],
        ],
        'price' => [
            'amount' => 123000,
            'currency' => 'LKR',
        ],
    ];

    actingAsRole($role);

    $response = putJson('/api/products/'.$product->getKey(), $data);

    $response->assertOk();
    assertDatabaseHas('products', [
        'id' => $product->getKey(),
        'name' => 'product',
        'code' => 'code',
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'description' => 'product description',
        'quantity' => 100,
        'price' => 123000 * 100,
        'currency' => 'LKR',
    ]);
})->with(['SUPER_ADMIN', 'ADMIN']);

test('seller users can update their own product', function () {
    $seller = actingAsSeller();
    $category = Category::factory()->create();

    $product = Product::factory()
        ->for($seller, 'seller')
        ->for($category, 'category')
        ->create();

    $data = [
        'id' => $product->getKey(),
        'name' => 'product',
        'code' => 'code',
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'description' => 'product description',
        'quantity' => 100,
        'media' => [
            'added' => [],
            'removed' => [],
        ],
        'price' => [
            'amount' => 123000,
            'currency' => 'LKR',
        ],
    ];

    $response = putJson('/api/products/'.$product->getKey(), $data);

    $response->assertOk();
    assertDatabaseHas('products', [
        'id' => $product->getKey(),
        'name' => 'product',
        'code' => 'code',
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'description' => 'product description',
        'quantity' => 100,
        'price' => 123000 * 100,
        'currency' => 'LKR',
    ]);
});

test('seller users can not update products which owns by sellers', function () {
    $seller = User::factory()->create();
    $seller->assignRole(Role::findByName('SELLER'));

    /** @var Product $product */
    $product = Product::factory()->for($seller, 'seller')->create();

    $category = Category::factory()->create();

    $data = [
        'id' => $product->getKey(),
        'name' => 'product',
        'code' => 'code',
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'description' => 'product description',
        'quantity' => 100,
        'price' => 123000,
        'currency' => 'LKR',
    ];

    actingAsSeller();

    $response = putJson('/api/products/'.$product->getKey(), $data);

    $response->assertForbidden();
});

test('buyers users can not update any product', function () {
    $seller = User::factory()->create();
    $seller->assignRole(Role::findByName('SELLER'));

    /** @var Product $product */
    $product = Product::factory()->for($seller, 'seller')->create();

    $category = Category::factory()->create();

    $data = [
        'id' => $product->getKey(),
        'name' => 'product',
        'code' => 'code',
        'seller_id' => $seller->getKey(),
        'category_id' => $category->getKey(),
        'description' => 'product description',
        'quantity' => 100,
        'price' => 123000,
        'currency' => 'LKR',
    ];

    actingAsBuyer();

    $response = putJson('/api/products/'.$product->getKey(), $data);

    $response->assertForbidden();
});

test('ADMIN users can delete any product', function () {
    /** @var Product $product */
    $product = Product::factory()->create();

    $seller = User::factory()->create();
    $seller->assignRole(Role::findByName('SELLER'));

    actingAsAdmin();

    $response = deleteJson('/api/products/'.$product->getKey());

    $response->assertOk();
    assertSoftDeleted($product);
});

test('SELLER can delete their own products', function () {
    $seller = User::factory()->create();
    $seller->assignRole(Role::findByName('SELLER'));

    $product = Product::factory()->for($seller, 'seller')->create();

    actingAs($seller);

    $response = deleteJson('/api/products/'.$product->getKey());

    $response->assertOk();
    assertSoftDeleted($product);
});

test('SELLER can not delete other seller products', function () {
    /** @var Product $product */
    $product = Product::factory()->create();

    $seller = User::factory()->create();
    $seller->assignRole(Role::findByName('SELLER'));

    actingAs($seller);

    $response = deleteJson('/api/products/'.$product->getKey());

    $response->assertForbidden();
    assertNotSoftDeleted($product);
});

test('BUYER can not delete any product', function () {
    $product = Product::factory()->create();

    actingAsRole('BUYER');

    $response = deleteJson('/api/products/'.$product->getKey());

    $response->assertForbidden();
    assertNotSoftDeleted($product);
});
