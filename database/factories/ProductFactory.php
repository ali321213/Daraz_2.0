<?php

namespace Database\Factories;

use App\Models\Brands;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->word();
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 49.99, 999.99),
            'unit_id' => Unit::query()->inRandomOrder()->value('id') ?? Unit::factory()->create()->id,
            'brand_id' => Brands::query()->inRandomOrder()->value('id') ?? Brands::factory()->create()->id,
            'category_id' => Category::query()->inRandomOrder()->value('id') ?? Category::factory()->create()->id,
            'stock' => fake()->numberBetween(0, 100),
        ];
    }
}