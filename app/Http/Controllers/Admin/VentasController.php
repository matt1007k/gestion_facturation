<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Venta;
use App\Detalle;
use App\User;

use App\Helpers\ConvertNumToLetter;

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

    public function getTypesOperationNote($type)
    {
        
    }

    public function getDetailsDocument($num_comprobante){
        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();
        $detalles = array();


        // Formato de ventas
        foreach ($comprobante->details as $detalle) {
            $product = Product::where('code', $detalle->codigo)->first();
            array_push($detalles , [
                'id' => $product->id,
                'code' => $detalle->codigo,
                'name' => $detalle->nombre,
                'description' => $detalle->descripcion,
                'img' => $product->img,
                'price' => $detalle->precio,
                'quantity' => (int)$detalle->cantidad,
                'status' => $product->status,
                'unity' => $product->unity,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
                'user_id' =>  $product->user_id           
            ]);
            
        }

        $tipos_operacion_nota_credito = array(
            ['value'=> '01', 'text' => 'Anulación de la operación'],
            ['value'=> '02', 'text' => 'Anulación por error en el RUC'],
            ['value'=> '03', 'text' => 'Corrección por error en la descripción'],
            ['value'=> '04', 'text' => 'Descuento global'],
            ['value'=> '05', 'text' => 'Descuento por ítem'],
            ['value'=> '06', 'text' => 'Devolución total'],
            ['value'=> '07', 'text' => 'Devolución por ítem'],
            ['value'=> '08', 'text' => 'Bonificación'],
            ['value'=> '09', 'text' => 'Disminución en el valor'],
            ['value'=> '10', 'text' => 'Otros Conceptos'],
            ['value'=> '11', 'text' => 'Ajustes de operaciones de exportación'],
            ['value'=> '12', 'text' => 'Ajustes afectos al IVAP']
        );

        $tipos_operacion_nota_debito = array(
            ['value'=> '01', 'text' => 'Intereses por mora'],
            ['value'=> '02', 'text' => 'Aumento en el valor'],
            ['value'=> '03', 'text' => 'Penalidades/ otros conceptos'],
            ['value'=> '11', 'text' => 'Ajustes de operaciones de exportación'],
            ['value'=> '12', 'text' => 'Ajustes afectos al IVAP']
        );

        $tipos = [
            ['NC', 'Nota de Crédito'], 
            ['ND','Nota de Débito'] 
            #'Nota de Credito', 'Nota de Debito'
        ];

        return response()->json([
            'comprobante' => $comprobante,
            'detalles' => $detalles,
            'tipos' => $tipos,
            'tipos_credito' => $tipos_operacion_nota_credito,
            'tipos_debito' => $tipos_operacion_nota_debito
        ], 200);
    }

    public function createNota($num_comprobante)
    {
        $num_comprobant = (string)$num_comprobante;
        return view('admin.ventas.notas', ['num_comprobant' => $num_comprobant]);
    }

    public function pdf($num_comprobante)
    {
        $tipo = "FACTURA ELECTRÓNICA";
        $tipoC = "";
        $pdf = "";
        $empresa = User::findOrFail(Auth::id());
        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();
        // dd($empresa['logo']);
        // dd(public_path());
        // dd(base_path().$empresa['logo']);
        $urlSF = Auth::user()->setting['sfs_url'];
        $name_comprobant = "";

        if($comprobante->tipo === 'FA'){
            $tipo = "FACTURA ELECTRÓNICA";
            $tipoC = "01";
            $name_comprobant = $empresa->ruc."-".$tipoC."-".$num_comprobante;
        }
        elseif($comprobante->tipo === 'BO') {
            $tipo = "BOLETA DE VENTA ELECTRÓNICA";
            $tipoC = "03";
            $name_comprobant = $empresa->ruc."-".$tipoC."-".$num_comprobante;
        }

        $file_R = $urlSF."sunat_archivos/sfs/RPTA/R".$name_comprobant.".zip";
        $file_E = $urlSF."sunat_archivos/sfs/ENVIO/".$name_comprobant.".zip";

        $rxml = $urlSF."sunat_archivos/sfs/RPTA/R-".$name_comprobant.".xml";
        $exml = $urlSF."sunat_archivos/sfs/ENVIO/".$name_comprobant.".xml";
        
        // get the absolute path to $file
        $path_R = pathinfo(realpath($file_R), PATHINFO_DIRNAME);
        $path_E = pathinfo(realpath($file_E), PATHINFO_DIRNAME);

        $zip_R = new \ZipArchive;
        $res_R = $zip_R->open($file_R);

        $zip_E = new \ZipArchive;
        $res_E = $zip_E->open($file_E);
        if ($res_R === TRUE) {
            // extract it to the path we determined above
            $zip_R->extractTo($path_R);
            $zip_E->extractTo($path_E);
            $zip_R->close();
            $zip_E->close();

            $archivo_res = file_get_contents($rxml);
            $res_xml = new \SimpleXMLElement($archivo_res);
            $estado = $res_xml->xpath('//cbc:Description');
    
            $archivo_env = file_get_contents($exml);
            $env_xml = new \SimpleXMLElement($archivo_env);
            $firma = $env_xml->xpath('//ds:DigestValue');
            $firma_hash = $firma[0][0];
            $arrayNum = explode('-', $num_comprobante);
            $serie = $arrayNum[0];
            $numS = $arrayNum[1];
            
            $convertirString = new ConvertNumToLetter();
            $total_string = $convertirString->convertir($comprobante->total);
            
            if($comprobante->tipo === 'FA'){
                
                
                // Generamos el code QR
                $url = base_path().'/storage/app/public/files/'.$num_comprobante.'.png';
                $qr_text = "$empresa->ruc|$tipoC|$serie|$numS|$comprobante->igv|$comprobante->total|$comprobante->fecha_emision||99999999|$firma_hash";
                \QrCode::format('png')->size(300)->generate($qr_text, $url);
    
                $pdf = PDF::loadView('plantillas.factura', [
                    'comprobante' => $comprobante, 'tipo' => $tipo, 
                    'empresa' => $empresa, 'total_string' => $total_string,
                    'firma_hash' => $firma_hash
                ]);
            }elseif ($comprobante->tipo === 'BO') {
                
                // Generamos el code QR
                $url = base_path().'/storage/app/public/files/'.$num_comprobante.'.png';
                $qr_text = "$empresa->ruc|$tipoC|$serie|$numS|$comprobante->igv|$comprobante->total|$comprobante->fecha_emision||99999999|$firma_hash";
                \QrCode::format('png')->size(300)->generate($qr_text, $url);
    
                $pdf = PDF::loadView('plantillas.boleta', [
                    'comprobante' => $comprobante, 'tipo' => $tipo, 
                    'empresa' => $empresa, 'total_string' => $total_string,
                    'firma_hash' => $firma_hash
                ]);
            }
            //$pdf->setPaper('a4', 'landscape');
            return $pdf->stream();
            // return view('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa]);
            
        } else {
            return response()->json([
                'message' => 'No has enviado el comprobante a la sunat'
            ], 500);
        }
 
    }

    public function generateQR(){
        
    } 

    public function descargar($num_comprobante)
    {
        $tipo = "FACTURA ELECTRÓNICA";
        $num_tipo = "";
        $pdf = "";
        $empresa = User::findOrFail(Auth::id());

        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();

        $convertirString = new ConvertNumToLetter();
        $total_string = $convertirString->convertir($comprobante->total);

        if($comprobante->tipo === 'FA'){
            $tipo = "FACTURA ELECTRÓNICA";
            $num_tipo = "01";
            $pdf = PDF::loadView('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa, 'total_string' => $total_string]);
        }elseif ($comprobante->tipo === 'BO') {
            $tipo = "BOLETA DE VENTA ELECTRÓNICA";
            $num_tipo = "03";
            $pdf = PDF::loadView('plantillas.boleta', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa, 'total_string' => $total_string]);
        }
        //$pdf->setPaper('a4', 'landscape');
        $name_pdf = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.pdf';
        return $pdf->download($name_pdf);
        // return view('plantillas.factura', ['comprobante' => $comprobante, 'tipo' => $tipo, 'empresa' => $empresa]);
    }

    public function descargartxt($num_comprobante){

        // D:/SFS_v1.2/sunat_archivos/sfs/DATA/
        // D:/Code/DATA/
        $urlSF = Auth::user()->setting['sfs_url'];
        $folder_generate = $urlSF."sunat_archivos/sfs/DATA/";

        $tipo = "FACTURA ELECTRÓNICA";
        $num_tipo = "";
        $tipo_doc = "";
        $empresa = User::findOrFail(Auth::id());
        
        $comprobante = Venta::where('num_comprobante','=', $num_comprobante)->first();

        $content_cab = "";
        $content_det = "";
        $content_ley = "";
        $content_tri = "";
        $hora_emision = Carbon::parse($comprobante->created_at)->format('h:i:s');

        $convertir = new ConvertNumToLetter();
        $detalle_ley = $convertir->convertir($comprobante->total);

        if($comprobante->tipo === 'FA'){
            $tipo = "FACTURA ELECTRÓNICA";
            $num_tipo = "01";
            $tipo_doc = "RUC";
            // CABECERA
            $content_cab .= "0101|$comprobante->fecha_emision|$hora_emision|-|000|6|$comprobante->num_doc|$comprobante->nombre|PEN|$comprobante->igv|$comprobante->subtotal|$comprobante->total|0.00|0.00|0.00|$comprobante->total|2.1|2.0";
            
            // DETALLE VENTA
            foreach ($comprobante->details as $detalle) {
                $cantidad = (int)$detalle->cantidad;
                $igv = number_format($detalle->subtotal * 0.18, 2);
                $precioUntIgv = $detalle->subtotal + $igv;
                $content_det .= "NIU|$cantidad.000|$detalle->codigo|-|$detalle->descripcion|$detalle->precio|$igv|1000|$igv|$detalle->subtotal|IGV|VAT|10|18.00|-|0.00|0.00||||15.00|-|0.00|0.00|||15.00|$precioUntIgv|$detalle->subtotal|0.00\n";
            }

            // LEYENDA
            //$comprobante->total
            $content_ley .= "1000|$detalle_ley";

            // TRIBUTO
            $content_tri .= "1000|IGV|VAT|$comprobante->subtotal|$comprobante->igv";

        }elseif ($comprobante->tipo === 'BO') {
            $tipo = "BOLETA DE VENTA ELECTRÓNICA";
            $num_tipo = "03"; 
            $tipo_doc = "DNI";   
            $content_cab .= "0101|$comprobante->fecha_emision|$hora_emision|-|000|1|$comprobante->num_doc|$comprobante->nombre|PEN|$comprobante->igv|$comprobante->subtotal|$comprobante->total|0.00|0.00|0.00|$comprobante->total|2.1|2.0";        
        
            // DETALLE VENTA
            foreach ($comprobante->details as $detalle) {
                $cantidad = (int)$detalle->cantidad;
                $igv = number_format($detalle->subtotal * 0.18, 2);
                $precioUntIgv = $detalle->subtotal + $igv;
                $content_det .= "NIU|$cantidad.000|$detalle->codigo|-|$detalle->descripcion|$detalle->precio|$igv|1000|$igv|$detalle->subtotal|IGV|VAT|10|18.00|-|0.00|0.00||||15.00|-|0.00|0.00|||15.00|$precioUntIgv|$detalle->subtotal|0.00\n";
            }

            // LEYENDA
            $content_ley .= "1000|$detalle_ley";

            // TRIBUTO
            $content_tri .= "1000|IGV|VAT|$comprobante->subtotal|$comprobante->igv";
        }

        

        
        //Recorro el directorio para leer los archivos que tiene
        $name_cab = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.CAB';
        $name_det = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.DET';
        $name_ley = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.LEY';
        $name_tri = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.TRI';

        

        // /mnt/d/ con subsystem linux on windowns 10
        file_put_contents($folder_generate.$name_cab, $content_cab);
        file_put_contents($folder_generate.$name_det, $content_det);

        file_put_contents($folder_generate.$name_ley, $content_ley);
        file_put_contents($folder_generate.$name_tri, $content_tri);
        
        return response()->json([
            'message' => 'Archivos generados con exito'
        ], 200);
    }

    
    public function txtCab($num_comprobante){
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
        $content_det = "";

        $content .= "Comprobante: ".$tipo."|".$comprobante->num_comprobante."\n";
        $content .= "RESUMEN DE VENTA: \n";
        $content .= "Tienda: ".$empresa->name."|RUC: ".$empresa->ruc."\n";
        
        $content .= "Cliente: ".$comprobante->nombre."|Tipo Doc.: ".$tipo_doc."|Num. Doc.: ".$comprobante->num_doc."|Fecha: ".$comprobante->fecha_emision."\n";
        $content .= "DETALLE DE VENTA \n";
        foreach ($comprobante->details as $detalle) {
            $content_det .= "Descripcion: ".$detalle->descripcion."|Cantidad: ".(int)$detalle->cantidad."|Precio: ".$detalle->precio."|Importe: ".$detalle->subtotal."\n";
        }
        $content .= "Subtotal: ".$comprobante->subtotal."\n";
        $content .= "Ivg: ".$comprobante->igv."\n";
        $content .= "Total a pagar: ".$comprobante->total."\n";


        $name_cab = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.CAB';
        $name_det = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.DET';
        $name_ley = $empresa['ruc'].'-'.$num_tipo.'-'.$comprobante->num_comprobante.'.LEY';
        
        // $headers1 = array(
        //     'Content-Type' => 'plain/txt',
        //     'Content-Disposition' => sprintf('attachment; filename="%s"', $name_cab)
        // );

        $headers = array(
            'Content-Type' => 'plain/txt'
        );
       Storage::put('public/files/'.$name_det, $content);
       Storage::put('public/files/'.$name_cab, $content);
       
          
       
       return response()->json([
           'DET' => url(Storage::url('public/files/'.$name_det)),
           'CAB' => url(Storage::url('public/files/'.$name_cab))
        ]   
        , 200, $headers);
    //    Storage::copy("public/files/".$name_cab, "D:\Code\DATA\".$name_cab);
    
    // dd(base_path().Storage::url('public/files/'.$name_cab));
    //     return \Response::make($content, '200', $headers);
        // dd(base_path().Storage::url('files/text_plain.txt'));
        
        // Storage::putFileAs('files', new File(public_path().Storage::url('files/text_plain.txt')), $name_txt);
        //offer the content of txt as a download ($name_txt.txt)
        // return response($content)
        //         ->withHeaders([
        //             'Content-Type' => 'text/plain',
        //             'Cache-Control' => 'no-store, no-cache',
        //             'Content-Disposition' => 'attachment; filename="'.$name_txt,
        //         ]);
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
                $detalle->codigo = $detalle_venta['code'];         
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

    public function generarNota(Request $request)
    {
        return $request;
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
                $detalle->codigo = $detalle_venta['code'];         
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
