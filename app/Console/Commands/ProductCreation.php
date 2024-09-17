<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;

class ProductCreation extends Command
{
    protected $signature = 'product:create {name} {description} {price} {--image=} {--parent_category=} {--subcategories=*}';
    protected $description = 'Create a new product from the command line';

    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function handle()
{
    $name = $this->argument('name');
    $description = $this->argument('description');
    $price = $this->argument('price');
    $imagePath = $this->option('image');
    $parentCategoryId = $this->option('parent_category');
    $subcategories = $this->option('subcategories'); // This will be an array of IDs

    if ($imagePath && file_exists($imagePath)) {
        $mimeType = mime_content_type($imagePath);
        $image = new UploadedFile($imagePath, basename($imagePath), $mimeType, null, true);
    } else {
        $image = null;
        $this->error('Validation failed: failed to import image.');
        return 1;
    }

    // Validate inputs
    $data = [
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'image' => $image,
        'parent_category' => $parentCategoryId,
        'subcategories' => $subcategories,
    ];

    //instanciate storeproductreq manually
    $request = StoreProductRequest::create('/', 'POST', $data);

    //validate data
    $validator = Validator::make($data, $request->rules());

    if ($validator->fails()) {
        $this->error('Validation failed: ' . implode(', ', $validator->errors()->all()));
        return 1;
    }

    // Create Product
    $product = new Product();
    $product->name = $name;
    $product->description = $description;
    $product->price = $price;
    $product->setImageAttribute($image);
    $product->save(); // Save the product to generate an ID

    // Attach categories
    if ($parentCategoryId) {
        $product->categories()->attach($parentCategoryId);
    }
    if ($subcategories) {
        // Ensure that subcategories is an array
        $product->categories()->attach($subcategories);
    }

    $this->info('Product created successfully!');
    return 0;
}



}
