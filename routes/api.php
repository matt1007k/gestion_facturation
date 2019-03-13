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

Route::get('/getUserAuth', 'Admin\UsersController@getUserAuth')->name('getUserAuth')->middleware('auth:api');

Route::get('/getProducts', 'Admin\ProductsController@getProducts')->name('getProducts');
Route::post('/productos', 'Admin\ProductsController@store')->name('productos.store');
Route::put('/productos/{producto}', 'Admin\ProductsController@update')->name('productos.update');
Route::delete('/productos/{producto}', 'Admin\ProductsController@destroy')->name('productos.destroy');

Route::get('/getSales', 'Admin\VentasController@getSales')->name('getSales');

Route::get('/getClients', 'Admin\ClientsController@getClients')->name('getClients');
Route::post('/clientes', 'Admin\ClientsController@store')->name('clientes.store');
Route::put('/clientes/{cliente}', 'Admin\ClientsController@update')->name('clientes.update');
Route::delete('/clientes/{cliente}', 'Admin\ClientsController@destroy')->name('clientes.destroy');
