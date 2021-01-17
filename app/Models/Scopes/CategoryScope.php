<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait CategoryScope {
    
    public function scopeParents(Builder $builder)
    {
        return $builder->whereNull('parent_id');
    }

    public function scopeOrdered(Builder $builder, $direction = 'asc')
    {
        return $builder->orderBy('order', $direction);
    }
}