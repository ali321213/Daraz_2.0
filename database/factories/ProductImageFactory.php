<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products;

class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Products::inRandomOrder()->first()?->id ?? Products::factory(),
            'image_path' => fake()->imageUrl(200, 200, 'products', true),
        ];
    }
}