<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RamasWebController extends Controller
{
    //
    public function inicio(){
        return view('content.administrador.ramasAd',[
            'response'=>self::index(),
            'title'=>'Lista ramas'
        ]);
    }
    public function index(){
        $url = env('DIR_ROOT')."rama/list";
        $response = Http::get($url);
        return $response->object();
    }

    public function store(Request $request){
        $url = env('DIR_ROOT')."rama/reg";
        $response = Http::post($url, [
            'nombre'=> $request->nom,
            'cliente' => $request->cli,
            'nombre_invitado' => $request->inv,
        ]);
        return $response->object();
    }

    public function update(Request $request){
        $url = env('DIR_ROOT')."rama/updt";
        $response = Http::put($url, [
            'nombre_rama'=> $request->nom,
            'nuevo_nombre' => $request->nnom,
            'cliente' => $request->cli,
            'nombre_invitado' => $request->inv,
        ]);
        return $response->object();
    }

    public function destroy(Request $request){
        $url = env('DIR_ROOT')."rama/del";
        $response = Http::delete($url, [
            'nombre' => $request->nom
        ]);
        return $response->object();
    }
}
