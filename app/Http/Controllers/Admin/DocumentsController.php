<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

//use SoapClient;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.documentos.index');
    }

    public function create()
    {
        return view('admin.documentos.create');
    }
    
    public function generar(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        
        
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
