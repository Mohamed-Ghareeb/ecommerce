<?php

use Illuminate\Support\Facades\Route;

Route::resource('categories', 'Category\CategoryController');
Route::resource('products', 'Product\ProductController');