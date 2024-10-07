<?php

namespace Database\Factories;

use Domain\Products\Models\Product;
use Domain\Support\Media\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->image,
            'type' => $this->faker->mimeType(),
            'mediaable_id' => fn () => Product::factory(),
            'mediaable_type' => fn () => Product::class,
        ];
    }
}
