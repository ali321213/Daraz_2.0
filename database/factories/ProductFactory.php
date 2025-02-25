<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'price' => fake()->randomFloat(2, 10, 500),
            'img' => fake()->imageUrl(200, 200, 'products', true),
            'brand' => fake()->company(),
            'unit' => fake()->randomElement(['kg', 'pcs', 'liters', 'packs']),
            'category' => fake()->randomElement(['Electronics', 'Clothing', 'Food', 'Accessories']),
        ];
    }
}