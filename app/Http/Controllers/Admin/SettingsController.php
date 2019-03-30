<?php

namespace App\Http\Controllers\Admin;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setting()
    {
        $setting = Auth::user()->setting;

        return response()->json([
            'setting' => $setting
        ], 200);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
       $setting->sfs_url = $request->sfs_url;
       if($setting->save()){
            return response()->json([
                'message' => 'Configuración actualizada',
                'setting' => $setting
            ], 202); 
       }
    }

    
}
