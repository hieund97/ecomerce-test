<?php

use App\Http\Controllers\admin\BlogsController;
use App\Http\Controllers\admin\CategoriesController;
use App\Http\Controllers\admin\UsersController;
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

Route::group([
    'prefix' => env('ADMIN_URL', 'admin'),
    'namespace' => 'App\Http\Controllers\admin'
], function(){
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/products', 'DashboardController@products')->name('products');  
    Route::get('/categories', 'DashboardController@categories')->name('categories');
    Route::get('/blogs', 'DashboardController@blogs')->name('blogs');
    // Route users
    Route::group([
        'prefix' => 'users'
    ], function(){
        Route::get('/', 'UsersController@index')->name('list.users');
        Route::get('/create', 'UsersController@create')->name('create.users');
        Route::post('/store', 'UsersController@store')->name('store.users');
        Route::get('/edit/{id}', 'UsersController@edit')->name('edit.users');
        Route::put('/update/{id}', 'UsersController@update')->name('update.users');
        Route::delete('/delete/{id}', 'UsersController@destroy')->name('delete.users');
    });
    // Route blogs
    Route::group([
        'prefix' => 'blogs'
    ], function(){
        Route::get('/', 'BlogsController@index')->name('list.blogs');
        Route::get('/create', 'BlogsController@create')->name('create.blogs');
        Route::post('/store', 'BlogsController@store')->name('store.blogs');
        Route::get('/edit/{id}', 'BlogsController@edit')->name('edit.blogs');
        Route::put('/update/{id}', 'BlogsController@update')->name('update.blogs');
        Route::delete('/delete/{id}', 'BlogsController@destroy')->name('delete.blogs');
    });
    // Route categories
    Route::group([
        'prefix' => 'categories'
    ], function(){
        Route::get('/', 'CategoriesController@index')->name('list.categories');
        Route::get('/create', 'CategoriesController@create')->name('create.categories');
        Route::post('/store', 'CategoriesController@store')->name('store.categories');
        Route::get('/edit/{id}', 'CategoriesController@edit')->name('edit.categories');
        Route::put('/update/{id}', 'CategoriesController@update')->name('update.categories');
        Route::delete('/delete/{id}', 'CategoriesController@destroy')->name('delete.categories');
    });
});


