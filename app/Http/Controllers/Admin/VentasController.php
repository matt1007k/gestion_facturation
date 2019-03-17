<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Venta;
use App\Detalle;
use App\User;

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
        $empresa = User::findOrFail(Auth::id());
        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();
        // dd($empresa['logo']);
        // dd(public_path());
        // dd(base_path().$empresa['logo']);
        
        if($comprobante->tipo === 'FA'){
            $tipo = "FACTURA ELECTRÓNICA";
            $pdf = PDF::loadView('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa]);
        }elseif ($comprobante->tipo === 'BO') {
            $tipo = "BOLETA DE VENTA ELECTRÓNICA";
            $pdf = PDF::loadView('plantillas.boleta', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa]);
        }
        //$pdf->setPaper('a4', 'landscape');
        return $pdf->stream();
        // return view('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa]);
    }

    public function descargar($num_comprobante)
    {
        $tipo = "FACTURA ELECTRÓNICA";
        $num_tipo = "";
        $pdf = "";
        $empresa = User::findOrFail(Auth::id());

        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();

        if($comprobante->tipo === 'FA'){
            $tipo = "FACTURA ELECTRÓNICA";
            $num_tipo = "01";
            $pdf = PDF::loadView('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa]);
        }elseif ($comprobante->tipo === 'BO') {
            $tipo = "BOLETA DE VENTA ELECTRÓNICA";
            $num_tipo = "03";
            $pdf = PDF::loadView('plantillas.boleta', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa]);
        }
        //$pdf->setPaper('a4', 'landscape');
        $name_pdf = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.pdf';
        return $pdf->download($name_pdf);
        // return view('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa]);
    }

    public function descargartxt($num_comprobante){
        $tipo = "FACTURA ELECTRÓNICA";
        $num_tipo = "";
        $tipo_doc = "";
        $empresa = User::findOrFail(Auth::id());
        
        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();

        if($comprobante->tipo === 'FA'){
            $tipo = "FACTURA ELECTRÓNICA";
            $num_tipo = "01";
            $tipo_doc = "RUC";
            
        }elseif ($comprobante->tipo === 'BO') {
            $tipo = "BOLETA DE VENTA ELECTRÓNICA";
            $num_tipo = "03"; 
            $tipo_doc = "DNI";           
        }

        $content = "";

        $content .= "Comprobante: ".$tipo."|".$comprobante->num_comprobante."\n";
        $content .= "RESUMEN DE VENTA: \n";
        $content .= "Tienda: ".$empresa->name."|RUC: ".$empresa->ruc."\n";
        $content .= "Cliente: ".$comprobante->nombre."|Tipo Doc.: ".$tipo_doc."|Num. Doc.: ".$comprobante->num_doc."|Fecha: ".$comprobante->fecha_emision."\n";
        $content .= "DETALLE DE VENTA \n";
        foreach ($comprobante->details as $detalle) {
            $content .= "Descripcion: ".$detalle->descripcion."|Cantidad: ".(int)$detalle->cantidad."|Precio: ".$detalle->precio."|Importe: ".$detalle->subtotal."\n";
        }
        $content .= "Subtotal: ".$comprobante->subtotal."\n";
        $content .= "Ivg: ".$comprobante->igv."\n";
        $content .= "Total a pagar: ".$comprobante->total."\n";


        $name_txt = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.txt';
        
        

        //offer the content of txt as a download ($name_txt.txt)
        return response($content)
                ->withHeaders([
                    'Content-Type' => 'text/plain',
                    'Cache-Control' => 'no-store, no-cache',
                    'Content-Disposition' => 'attachment; filename="'.$name_txt,
                ]);
    }
    
    public function generar(GenerarRequest $request)
    {
        $venta = new Venta();
        
        $venta->tipo = $request->tipo;
        $venta->num_comprobante = $request->num_serie.'-'.$request->num_emision;
        $venta->fecha_emision = Carbon::parse($request->fecha_emision)->format('Y-m-d');
        $venta->tipo_doc = $request->tipo_doc;
        $venta->num_doc = $request->cliente['num_doc'];
        $venta->nombre = $request->cliente['nombre'];
        $venta->direccion = $request->cliente['direccion'];
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
                $detalle->unidad = $detalle_venta['unity'];
                $detalle->subtotal = $detalle_venta['price'] * $detalle_venta['quantity'];
                $detalle->save();
            }


            return route('pdf', ['num_comprobante'=> $venta->num_comprobante]);
        }
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
