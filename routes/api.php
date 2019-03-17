<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    
    Route::put('/usuario/{usuario}', 'Admin\UsersController@update')->name('usuario.update');
    
    Route::post('/upload', 'Admin\UsersController@upload')->name('usuario.upload');
    
    // Route::get('/getProducts', 'Admin\ProductsController@getProducts')->name('getProducts');
    Route::post('/productos', 'Admin\ProductsController@store')->name('productos.store');
    Route::put('/productos/{producto}', 'Admin\ProductsController@update')->name('productos.update');
    Route::delete('/productos/{producto}', 'Admin\ProductsController@destroy')->name('productos.destroy');
    
    // Route::get('/getSales', 'Admin\VentasController@getSales')->name('getSales');
    
    // Route::get('/getClients', 'Admin\ClientsController@getClients')->name('getClients');
    // Route::get('/getClientes', 'Admin\ClientsController@getClientes')->name('getClientes');
    
    Route::post('/clientes', 'Admin\ClientsController@store')->name('clientes.store');
    Route::put('/clientes/{cliente}', 'Admin\ClientsController@update')->name('clientes.update');
    Route::delete('/clientes/{cliente}', 'Admin\ClientsController@destroy')->name('clientes.destroy');


