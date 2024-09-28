<?php

use Domain\RolesAndPermissions\Models\Role;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $roles = ['SUPER_ADMIN', 'ADMIN', 'BUYER', 'SELLER'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
};
