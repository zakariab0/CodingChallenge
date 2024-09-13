<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;

class ListParentCategories extends Command
{
    protected $signature = 'category:list-parents';
    protected $description = 'List all parent categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $parentCategories = Category::whereNull('parent_id')->get();

        if ($parentCategories->isEmpty()) {
            $this->info('No parent categories found.');
            return 0;
        }

        $this->info('Parent Categories:');
        $this->table(['ID', 'Name'], $parentCategories->map(function ($category) {
            return [$category->id, $category->name];
        }));

        return 0;
    }
}
