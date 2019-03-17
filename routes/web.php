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

    Route::get('/productos', 'Admin\ProductsController@index')->name('productos.index'); 
    Route::get('/getProducts', 'Admin\ProductsController@getProducts')->name('getProducts');  
    // Route::resource('productos', 'Admin\ProductsController');    

    Route::get('/documentos', 'Admin\VentasController@index')->name('documentos.index');
    Route::get('/documentos/create', 'Admin\VentasController@create')->name('documentos.create');
    Route::get('/getSales', 'Admin\VentasController@getSales')->name('getSales');


    Route::get('/clientes', 'Admin\ClientsController@index')->name('clientes.index');
    Route::get('/getClients', 'Admin\ClientsController@getClients')->name('getClients');
    Route::get('/getClientes', 'Admin\ClientsController@getClientes')->name('getClientes');

    Route::post('/generar', 'Admin\VentasController@generar')->name('generar');   

    Route::get('/comprobante/{num_comprobante}', 'Admin\VentasController@pdf')->name('pdf');
    Route::get('/descargar/{num_comprobante}', 'Admin\VentasController@descargar')->name('descargar');
    // Route::get('/boletas/{num_comprobante}', 'Admin\VentasController@pdf')->name('boletas');

    Route::get('/perfil', 'Admin\UsersController@perfil')->name('perfil');
});

