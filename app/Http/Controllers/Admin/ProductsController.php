<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductsController extends Controller
{
    
    public function getProducts(Request $request){
        $products = Product::orderBy('name', 'asc')->paginate(6);

        $tipos = ['Factura', 'Boleta de Venta', 'Nota de Credito', 'Nota de Debito'];
        $tipos_doc = ['DNI', 'RUC'];

        $pagination = [
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'per_page' => $products->perPage(),
            'last_page' => $products->lastPage(),
            'from' => $products->firstItem(),
            'to' => $products->lastPage()
        ];

        return response()->json([
            'products' => $products,
            'pagination' => $pagination,
            'tipos' => $tipos,
            'tipos_doc' => $tipos_doc
        ], 200);
    }
    public function index(){
        return view('admin.productos.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = new Product();
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;   
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->img = 'producto.jpg';
        $product->status = $request->status;

        if ($product->save()) {
            return response()->json([
                'message' => 'Producto creado con exito',
                'product' => $product
            ], 202);
        } 
        
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        return response()->json([
            'product' => $product
        ], 200);
        
    }


    public function changeImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->img = 'producto.jpg';

        if ($product->save()) {
            return response()->json([
                'message' => 'Imagen subida con exito',
                'product' => $product
            ], 202);
        } 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::findOrFail($id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;   
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->status = $request->status;

        if ($product->save()) {
            return response()->json([
                'message' => 'Producto editado con exito',
                'product' => $product
            ], 202);
        } 
        
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->delete()) {
            return response()->json([
                'message' => 'Producto eliminado con exito',
                'product' => $product
            ], 200);
        } 
    }
}
