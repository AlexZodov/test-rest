<?php

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

Route::group(['prefix' => 'test-api', 'as' => 'api::', 'middleware'=>'web'], function () {

    Route::resource('author', 'AuthorController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy'],
        'names' => [
            'index' => 'author::index',
            'show' => 'author::show',
            'store' => 'author::store',
            'update' => 'author::update',
            'destroy' => 'author::delete'
        ]
    ]);

    Route::resource('category', 'CategoryController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy'],
        'names' => [
            'index' => 'category::index',
            'show' => 'category::show',
            'store' => 'category::create',
            'update' => 'category::update',
            'destroy' => 'category::delete'
        ]
    ]);

    Route::resource('book', 'BookController', [
        'only' => ['index', 'store', 'show', 'update', 'destroy'],
        'names' => [
            'index' => 'book::index',
            'show' => 'book::show',
            'store' => 'book::create',
            'update' => 'book::update',
            'destroy' => 'book::delete'
        ]
    ]);


});
