<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Venta;
use App\Detalle;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GenerarRequest;
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

    public function getSales(Request $request){
        $sales = Venta::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(6);

        $pagination = [
            'total' => $sales->total(),
            'current_page' => $sales->currentPage(),
            'per_page' => $sales->perPage(),
            'last_page' => $sales->lastPage(),
            'from' => $sales->firstItem(),
            'to' => $sales->lastPage()
        ];

        return response()->json([
            'sales' => $sales,
            'pagination' => $pagination
        ], 200);
    }

    public function create()
    {
        return view('admin.ventas.create');
    }

    public function pdf($num_comprobante)
    {
        $tipo = "FACTURA ELECTRÓNICA";
        $pdf = "";
        
        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();

        if($comprobante->tipo === 'FA'){
            $tipo = "FACTURA ELECTRÓNICA";
            $pdf = PDF::loadView('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo]);
        }elseif ($comprobante->tipo === 'BO') {
            $tipo = "BOLETA DE VENTA ELECTRÓNICA";
            $pdf = PDF::loadView('plantillas.boleta', ['comprobante' => $comprobante, 'tipo' => $tipo]);
        }
        //$pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
        // return view('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo]);
    }

    public function descargar($num_comprobante)
    {
        $tipo = "FACTURA ELECTRÓNICA";
        $num_tipo = "";
        $pdf = "";
        $RUC = "11010101010";

        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();

        if($comprobante->tipo === 'FA'){
            $tipo = "FACTURA ELECTRÓNICA";
            $num_tipo = "01";
            $pdf = PDF::loadView('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo]);
        }elseif ($comprobante->tipo === 'BO') {
            $tipo = "BOLETA DE VENTA ELECTRÓNICA";
            $num_tipo = "03";
            $pdf = PDF::loadView('plantillas.boleta', ['comprobante' => $comprobante, 'tipo' => $tipo]);
        }
        //$pdf->setPaper('a4', 'landscape');
        $name_pdf = $RUC.'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.pdf';
        return $pdf->download($name_pdf);
        // return view('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo]);
    }
    
    public function generar(GenerarRequest $request)
    {
        $venta = new Venta();
        
        $venta->tipo = $request->tipo;
        $venta->num_comprobante = $request->num_serie.'-'.$request->num_emision;
        $venta->fecha_emision = $request->fecha_emision;
        $venta->tipo_doc = $request->tipo_doc;
        $venta->num_doc = $request->cliente->num_doc;
        $venta->nombre = $request->cliente->nombre;
        $venta->direccion = $request->cliente->direccion;
        $venta->subtotal = $request->subtotal;
        $venta->igv = $request->igv;
        $venta->total = $request->subtotal + $request->igv;
        $venta->user_id = $request->user_id;
        
        if($venta->save()){
            foreach ($request->details as $detalle_venta) { 
                $detalle = new Detalle(); 
                $detalle->venta_id = $venta->id;            
                $detalle->cantidad = $detalle_venta['quantity'];
                $detalle->nombre = $detalle_venta['name'];
                $detalle->descripcion = $detalle_venta['description'];
                $detalle->precio = $detalle_venta['price'];
                $detalle->descuento = 0.00;
                $detalle->unidad = $detalle_venta['unidad'];
                $detalle->subtotal = $detalle_venta['price'] * $detalle_venta['quantity'];
                $detalle->save();
            }


            return route('pdf', ['num_comprobante'=> $venta->num_comprobante]);
        }
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
