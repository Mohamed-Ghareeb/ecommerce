<?php

namespace Tests\Unit\Models\Product;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;


class ProductTest extends TestCase
{
    /** @test*/
    public function it_uses_the_slug_for_the_route_key_name()
    {
        $product = new Product();

        $this->assertEquals($product->getRouteKeyName(), 'slug');
    }

    /** @test*/
    public function it_should_has_many_categories()
    {
        $product = factory(Product::class)->create(); 

        $product->categories()->save(
            factory(Category::class)->create()    
        );

        $this->assertInstanceOf(Collection::class, $product->categories);
    }
}
