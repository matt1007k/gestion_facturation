<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductsController extends Controller
{
    
    public function getProducts(){
        $products = Product::orderBy('name', 'asc')->get();

        $tipos = ['Factura', 'Boleta de Venta', 'Nota de Credito', 'Nota de Debito'];
        $tipos_doc = ['DNI', 'RUC'];

        return response()->json([
            'products' => $products,
            'tipos' => $tipos,
            'tipos_doc' => $tipos_doc
        ], 200);
    }
    public function create(Request $request){
        
    }
}
