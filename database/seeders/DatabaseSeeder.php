<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Unit;
use App\Models\Products;
use App\Models\Brands;
use App\Models\Category;
use App\Models\Colors;
use App\Models\DeliveryOption;
use App\Models\ProductImage;
use App\Models\ReturnWarranty;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();
        Unit::factory(5)->create();
        Colors::factory(10)->create();
        Brands::factory(10)->create();
        Category::factory(10)->create();
        Products::factory(10)->create()->each(function ($product) {
            ProductImage::factory(rand(2, 3))->create(['product_id' => $product->id]);
        });
        DeliveryOption::factory(10)->create();
        ReturnWarranty::factory(10)->create();
    }
}