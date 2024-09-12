<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Filter by Parent Category and Subcategory
        if ($request->filled('parent_category_id') && $request->filled('subcategory_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->subcategory_id)
                  ->where('categories.parent_id', $request->parent_category_id);
            });
        }
        // Filter only by Parent Category
        else if ($request->filled('parent_category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.parent_id', $request->parent_category_id);
            });
        }
        // Filter only by Subcategory
        else if ($request->filled('subcategory_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->subcategory_id);
            });
        }

        // Filter by Minimum Price
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        // Filter by Maximum Price
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $products = $query->get();
        $categories = Category::all();
        $parentCategories = $categories->whereNull('parent_id'); // get parent categories
        $subCategories = $categories->whereNotNull('parent_id'); // get subcategories

        return view('products.index', compact('products', 'categories', 'parentCategories', 'subCategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $parentCategories = $categories->whereNull('parent_id');
        $subCategories = $categories->whereNotNull('parent_id');

        return view('products.create', compact('parentCategories', 'subCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image:jpeg,png,jpg|max:2048',
            'parent_category' => 'nullable|exists:categories,id',
            'subcategories' => 'nullable|array',
            'subcategories.*' => 'exists:categories,id',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->setImageAttribute($request->image);


        $product->save();

        if ($request->filled('parent_category')) {
            $product->categories()->attach($request->parent_category);
        }

        if ($request->filled('subcategories')) {
            $product->categories()->attach($request->subcategories);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }


}
