<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class CategoryProductSeeder extends Seeder
{
    public function run()
    {
        $product = Product::find(3);
        $category = Category::find(6);

        $product->categories()->attach($category->id); // Add the relationship
    }
}
