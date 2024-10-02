<?php

namespace Database\Seeders;

use Domain\Categories\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory(40)->create();
    }
}
