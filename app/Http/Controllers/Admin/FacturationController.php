<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

use SoapClient;

class FacturationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('facturation.index');
    }

    
    public function generar(Request $request)
    {
        $params = '
            <?xml version="1.0" encoding="ISO-8859-1" standalone="no" ?>
            <soapenv:Header>
                <wsse:Security> 
                    <wsse:UsernameToken>
                        <wsse:Username>20100066603MODDATOS</wsse:Username>
                        <wsse:Password>moddatos</wsse:Password>
                    </wsse:UsernameToken>
                </wsse:Security>
            </soapenv:Header>
        ';
        $url = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl';

        try {
            $result = new SoapClient($url);
            dd($result);
        } catch (SoapFault $fault) {
            echo '<br>'.$fault;
        }
    }

    
    public function agregarProducto(Request $request)
    {
        return response()->json("ok", 200);
    }

    
    public function show($id)
    {
        
    }

   
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
       
    }

    
    public function destroy($id)
    {
        
    }
}
