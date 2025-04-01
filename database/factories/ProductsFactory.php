<?php

namespace Database\Factories;

use App\Models\Brands;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10, 500),
            'unit_id' => Unit::query()->inRandomOrder()->first()?->id ?? Unit::factory(),
            'brand_id' => Brands::query()->inRandomOrder()->first()?->id ?? Brands::factory(),
            'category_id' => Category::query()->inRandomOrder()->first()?->id ?? Category::factory(),
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}