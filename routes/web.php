<?php

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();


Route::middleware('auth')->group(function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/getCounts', 'HomeController@getCounts')->name('getCounts');
    Route::get('/getVentas', 'HomeController@getVentas')->name('getVentas');

    Route::get('/getCodes', 'HomeController@getCodes')->name('getCodes');

    Route::get('/productos', 'Admin\ProductsController@index')->name('productos.index'); 
    Route::get('/getProducts', 'Admin\ProductsController@getProducts')->name('getProducts');  
    // Route::resource('productos', 'Admin\ProductsController');    

    Route::get('/documentos', 'Admin\VentasController@index')->name('documentos.index');
    Route::get('/documentos/create', 'Admin\VentasController@create')->name('documentos.create');
    Route::get('/getSales', 'Admin\VentasController@getSales')->name('getSales');
    
    Route::get('/documentos/nota/{num_comprobante}', 'Admin\VentasController@createNota')->name('documentos.nota');
    Route::get('/getDetailsDocument/{num_comprobante}', 'Admin\VentasController@getDetailsDocument')->name('getDetailsDocument');

    Route::get('/clientes', 'Admin\ClientsController@index')->name('clientes.index');
    Route::get('/getClients', 'Admin\ClientsController@getClients')->name('getClients');
    Route::get('/getClientes/{tipo}', 'Admin\ClientsController@getClientes')->name('getClientes');

    Route::post('/generar', 'Admin\VentasController@generar')->name('generar');   

    Route::get('/comprobante/{num_comprobante}', 'Admin\VentasController@pdf')->name('pdf');
    Route::get('/descargar/{num_comprobante}', 'Admin\VentasController@descargar')->name('descargar');
    // Route::get('/boletas/{num_comprobante}', 'Admin\VentasController@pdf')->name('boletas');
    Route::get('/txt/{num_comprobante}', 'Admin\VentasController@descargartxt')->name('txt');
    // Notas de credito
    Route::post('/notas', 'Admin\VentasController@generarNota')->name('notas.generar');
    Route::get('/nota-pdf/{num_comprobante}', 'Admin\VentasController@notaPDF')->name('notas.pdf');
    Route::get('/nota-txt/{num_comprobante}', 'Admin\VentasController@notatxt')->name('notas.txt');


    Route::get('/txtcab/{num_comprobante}', 'Admin\VentasController@txtcab')->name('txtcab');

    Route::get('/perfil', 'Admin\UsersController@perfil')->name('perfil');
    Route::get('/configuraciones', 'Admin\SettingsController@setting')->name('setting');

    Route::get('/generar-reporte', 'Admin\ReportsController@create')->name('reportes.create');
    Route::post('/reportes', 'Admin\ReportsController@generarReporte')->name('reportes.generar');

    Route::get('/reportes/pdf/{fecha_inicio}/{fecha_final}/{tipo}', 'Admin\ReportsController@exportarPDF')->name('reportes.exportar.pdf');
    Route::post('/reportes/excel', 'Admin\ReportsController@exportarExcel')->name('reportes.exportar.excel');

    Route::get('/json', function(){
        $rxml = "D:/Code/RES/R11069415177-03-B001-0000005/R-11069415177-03-B001-0000005.xml";
        $exml = "D:/Code/RES/11069415177-03-B001-0000005.xml";
        // $fxml = "D:/Code/RES/01.xml";
        // 20505155151|03|B001|3|2.29|15.00|2019-03-24||99999999|wpnaX5tySXgpe8rGQEdx6tIJmqo=

        $archivo_res = file_get_contents($rxml);
        $res_xml = new SimpleXMLElement($archivo_res);
        $estado[0] = $res_xml->xpath('//cbc:Description');

        $archivo_env = file_get_contents($exml);
        $env_xml = new SimpleXMLElement($archivo_env);
        $firma[0] = $env_xml->xpath('//ds:DigestValue');
        $firma_hash = '';
        foreach($firma[0] as $value){
            $firma_hash =  $value;
        }
        $url = base_path().'/storage/app/public/files/B001-0000005.png';
        // $result = QrCode::format('png')->size(300)->generate('Make me into a QrCode!', $url);
        if(file_exists($url)){
            echo "yes";
        }else{
            echo 'no';
        }
        // echo "QR Generated: $result";
    });
    
});