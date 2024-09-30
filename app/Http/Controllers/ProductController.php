<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;
    protected $productService;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productService = $productService;

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
        $validatedData = $request->validated();
        $result = $this->productService->createProduct($validatedData);

        if (isset($result['error'])) {
            return redirect()->back()->withErrors($result['error']);
        }

        return redirect()->route('products.index')->with('success', $result['success']);
    }
}
