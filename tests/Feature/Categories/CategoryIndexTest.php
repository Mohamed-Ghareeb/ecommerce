<?php

namespace Tests\Feature\Categories;

use App\Models\Category;
use Tests\TestCase;

class CategoryIndexTest extends TestCase
{
    /** @test*/
    public function it_should_retuns_a_collection_of_categories()
    {
        $categories = factory(Category::class, 2)->create();

        $response = $this->json('GET', 'api/categories')->assertStatus(200);

        $categories->each(function($category) use($response) {
            $response->assertJsonFragment([
                'name' => $category->name
            ]);  
        });
    }

    /** @test*/
    public function it_should_retuns_a_parents_of_categories()
    {
        $category = factory(Category::class)->create();
        
        $category->children()->save(
            factory(Category::class)->create()
        );

        $this->json('GET', 'api/categories')->assertStatus(200)->assertJsonCount(1, 'data');
    }

    /** @test*/
    public function it_should_retuns_categories_by_order()
    {
        $category = factory(Category::class)->create([
            'order' => 1
        ]);
        
        $anotherCategory = factory(Category::class)->create([
            'order' => 2
        ]);

        $this->json('GET', 'api/categories')->assertStatus(200)->assertSeeInOrder([
            $category->name,
            $anotherCategory->name,
        ]);
    }
}
