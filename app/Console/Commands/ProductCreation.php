<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\StoreProductRequest;
use App\Http\Controllers\ProductController;

class ProductCreation extends Command
{
    protected $signature = 'product:create {name} {description} {price} {--image=} {--parent_category=} {--subcategories=*}';
    protected $description = 'Create a new product from the command line';

    protected $productController;

    public function __construct(ProductController $productController)
    {
        parent::__construct();
        $this->productController = $productController;
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

        // Prepare data
        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
            'parent_category_id' => $parentCategoryId,
            'subcategory_id' => $subcategories, // Ensure this is correct in the request rules
        ];

        // Instantiate StoreProductRequest manually
        $request = StoreProductRequest::create('/', 'POST', $data);

        // Call the controller's store method to handle the creation
        $response = $this->productController->store($request);

        // Check if the product was successfully created
        if ($response->getStatusCode() === 302) { // 302 for redirect
            $this->info('Product created successfully!');
        } else {
            $this->error('Failed to create product.');
        }

        return 0;
    }
}
