<?php

namespace Database\Seeders;

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
        $users = $this->makeUsersWithRoles();
    }

    private function makeUsersWithRoles(): Collection
    {
        \Laravel\Prompts\info('Making 30 users and assigning roles...');

        $users = User::factory(30)->create();

        $roles = Role::all();

        $users->each(function ($user) use ($roles) {
            $user->assignRole($roles->random());
        });

        return $users;
    }
}
