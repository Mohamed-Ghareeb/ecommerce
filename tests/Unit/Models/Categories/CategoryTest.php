<?php

namespace Tests\Unit\Models\Categories;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\RelationTraits\RelationOfCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryTest extends TestCase
{
    /** @test*/
    public function it_should_has_many_children()
    {
        $category = factory(Category::class)->create(); 

        $category->children()->save(
            factory(Category::class)->create()    
        );

        $this->assertInstanceOf(Collection::class, $category->children);
    }

    /** @test*/
    public function it_can_fetch_only_parents()
    {
        $category = factory(Category::class)->create(); 

        $category->children()->save(
            factory(Category::class)->create()    
        );

        $this->assertEquals(1, Category::parents()->count());
    }

    /** @test*/
    public function it_is_orderable_by_a_number_of_order()
    {
        $category = factory(Category::class)->create([
            'order' => 1
        ]); 
        $anotherCategory = factory(Category::class)->create([
            'order' => 2
        ]); 

        $this->assertEquals($category->name, Category::ordered()->first()->name);
    }

    /** @test*/
    public function it_should_belongs_to_many_products()
    {
        $category = factory(Category::class)->create(); 

        $category->products()->save(
            factory(Product::class)->create()    
        );

        $this->assertInstanceOf(Collection::class, $category->products);
    }

}
