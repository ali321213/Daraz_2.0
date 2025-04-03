<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ReturnWarranty;
use App\Models\Products;

class ReturnWarrantyFactory extends Factory
{
    protected $model = ReturnWarranty::class;
    public function definition(): array
    {
        return [
            'product_id' => Products::inRandomOrder()->first()->id ?? Products::factory(),
            'return_policy' => fake()->randomElement(['7 Days Return', '30 Days Return', 'No Return']),
            'warranty' => fake()->randomElement(['6 Months Warranty', '1 Year Warranty', 'No Warranty']),
        ];
    }
}