<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(array $filters)
    {
        $query = Product::query();

        if (isset($filters['parent_category_id']) && isset($filters['subcategory_id'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['subcategory_id'])
                  ->where('categories.parent_id', $filters['parent_category_id']);
            });
        } elseif (isset($filters['parent_category_id'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.parent_id', $filters['parent_category_id']);
            });
        } elseif (isset($filters['subcategory_id'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['subcategory_id']);
            });
        }

        if (isset($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }

        if (isset($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }

        return $query->get();
    }

    public function createProduct(array $data)
    {
        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->setImageAttribute($data['image']);

        $product->save();

        if (isset($data['parent_category'])) {
            $product->categories()->attach($data['parent_category']);
        }

        if (isset($data['subcategories'])) {
            $product->categories()->attach($data['subcategories']);
        }

        return $product;
    }
}
