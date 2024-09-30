<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Repositories\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(array $data)
    {
        // Handle image upload if provided
        if (isset($data['image']) && is_file($data['image'])) {
            $data['image'] = $this->handleImageUpload($data['image']);
        }

        // Create the product using the repository
        $product = $this->productRepository->createProduct($data);

        if (isset($data['parent_category'])) {
            $product->categories()->attach($data['parent_category']);
        }

        // Attach subcategories if provided
        if (isset($data['subcategories']) && is_array($data['subcategories'])) {
            $product->categories()->attach($data['subcategories']);
        }

        return ['success' => 'Product created successfully!', 'product' => $product];
    }

    public function handleImageUpload($image)
    {
        return $image->store('images', 'public');  // Store image in 'public/images' directory
    }
}
