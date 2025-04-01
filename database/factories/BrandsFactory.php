<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brands;

class BrandsFactory extends Factory
{
    protected $model = Brands::class;

    public function definition(): array
    {
        $name = fake()->company();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'logo' => fake()->imageUrl(200, 200, 'brands', true),
        ];
    }
}