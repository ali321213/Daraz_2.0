<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Unit;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImage;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(10)->create();
        Unit::factory(5)->create();
        // First, create brands and categories
        Brand::factory(10)->create();
        Category::factory(10)->create();
        // Now create products, ensuring they have valid brands & categories
        Product::factory(10)->create()->each(function ($product) {
            // Generate 2-5 images per product
            ProductImage::factory(rand(2, 5))->create([
                'product_id' => $product->id,
            ]);
        });
    }
}