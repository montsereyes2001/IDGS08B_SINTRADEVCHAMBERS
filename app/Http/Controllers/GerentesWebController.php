<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Http;

class GerentesWebController extends Controller
{
    //
    public function inicio(){
        return view('content.administrador.gerentesAdmin',[
            'response'=>self::index(),
            'title'=>'Lista gerentes'
        ]);
    }

    public function index(){
        $url = env('DIR_ROOT')."ger/list";
        $response = Http::get($url);
        return $response->object();
    }

    public function store(Request $request){
        $url = env('DIR_ROOT')."ger/reg";
        $response = Http::post($url,[
            "correo" => $request->correo,
            "estado" => $request->estado
        ]);
        return $response->object();
    }

    public function update(Request $request){
        $url = env('DIR_ROOT')."ger/updt";
        $response = Http::put($url, [
            'correo' => $request->correo,
            'nuevo_estado'=> $request->nestado,
        ]);
        return $response->object();
    }

    public function destroy(Request $request){
        $url = env('DIR_ROOT')."ger/del";
        $response = Http::delete($url, [
            'correo' => $request->correo
        ]);
        return $response->object();
    }
}
