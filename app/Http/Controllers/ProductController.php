<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->get(); // Eager load categories
        return view('products.index', compact('products'));
        }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'nullable|image:jpeg,png,jpg',
    ]);

    $product = new Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;

    if ($request->hasFile('image')) {
        $product->image = $request->file('image');
    }

    $product->save();

    if ($request->has('parent_category')) {
        $product->categories()->attach($request->parent_category);
    }

    if ($request->has('subcategories')) {
        $product->categories()->attach($request->subcategories);
    }

    return redirect()->route('products.index')->with('success', 'Product created successfully!');
}

    public function create()
    {
        $categories = Category::all();
        $parentCategories = $categories->whereNull('parent_id');
        $subCategories = $categories->whereNotNull('parent_id');

        return view('products.create', compact('parentCategories', 'subCategories'));
        }

}
