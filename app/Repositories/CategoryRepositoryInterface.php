<?php

namespace App\Repositories;

interface CategoryRepositoryInterface
{
    public function getAllCategories();
    public function getParentCategories();
    public function getSubCategories();
    public function getSubcategoriesByParentId($parentId);
}
