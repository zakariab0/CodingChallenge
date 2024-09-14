<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class ListSubcategories extends Command
{
    protected $signature = 'category:list-subs {parentId : The ID of the parent category}';
    protected $description = 'List all subcategories of a given parent category';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $parentId = $this->argument('parentId');

        $subcategories = Category::where('parent_id', $parentId)->get();

        if ($subcategories->isEmpty()) {
            $this->info('No subcategories found for the given parent category.');
            return 0;
        }

        $this->info('Subcategories:');
        $this->table(['ID', 'Name'], $subcategories->map(function ($subcategory) {
            return [$subcategory->id, $subcategory->name];
        }));

        return 0;
    }
}
