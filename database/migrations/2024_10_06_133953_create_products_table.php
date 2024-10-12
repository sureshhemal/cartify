<?php

use App\Actions\CreatePermissionsAction;
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
        Schema::dropIfExists('products');
    }

    private function createTable(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('seller_id')->constrained('users');
            $table->foreignUuid('category_id')->constrained('categories');
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->string('image')->nullable();
            $table->integer('price');
            $table->string('currency');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    private function createPermissions(): void
    {
        $permissions = [
            'view-any-product' => ['SUPER_ADMIN', 'ADMIN', 'BUYER'],
            'view-own-product' => ['SUPER_ADMIN', 'ADMIN', 'SELLER'],
            'create-product' => ['SUPER_ADMIN', 'ADMIN', 'SELLER'],
            'update-product' => ['SUPER_ADMIN', 'SELLER', 'ADMIN'],
            'delete-product' => ['SUPER_ADMIN', 'ADMIN', 'SELLER'],
            'restore-product' => ['SUPER_ADMIN', 'ADMIN'],
            'force-delete-product' => ['SUPER_ADMIN'],
        ];

        (new CreatePermissionsAction)->execute(collect($permissions));
    }
};
