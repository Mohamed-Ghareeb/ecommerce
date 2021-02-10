<?php

namespace Tests\Unit\Models\Product;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariation;
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

    /** @test*/
    public function it_should_has_many_variations()
    {
        $product = factory(Product::class)->create(); 

        $product->variations()->save(
            factory(ProductVariation::class)->create()    
        );

        $this->assertInstanceOf(Collection::class, $product->variations);
    }

    /** @test*/
    public function it_should_returns_a_money_instance_for_the_product_price()
    {
        $product = factory(Product::class)->create(); 

        $this->assertInstanceOf(Money::class, $product->price);
    }

    /** @test*/
    public function it_should_returns_a_formatted_price_for_the_product()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]); 

        $this->assertEquals($product->formatted_price, 'EGP 10.00');
    }
}
