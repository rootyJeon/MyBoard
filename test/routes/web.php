<?php

// use App\Http\Controllers\BoardController;

/*
Route::get('/boards', 'App\Http\Controllers\BoardController@index');
Route::get('/boards/create', 'App\Http\Controllers\BoardController@create');
Route::post('/boards', 'App\Http\Controllers\BoardController@store');
Route::get('/boards/{board}', 'App\Http\Controllers\BoardController@show');
Route::get('/boards/{board}/edit', 'App\Http\Controllers\BoardController@edit');
Route::put('/boards/{board}', 'App\Http\Controllers\BoardController@update');
Route::delete('/boards/{board}', 'App\Http\Controllers\BoardController@destroy');
*/

/*
Route::get('/', function(){
    return view('home');
}) -> name('home');

Route::get('boards', function(){
    return view('boards.index');
}) -> name('boards.index');

Route::get('boards/create', function(){
    return view('boards.create');
}) -> name('boards.create');
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoardController;
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

Route::middleware('auth') -> prefix('boards') -> group(function(){ // Prefix 쓴 것 기억할 것!
Route::get('/', [BoardController::class, 'index']) -> name('boards.index');
Route::get('create', [BoardController::class, 'create']) -> name('boards.create');
// Route::post('/', [BoardController::class, 'store']) -> name('boards.store');
Route::get('{board}', [BoardController::class, 'show']) -> name('boards.show');
Route::get('{board}/edit', [BoardController::class, 'edit']) -> name('boards.edit');
Route::post('{board}/update', [BoardController::class, 'update']) -> name('boards.update');
Route::delete('{board}/delete', [BoardController::class, 'destroy']) -> name('boards.delete');
Route::get('/{board}/usable_status', [BoardController::class, 'usable_status']) -> name('boards.usable_status');

Route::post('/store', [BoardController::class, 'store']) -> name('boards.store');
Route::post('/not_usable', [BoardController::class, 'not_usable']) -> name('boards.not_usable');
Route::post('/is_usable', [BoardController::class, 'is_usable']) -> name('boards.is_usable');
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
});

/*
Route::get('boards', [BoardController::class, 'index']) -> name('boards.index');
Route::get('boards/create', [BoardController::class, 'create']) -> name('boards.create');
Route::post('boards', [BoardController::class, 'store']) -> name('boards.store');
Route::get('boards/{board}', [BoardController::class, 'show']) -> name('boards.show');
Route::get('boards/{board}/edit', [BoardController::class, 'edit']) -> name('boards.edit');
Route::put('boards/{board}', [BoardController::class, 'update']) -> name('boards.update');
Route::delete('boards/{board}', [BoardController::class, 'destroy']) -> name('boards.delete');

Route::post('auth/register', [RegisterController::class, 'store']) -> name('auth.register.store');s
*/