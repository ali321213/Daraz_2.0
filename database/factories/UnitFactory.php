<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Unit;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        $name = fake()->unique()->word();
        return [
            'name' => $name,
            'symbol' => $this->faker->randomElement(['kg', 'L', 'pcs', 'm', 'g']),
            'description' => $this->faker->sentence(),
        ];
    }
}
