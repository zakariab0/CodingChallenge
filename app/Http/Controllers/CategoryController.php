<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getSubcategories(Request $request)
    {
        $parentId = $request->input('parent_id');
        $subcategories = $this->categoryRepository->getSubcategoriesByParentId($parentId);

        return response()->json(['subcategories' => $subcategories]);
    }
}
