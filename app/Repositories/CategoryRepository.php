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
}
