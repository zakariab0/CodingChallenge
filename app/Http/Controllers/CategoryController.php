<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getSubcategories(Request $request)
    {
        $parentId = $request->input('parent_id');
        $subcategories = Category::where('parent_id', $parentId)->get();

        return response()->json(['subcategories' => $subcategories]);
    }
}
