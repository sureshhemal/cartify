<?php

use Domain\RolesAndPermissions\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->createTable();

        $this->createPermissions();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }

    protected function createTable(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->timestamps();
        });
    }

    protected function createPermissions(): void
    {
        $permissions = [
            'view-category' => ['SUPER_ADMIN', 'ADMIN', 'SELLER', 'BUYER'],
            'create-category' => ['SUPER_ADMIN', 'ADMIN'],
            'update-category' => ['SUPER_ADMIN', 'ADMIN'],
            'delete-category' => ['SUPER_ADMIN', 'ADMIN'],
            'restore-category' => ['SUPER_ADMIN', 'ADMIN'],
            'force-delete-category' => ['SUPER_ADMIN'],
        ];

        collect($permissions)
            ->map(function (array $roles, string $permission) {
                /** @var Permission $createdPermission */
                $createdPermission = Permission::create(['name' => $permission]);

                $createdPermission->assignRole($roles);
            });
    }
};
