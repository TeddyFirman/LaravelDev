<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/categories', 'CategoryController@index')->name('categories.index');
Route::get('/categories/search', 'CategoryController@search')->name('categories.search');
Route::get('/categories/paginate', 'CategoryController@paginate')->name('categories.paginate');
Route::post('/categories/store', 'CategoryController@store')->name('categories.store');
Route::get('/categories/create', 'CategoryController@create')->name('categories.create');

// Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
Route::put('/categories/update/{category}', 'CategoryController@update')->name('categories.update');
Route::get('/categories/edit/{category}', 'CategoryController@edit')->name('categories.edit');

Route::delete('/categories/{category}', 'CategoryController@destroy')->name('categories.destroy');
