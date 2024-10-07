<?php

use Domain\RolesAndPermissions\Models\Role;
use Domain\Users\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $user = User::updateOrCreate([
            'email' => 'admin@cartify.com',
        ], [
            'name' => 'admin',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $role = Role::findByName('SUPER_ADMIN');

        $user->assignRole($role);
    }
};
