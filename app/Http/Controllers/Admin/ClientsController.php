<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index(){
        return view('admin.clientes.index');
    }
    public function getClients(Request $request)
    {
        $clients = Client::where('user_id', Auth::id())->orderBy('nombre', 'asc')->paginate(6);

        $pagination = [
            'total' => $clients->total(),
            'current_page' => $clients->currentPage(),
            'per_page' => $clients->perPage(),
            'last_page' => $clients->lastPage(),
            'from' => $clients->firstItem(),
            'to' => $clients->lastPage()
        ];

        return response()->json([
            'clients' => $clients,
            'pagination' => $pagination
        ], 200);
    }

    public function getClientes(Request $request)
    {
        $texto = $request->get('query');
        $clients = Client::nombre($texto)->where('user_id', Auth::id())->orderBy('nombre', 'asc')->get();

        return response()->json([
            'clients' => $clients
        ], 200);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo_doc' => 'required',
            'num_doc' => 'required',
        ]);

        $client = new Client();
        $client->nombre = $request->nombre;
        $client->tipo_doc = $request->tipo_doc;
        $client->num_doc = $request->num_doc;
        $client->direccion = $request->direccion;   
        $client->user_id = $request->user_id;

        if ($client->save()) {
            return response()->json([
                'message' => 'Cliente creado con exito',
                'client' => $client
            ], 202);
        } 
        
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo_doc' => 'required',
            'num_doc' => 'required',
        ]);

        $client = Client::findOrFail($id);
        $client->nombre = $request->nombre;
        $client->tipo_doc = $request->tipo_doc;
        $client->num_doc = $request->num_doc;
        $client->direccion = $request->direccion; 

        if ($client->save()) {
            return response()->json([
                'message' => 'Cliente editado con exito',
                'client' => $client
            ], 202);
        } 
        
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);

        if ($client->delete()) {
            return response()->json([
                'message' => 'Cliente eliminado con exito',
                'client' => $client
            ], 200);
        } 
    }


}
