<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
