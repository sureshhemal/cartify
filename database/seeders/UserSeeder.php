<?php

namespace Database\Seeders;

use Domain\RolesAndPermissions\Models\Role;
use Domain\Users\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(30)->create();

        $roles = Role::all();

        $users->each(function ($user) use ($roles) {
            $user->assignRole($roles->random());
        });
    }
}
