<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
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

    if ($request->has('categories')) {
        $product->categories()->attach($request->categories);
    }

    return redirect()->route('products.index');
}

}
