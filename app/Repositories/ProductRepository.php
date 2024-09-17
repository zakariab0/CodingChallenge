<?php
namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(array $filters)
    {
        $query = Product::query();

        if (isset($filters['parent_category_id']) || isset($filters['subcategory_id']))
            $query = app(CategoryRepository::class)
                ->filterByCategory($query,
                [$filters['subcategory_id'], $filters['parent_category_id']]);

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
        $product->fill($data);
        $product->setImageAttribute($data['image']);
        $product->save();

        return $product;
    }
}
