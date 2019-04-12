<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Venta;
use App\Client;
use App\Product;
use App\Detalle;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getCodes(){
        $totalFacturas = Venta::where('tipo', 'FA')->get();
        $totalBoletas = Venta::where('tipo', 'BO')->get();

        $totalNotaCredito = Venta::where('tipo', 'NC')->get();
        $totalNotaDebito = Venta::where('tipo', 'ND')->get();

        return response()->json([
            'totalFacturas' => count($totalFacturas),
            'totalBoletas' => count($totalBoletas),
            'totalNotaCredito' => count($totalNotaCredito),
            'totalNotaDebito' => count($totalNotaDebito)
        ], 200);
    }

    public function getCounts()
    {
        $products = Product::where('user_id', Auth::id())->get();
        $sales = Venta::where('user_id', Auth::id())->where('estado','!=','canceled')
                    ->where('tipo','!=','NC')->where('tipo','!=','ND')->get();
        $clients = Client::where('user_id', Auth::id())->get();
        $prodSales = Detalle::sum('cantidad');

        $proSales = array();

        foreach($sales as $sale){
            foreach ($sale->details as $product) {
                # code...
                array_push($proSales, ['sales' => $product]);
            }
        }

        return response()->json([
            'totalProducts' => count($products),
            'totalSales' => count($sales),
            'totalClients' => count($clients),
            'totalProdSales' => count($proSales)
        ], 200);
    }

    public function getVentas(Request $request){
        $sales = Venta::where('user_id', Auth::id())->where('estado','!=','canceled')
                ->where('tipo','!=','NC')->where('tipo','!=','ND')->get(['total', 'created_at']);
        $facturas = Venta::comprobante('FA')->get(['total', 'created_at', 'fecha_emision']);
        $boletas =  Venta::comprobante('BO')->get(['total', 'created_at', 'fecha_emision']);
        $ventas = array();
        $documentos = array();
        $bol = array();

        // Formato de ventas
        foreach ($sales as $venta) {
            $fecha_emision = Carbon::parse($venta->created_at)->format('Y-m-d h:i:s T');
            array_push($ventas ,['fecha' => $fecha_emision, 'total' => $venta->total]);
        }

        // foreach ($sales as $venta) {
        //     $fecha_emision = Carbon::parse($venta->created_at)->format('Y-m-d h:i:s T');
        //     array_push($documents ,['fecha' => $fecha_emision, 'total' => $venta->total]);
        // }

        foreach ($facturas as $factura) {
            $fecha_emision = Carbon::parse($factura->created_at)->format('Y-m-d h:i:s T');
            
            array_push($documentos ,['name' => 'Facturas', 'data' => [$factura->fecha_emision =>  (int)$factura->total]]);
        }
        foreach ($boletas as $boleta) {
            $fecha_emision = Carbon::parse($boleta->created_at)->format('Y-m-d h:i:s T');
            
            array_push($documentos ,['name' => 'Boletas', 'data' => [$boleta->fecha_emision =>  (int)$boleta->total]]);
        }

        return response()->json([
            'sales' => $ventas,
            'documentos' => $documentos
        ], 200);
    }
}
