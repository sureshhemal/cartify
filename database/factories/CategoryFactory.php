<?php

namespace Database\Factories;

use Domain\Categories\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->words(3, true),
        ];
    }
}
