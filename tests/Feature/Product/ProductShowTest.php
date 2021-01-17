<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use Tests\TestCase;

class ProductShowTest extends TestCase
{
    /** @test*/
    public function it_should_fail_becaue_the_product_doesnot_exists()
    {
        $this->json('GET', 'api/products/every_thing')->assertStatus(404);
    }

    /** @test*/
    public function it_should_pass_and_shows_a_product()
    {
        $product = factory(Product::class)->create();
        $this->json('GET', "api/products/{$product->slug}")->assertStatus(200)->assertJsonFragment(['id' => $product->id]);
    }
}
