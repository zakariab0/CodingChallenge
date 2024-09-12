<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //many to many
    public function products()
{
    return $this->belongsToMany(Product::class, 'category_product');
}

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

}
