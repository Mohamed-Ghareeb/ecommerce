<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class ProductScopingTest extends TestCase
{
    /** @test*/
    public function it_can_scope_by_category()
    {
        $product = factory(Product::class)->create();

        $product->categories()->save(
            $category = factory(Category::class)->create()
        );

        $this->json('GET', "api/products?category={$category->slug}")->assertStatus(200)->assertJsonCount(1, 'data');
    }
}
