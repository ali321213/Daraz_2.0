<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Colors;

class ColorsFactory extends Factory
{
    protected $model = Colors::class;
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->colorName(),
            'hex_code' => fake()->unique()->hexColor(),
        ];
    }
}