<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function create_product()
    {

        $category = Category::factory()->create();

        $response = $this->post('/products', [
            'name' => 'Test Product1',
            'description' => 'This is a test product.',
            'price' => 123.12,
            'image' => null,
            'categories' => [$category->id]
        ]);


        $response->assertStatus(302);
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product1',
            'description' => 'This is a test product.',
            'price' => 123.12,
        ]);

        $product = Product::first();
        $this->assertTrue($product->categories->contains($category));
    }
}
