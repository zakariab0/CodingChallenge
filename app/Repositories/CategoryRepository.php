<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return Category::all();
    }

    public function getParentCategories()
    {
        return Category::whereNull('parent_id')->get();
    }

    public function getSubCategories()
    {
        return Category::whereNotNull('parent_id')->get();
    }

    public function getSubcategoriesByParentId($parentId)
    {
        return Category::where('parent_id', $parentId)->get();
    }

    public function attachCategoriesToProduct($product, array $categories)
    {
        if (isset($categories['parent_category'])) {
            $product->categories()->attach($categories['parent_category']);
        }

        if (isset($categories['subcategories'])) {
            $product->categories()->attach($categories['subcategories']);
        }
    }

    public function filterByCategory($query, array $filters)
    {
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

        return $query;
    }
}
