<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 500),
            'unit' => fake()->randomElement(['kg', 'pcs', 'liters', 'packs']),
            'brand_id' => Brand::inRandomOrder()->first()?->id ?? Brand::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}