<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IconosWebController extends Controller
{
    //
    public function inicio(){
        return view('content.administrador.iconosAdmin',[
            'response'=>self::index(),
            'title'=>'Lista iconos'
        ]);
    }
    public function index(){
        $url = env('DIR_ROOT')."icon/list";
        $response = Http::get($url);
        return $response->object();
    }
    public function store(Request $request){
        $url = env('DIR_ROOT')."icon/reg";
        $response = Http::post($url, [
            'nombre'=> $request->nom,
            'url' => $request->dir
        ]);
        return $response->object();
    }
    public function update(Request $request){
        $url = env('DIR_ROOT')."icon/updt";
        $response = Http::put($url, [
            'nombre_icono'=> $request->nom,
            'nueva_url' => $request->dir
        ]);
        return $response->object();
    }
    public function destroy(Request $request){
        $url = env('DIR_ROOT')."icon/del";
        $response = Http::delete($url, [
            'nombre' => $request->nom
        ]);
        return $response->object();
    }
}