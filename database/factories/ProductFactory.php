<?php

namespace Database\Factories;

use Brick\Money\Money;
use Domain\Categories\Models\Category;
use Domain\Products\Models\Product;
use Domain\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'seller_id' => fn () => User::factory(),
            'category_id' => fn () => Category::factory(),
            'name' => $this->faker->words(3, true),
            'code' => $this->faker->word(),
            'description' => $this->faker->sentences(3, true),
            'quantity' => $this->faker->randomNumber(3),
            'price' => Money::ofMinor($this->faker->randomNumber(6), 'LKR'),
        ];
    }
}
