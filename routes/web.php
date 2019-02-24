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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('productos', 'Admin\ProductsController');
Route::get('/getProducts', 'Admin\ProductsController@getProducts')->name('getProducts');

Route::get('/facturas', 'Admin\FacturationController@index')->name('facturas');

Route::get('/generar', 'Admin\FacturationController@generar')->name('generar');
Route::post('/agregar-producto', 'Admin\FacturationController@agregarProducto')->name('agregar.producto');