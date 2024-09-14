<?php

namespace App\Services;

use App\Models\Product;


class ProductService
{
    public function createProduct($data)
    {
        $product = new Product();
        $product->name = $data['name'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->save();

        return $product;
    }
}
