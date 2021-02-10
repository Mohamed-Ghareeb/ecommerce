<?php

namespace Tests\Unit\Models\Product;

use App\Cart\Money;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\ProductVariationType;
use Illuminate\Database\Eloquent\Collection;

class ProductVariationTest extends TestCase
{
    /** @test*/
    public function it_should_has_one_variation_type()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(ProductVariationType::class, $variation->type);
    }

    /** @test*/
    public function it_should_belongs_to_product()
    {
        $variation = factory(ProductVariation::class)->create();

        $this->assertInstanceOf(Product::class, $variation->product);
    }

    /** @test*/
    public function it_should_returns_a_money_instance_for_the_product_variation_price()
    {
        $productVariation = factory(ProductVariation::class)->create(); 

        $this->assertInstanceOf(Money::class, $productVariation->price);
    }

    /** @test*/
    public function it_should_returns_a_formatted_price_for_the_product_variation()
    {
        $productVariation = factory(ProductVariation::class)->create([
            'price' => 1000
        ]); 

        $this->assertEquals($productVariation->formatted_price, 'EGP 10.00');
    }

    /** @test*/
    public function it_should_returns_the_product_price_if_the_variation_price_is_null()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]); 

        $productVariation = factory(ProductVariation::class)->create([
            'price'      => 0,
            'product_id' => $product->id
        ]); 

        $this->assertEquals($productVariation->price->amount(), $product->price->amount());
    }

    /** @test*/
    public function it_should_pass_if_the_variation_price_different_to_the_product()
    {
        $product = factory(Product::class)->create([
            'price' => 1000
        ]); 

        $productVariation = factory(ProductVariation::class)->create([
            'price'      => 500,
            'product_id' => $product->id
        ]); 

        $this->assertNotEquals($productVariation->price->amount(), $product->price->amount());

        // OR
        // $this->assertTrue($productVariation->priceVaries());
    }

    /** @test*/
    public function it_should_has_many_stocks()
    {
        $productVariation = factory(ProductVariation::class)->create(); 

        $productVariation->stocks()->save(
            factory(Stock::class)->make()    
        );

        $this->assertInstanceOf(Collection::class, $productVariation->stocks);
    }
}
