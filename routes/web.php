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
    return redirect('/login');
});

Auth::routes();


Route::middleware('auth')->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('productos', 'Admin\ProductsController');

    Route::resource('documentos', 'Admin\DocumentsController');
    Route::get('/generar', 'Admin\DocumentsController@generar')->name('generar');
    Route::post('/agregar-producto', 'Admin\DocumentsController@agregarProducto')->name('agregar.producto');
});

