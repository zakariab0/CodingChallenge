<?php

namespace App\Http\Controllers;

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

        $data = $request->only(['name', 'description', 'price', 'image', 'parent_category', 'subcategories']);
        $this->productRepository->createProduct($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }
}
