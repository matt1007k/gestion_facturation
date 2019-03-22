<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Venta;

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

        return response()->json([
            'totalFacturas' => count($totalFacturas),
            'totalBoletas' => count($totalBoletas)
        ], 200);
    }
}
