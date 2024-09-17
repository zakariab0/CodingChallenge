<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['parent_category_id', 'subcategory_id', 'price_min', 'price_max']);
        $products = $this->productRepository->getAllProducts($filters);
        $categories = $this->categoryRepository->getAllCategories();
        $parentCategories = $this->categoryRepository->getParentCategories();
        $subCategories = $this->categoryRepository->getSubCategories();

        return view('products.index', compact('products', 'categories', 'parentCategories', 'subCategories'));
    }

    public function create()
    {
        $parentCategories = $this->categoryRepository->getParentCategories();
        $subCategories = $this->categoryRepository->getSubCategories();

        return view('products.create', compact('parentCategories', 'subCategories'));
    }

    public function store(StoreProductRequest $request)
    {
        //validate
        $validatedData = $request->validated();

        //save the image in images/public then store the product
        $validatedData['image'] = $this->setImageAttribute($validatedData['image']);
        $product = $this->productRepository->createProduct($validatedData);

        //attach categories and sub categories
        $this->categoryRepository->attachCategoriesToProduct($product, $validatedData);
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    private function setImageAttribute($value)
    {
        if (is_file($value))
            return $value->store('images', 'public');
    }

}
