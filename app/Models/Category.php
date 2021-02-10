<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Scopes\CategoryScope;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use CategoryScope;
    
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'order',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }


}
