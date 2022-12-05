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

Route::group([
    'prefix' => env('ADMIN_URL', 'admin'),
    'namespace' => 'App\Http\Controllers\admin'
], function(){
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::get('/products', 'DashboardController@products')->name('products');
    Route::get('/users', 'DashboardController@users')->name('users');
    Route::get('/categories', 'DashboardController@categories')->name('categories');
});


