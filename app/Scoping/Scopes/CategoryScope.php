<?php

namespace App\Scoping\scopes;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;

class CategoryScope implements Scope
{
    public function apply(Builder $builder, $value)
    {
        return $builder->whereHas('categories', function(Builder $builder) use($value) {
            $builder->where('slug', $value);
        });
    }
}