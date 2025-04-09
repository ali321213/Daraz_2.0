<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Discounts;
use App\Models\Product;

class DiscountsFactory extends Factory
{
    protected $model = Discounts::class;

    public function definition(): array
    {
        static $percentage = 10; // Start from 10%
        return [
            'discount_percentage' => $percentage += 10, // 10, 20, ..., 100
            'product_id' => Product::factory(), // Assign to a random product
            'start_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'end_date' => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }
}