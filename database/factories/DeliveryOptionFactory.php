<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DeliveryOption;
use App\Models\Products;

class DeliveryOptionFactory extends Factory
{
    protected $model = DeliveryOption::class;

    public function definition(): array
    {
        return [
            'product_id' => Products::inRandomOrder()->first()->id ?? Products::factory(),
            'option_name' => fake()->randomElement(['Standard Shipping', 'Express Delivery', 'Same Day Delivery']),
            'price' => fake()->randomFloat(2, 50, 500),
        ];
    }
}