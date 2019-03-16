<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Storage;
use App\User;
use Auth;

class UsersController extends Controller
{
    public function perfil(){
        return view('admin.usuarios.perfil');
    }
    public function getUserAuth(){
        $id = Auth::check() ? Auth::user()->id : null;
        $user = auth()->user();
        return response()->json([
            'user' => $id 
        ], 200);
    }

    public function update(UserEditRequest $request, $id){
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->ruc = $request->ruc;
        $user->telefono = $request->telefono;
        $user->direccion = $request->direccion;

        if ($user->save()) {
            return response()->json([
                'message' => 'Datos editados con exito',
                'user' => $user
            ], 201);
        }
    }

    public function upload(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);
        $userId = $request->input('id');
        $user = User::findOrFail($userId);
        // Eliminamos el archivo del sistema
        Storage::delete($user->logo);

        $getFileExt  = $request->file('logo')->getClientOriginalExtension();
        // Almacenamos o subirmos a la carpeta storage/app/public/nombre_archivo.ext
        $archivo = $request->file('logo')->storeAs('public/logos', 'logo-'.$userId.'.'.$getFileExt);
        // Creamos la ruta del storage/nombre_archivo.ext 
        // Guardamos el archivo
        $user->logo = Storage::url($archivo);

        if ($user->save()) {
            return response()->json([
                'message' => 'Logo subido con exito'
            ], 200);
        } 
    }
}
