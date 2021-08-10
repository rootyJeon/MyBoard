<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ExampleController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('auth/register', [RegisterController::class, 'index'])->name('auth.register.index');
Route::post('/auth_store', [RegisterController::class, 'auth_store'])->name('auth.register.auth_store');
Route::post('/email_check', [RegisterController::class, 'email_check'])->name('auth.register.email_check');

Route::get('/auth/login', [LoginController::class, 'index'])->name('login');
Route::post('/login_attempt', [LoginController::class, 'login'])->name('auth.login.attempt');
Route::post('/auth/logout', [LoginController::class, 'logout'])->name('auth.logout');


// Route::middleware('auth')->group(function () {

    Route::prefix('example')->group(function(){
        Route::get('/', [ExampleController::class, 'index'])->name('example.index');
        Route::post('/store', [ExampleController::class, 'store'])->name('example.store');
    });

    Route::get('/auth/register', [RegisterController::class, 'index'])->name('auth.register.index');

    Route::prefix('brands')->group(function(){
        Route::get('/', [BrandsController::class, 'index'])->name('brands.index');
        Route::get('/create', [BrandsController::class, 'create'])->name('brands.create');
        Route::get('/edit/{brand}', [BrandsController::class, 'edit'])->name('brands.edit');
        Route::post('/store', [BrandsController::class, 'store'])->name('brands.store');
        Route::post('/update/{brand}', [BrandsController::class, 'update'])->name('brands.update');
        Route::delete('/delete/{brand}', [BrandsController::class, 'destroy'])->name('brands.delete');
    });

    Route::prefix('categories')->group(function(){
        Route::get('/', [CategoriesController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.create');
        Route::get('/{category}', [CategoriesController::class, 'show'])->name('categories.show');
        Route::get('/edit/{category}', [CategoriesController::class, 'edit'])->name('categories.edit');
        Route::post('/update/{category}', [CategoriesController::class, 'update'])->name('categories.update');
        Route::delete('/delete/{category}', [CategoriesController::class, 'destroy'])->name('categories.delete');
        Route::get('/usable_status/{category}', [CategoriesController::class, 'usable_status'])->name('categories.usable_status');
        Route::post('/store', [CategoriesController::class, 'store'])->name('categories.store');
        Route::post('/not_usable', [CategoriesController::class, 'not_usable'])->name('categories.not_usable');
        Route::post('/is_usable', [CategoriesController::class, 'is_usable'])->name('categories.is_usable');
    });

    Route::prefix('products')->group(function(){
        Route::get('/', [ProductsController::class, 'index'])->name('products.index');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.create');
        Route::post('/add', [ProductsController::class, 'add'])->name('products.add');
        Route::post('/store', [ProductsController::class, 'store'])->name('products.store');
        Route::post('/cat', [ProductsController::class, 'cat'])->name('products.cat');
    });

// });