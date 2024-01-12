<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductosWebController extends Controller
{
    //
    public function inicio(){
        return view('content.administrador.productosAdmin',[
            'response'=>self::index(),
            'title'=>'Lista productos'
        ]);
    }

    public function index(){
        $url = env('DIR_ROOT')."prod/list";
        $response = Http::get($url);
        return $response->object();
    }

    public function store(Request $request){
        $url = env('DIR_ROOT')."prod/reg";
        $response = Http::post($url, [
            'codigo_inicial'=> $request->cod,
            'nombre' => $request->nom,
            'categoria' => $request->cat,
            'descripcion' => $request->desc
        ]);
        return $response->object();
    }

    public function update(Request $request){
        $url = env('DIR_ROOT')."prod/updt";
        $response = Http::put($url, [
            'codigo_producto'=> $request->codprod,
            'nuevo_codigo' => $request->ncod,
            'nuevo_nombre' => $request->nnom,
            'nueva_categoria' => $request->ncat,
            'nueva_desc' => $request->ndesc,
        ]);
        return $response->object();
    }
    
    public function destroy(Request $request){
        $url = env('DIR_ROOT')."prod/del";
        $response = Http::delete($url, [
            'codigo_inicial' => $request->cod
        ]);
        return $response->object();
    }
}