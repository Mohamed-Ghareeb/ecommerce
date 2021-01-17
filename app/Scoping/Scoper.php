<?php

namespace App\Scoping;

use App\Scoping\Contracts\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

Class Scoper 
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;    
    }

    public function apply(Builder $builder, array $scopes)
    {
        foreach ($scopes as $key => $scope ) {
            if (!$scope instanceof Scope) {
                continue;
            }

            $scope->apply($builder, $this->request->get($key));
        }

        return $builder;
    }
}