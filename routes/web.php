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

    Route::resource('documentos', 'Admin\VentasController');
    Route::post('/generar', 'Admin\VentasController@generar')->name('generar');   


    Route::get('/comprobante/{num_comprobante}', 'Admin\VentasController@pdf')->name('pdf');
    Route::get('/descargar/{num_comprobante}', 'Admin\VentasController@descargar')->name('descargar');
    // Route::get('/boletas/{num_comprobante}', 'Admin\VentasController@pdf')->name('boletas');
});

