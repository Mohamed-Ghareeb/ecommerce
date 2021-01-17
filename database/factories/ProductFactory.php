<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Product;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'        => $name =  $faker->unique()->name,
        'slug'        => Str::slug($name),
        'price'       => $faker->randomNumber(4),
        'description' => $faker->sentence(5),
    ];
});
