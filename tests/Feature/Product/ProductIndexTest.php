<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    /** @test*/
    public function it_should_retuns_a_collection_of_products()
    {
        $products = factory(Product::class, 2)->create();

        $response = $this->json('GET', 'api/products')->assertStatus(200);

        $products->each(function($product) use($response) {
            $response->assertJsonFragment([
                'name' => $product->name
            ]);  
        });
    }

    /** @test*/
    public function it_should_retuns_a_paginated_data_of_products()
    {
        $this->json('GET', 'api/products')->assertStatus(200)->assertJsonStructure(['links']);
    }
}
