<?php

namespace App\Models;

use App\Scoping\Scoper;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeWithScopes(Builder $builder, array $scopes)
    {   
        return (new Scoper(request()))->apply($builder, $scopes);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
