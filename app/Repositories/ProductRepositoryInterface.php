<?php

namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function getAllProducts(array $filters);
    public function createProduct(array $data);
}
