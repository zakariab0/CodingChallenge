<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'image'];

    //function to store image
    public function setImageAttribute($value)
    {
        if (is_file($value)) {
            $this->attributes['image'] = $value->store('images', 'public');
        }
    }

    //many to many
    public function categories()
{
    return $this->belongsToMany(Category::class, 'category_product');
}

}
