<?php

// use App\Http\Controllers\CategoriesController;

/*
Route::get('/categories', 'App\Http\Controllers\CategoriesController@index');
Route::get('/categories/create', 'App\Http\Controllers\CategoriesController@create');
Route::post('/categories', 'App\Http\Controllers\CategoriesController@store');
Route::get('/categories/{category}', 'App\Http\Controllers\CategoriesController@show');
Route::get('/categories/{category}/edit', 'App\Http\Controllers\CategoriesController@edit');
Route::put('/categories/{category}', 'App\Http\Controllers\CategoriesController@update');
Route::delete('/categories/{category}', 'App\Http\Controllers\CategoriesController@destroy');
*/

/*
Route::get('/', function(){
    return view('home');
}) -> name('home');

Route::get('categories', function(){
    return view('categories.index');
}) -> name('categories.index');

Route::get('categories/create', function(){
    return view('categories.create');
}) -> name('categories.create');
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductsController;

Route::get('/', function () {
    return view('home');
}) -> name('home');

Route::get('auth/register', [RegisterController::class, 'index']) -> name('auth.register.index');
Route::post('/auth_store', [RegisterController::class, 'auth_store']) -> name('auth.register.auth_store');
Route::post('/email_check', [RegisterController::class, 'email_check']) -> name('auth.register.email_check');

Route::get('auth/login', [LoginController::class, 'index']) -> name('login');
Route::post('/login_attempt', [LoginController::class, 'login']) -> name('auth.login.attempt');
Route::post('auth/logout', [LoginController::class, 'logout']) -> name('auth.logout');

Route::middleware('auth') -> prefix('categories') -> group(function(){ // Prefix 쓴 것 기억할 것!
    Route::get('/', [CategoriesController::class, 'index']) -> name('categories.index');
    Route::get('create', [CategoriesController::class, 'create']) -> name('categories.create');
    // Route::post('/', [CategoriesController::class, 'store']) -> name('categories.store');
    Route::get('{category}', [CategoriesController::class, 'show']) -> name('categories.show');
    Route::get('{category}/edit', [CategoriesController::class, 'edit']) -> name('categories.edit');
    Route::post('{category}/update', [CategoriesController::class, 'update']) -> name('categories.update');
    Route::delete('{category}/delete', [CategoriesController::class, 'destroy']) -> name('categories.delete');
    Route::get('/{category}/usable_status', [CategoriesController::class, 'usable_status']) -> name('categories.usable_status');

    Route::post('/store', [CategoriesController::class, 'store']) -> name('categories.store');
    Route::post('/not_usable', [CategoriesController::class, 'not_usable']) -> name('categories.not_usable');
    Route::post('/is_usable', [CategoriesController::class, 'is_usable']) -> name('categories.is_usable');
});

Route::middleware('auth') -> prefix('brands') -> group(function(){
    Route::get('/', [BrandsController::class, 'index']) -> name('brands.index');
    Route::get('create', [BrandsController::class, 'create']) -> name('brands.create');
    Route::get('{brand}/edit', [BrandsController::class, 'edit']) -> name('brands.edit');
    Route::post('/store', [BrandsController::class, 'store']) -> name('brands.store');
    Route::post('{brand}/update', [BrandsController::class, 'update']) -> name('brands.update');
    Route::delete('{brand}/delete', [BrandsController::class, 'destroy']) -> name('brands.delete');
});

Route::middleware('auth') -> prefix('products') -> group(function(){
    Route::get('/', [ProductsController::class, 'index']) -> name('products.index');
    Route::get('create', [ProductsController::class, 'create']) -> name('products.create');
    Route::get('{product}/edit', [ProductsController::class, 'edit']) -> name('products.edit');
    Route::post('{product}/update', [ProductsController::class, 'update']) -> name('products.update');
    Route::post('add', [ProductsController::class, 'add']) -> name('products.add');
    Route::post('store', [ProductsController::class, 'store']) -> name('products.store');
    Route::get('{product}/status', [ProductsController::class, 'status']) -> name('products.status');
    Route::delete('{product}/delete', [ProductsController::class, 'destroy']) -> name('products.delete');
});

/*
Route::get('categories', [CategoriesController::class, 'index']) -> name('categories.index');
Route::get('categories/create', [CategoriesController::class, 'create']) -> name('categories.create');
Route::post('categories', [CategoriesController::class, 'store']) -> name('categories.store');
Route::get('categories/{category}', [CategoriesController::class, 'show']) -> name('categories.show');
Route::get('categories/{category}/edit', [CategoriesController::class, 'edit']) -> name('categories.edit');
Route::put('categories/{category}', [CategoriesController::class, 'update']) -> name('categories.update');
Route::delete('categories/{category}', [CategoriesController::class, 'destroy']) -> name('categories.delete');

Route::post('auth/register', [RegisterController::class, 'store']) -> name('auth.register.store');s
*/