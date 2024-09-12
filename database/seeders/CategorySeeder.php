<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create some parent categories
        for ($i = 0; $i < 5; $i++) {
            $parentCategory = Category::create([
                'name' => $faker->word,
                'parent_id' => null
            ]);

            // Create some child categories
            for ($j = 0; $j < 3; $j++) {
                Category::create([
                    'name' => $faker->word,
                    'parent_id' => $parentCategory->id
                ]);
            }
        }
    }
}
