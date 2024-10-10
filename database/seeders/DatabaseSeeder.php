<?php

namespace Database\Seeders;

use Domain\Categories\Models\Category;
use Domain\Products\Models\Product;
use Domain\RolesAndPermissions\Models\Role;
use Domain\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = $this->createUsers();

        $categories = $this->createCategories();

        $products = $this->createProducts($categories->random(20), $users);
    }

    protected function createUsers(): Collection
    {
        $seller = User::factory()->create([
            'email' => 'seller@cartify.com',
            'name' => 'Seller',
        ]);

        $seller->assignRole(Role::findByName('SELLER'));

        $users = User::factory(30)->create();

        $roles = Role::all();

        $users->each(function ($user) use ($roles) {
            $user->assignRole($roles->random());
        });

        return $users->push($seller);
    }

    protected function createCategories(): Collection
    {
        return Category::factory(40)->create();
    }

    private function createProducts(Collection $categories, Collection $users): Collection
    {
        $users = $users->filter->hasRole('SELLER');

        return $categories->flatMap(function (Category $category) use ($users) {
            return Product::factory(3)
                ->for($users->random(), 'seller')
                ->for($category)
                ->create();
        });
    }
}
