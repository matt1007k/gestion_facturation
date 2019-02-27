<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Venta;

use App\Http\Controllers\Requests\GenerarRequest;
//use SoapClient;
use PDF;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.ventas.index');
    }

    public function create()
    {
        return view('admin.ventas.create');
    }

    public function pdf()
    {
        $comprobante = array('cliente' => 'CARNAQUE CASTRO ERWIN PAUL',
    
            'details' => [['description' => 'Arroz', 'price' => 54], ['description' => 'Arroz 2', 'price' => 23]]
        );

        $pdf = PDF::loadView('plantillas.factura', ['comprobante' => $comprobante]);
        //$pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
        // return view('document.factura');
    }
    
    public function generar(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        
        
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
