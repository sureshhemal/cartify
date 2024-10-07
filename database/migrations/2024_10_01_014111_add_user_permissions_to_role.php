<?php

use App\Actions\CreatePermissionsAction;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = [
            'view-any-user' => ['SUPER_ADMIN', 'ADMIN'],
            'view-own-user' => ['SUPER_ADMIN', 'ADMIN', 'BUYER', 'SELLER'],
            'create-user' => ['SUPER_ADMIN', 'ADMIN'],
            'update-user' => ['SUPER_ADMIN', 'ADMIN'],
            'delete-user' => ['SUPER_ADMIN', 'ADMIN'],
            'restore-user' => ['SUPER_ADMIN', 'ADMIN'],
            'force-delete-user' => ['SUPER_ADMIN', 'ADMIN'],
        ];

        (new CreatePermissionsAction)->execute(collect($permissions));
    }
};
