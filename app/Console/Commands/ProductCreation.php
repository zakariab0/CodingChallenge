<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use App\Services\ProductService;

class ProductCreation extends Command
{
    protected $signature = 'product:create {name} {description} {price} {--image=} {--parent_category=} {--subcategories=*}';
    protected $description = 'Create a new product from the command line';

    protected $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle()
    {
        $data = [
            'name' => $this->argument('name'),
            'description' => $this->argument('description'),
            'price' => $this->argument('price'),
            'image' => $this->getImageFromFile($this->option('image')), // Handle the file upload
            'parent_category' => $this->option('parent_category'),
            'subcategories' => $this->option('subcategories'),
        ];

        $result = $this->productService->createProduct($data);

        if (isset($result['error'])) {
            $this->error($result['error']);
            return 1;
        }

        $this->info($result['success']);
        return 0;
    }

    private function getImageFromFile($imagePath)
    {
        if ($imagePath && file_exists($imagePath)) {
            $mimeType = mime_content_type($imagePath);
            return new UploadedFile($imagePath, basename($imagePath), $mimeType, null, true);
        }

        $this->error('Invalid image file');
        return null;
    }
    }
