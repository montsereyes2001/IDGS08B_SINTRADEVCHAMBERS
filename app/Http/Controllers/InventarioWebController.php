<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InventarioWebController extends Controller
{
    //
    public function inicio(){
        return view('content.administrador.inventarioAdmin',[
            'response'=>self::index(),
            'title'=>'Lista inventario'
        ]);
    }
    public function index(){
        $url = env('DIR_ROOT')."invent/list";
        $response = Http::get($url);
        return $response->object();
    }

    public function store($rama, $codprod, $cant){
        $url = env('DIR_ROOT')."invent/reg";
        $response = Http::post($url, [
            'nombre_rama'=> $rama,
            'codigo_producto' => $codprod,
            'cantidad' => $cant,
        ]);
        return $response->object();
    }

    public function update($rama, $codprod, $cant){
        $url = env('DIR_ROOT')."invent/updt";
        $response = Http::put($url, [
            'nombre_rama'=> $rama,
            'codigo_producto' => $codprod,
            'cantidad' => $cant,
        ]);
        return $response->object();
    }

    public function destroy($rama, $codprod){
        $url = env('DIR_ROOT')."invent/del";
        $response = Http::delete($url, [
            'nombre_rama' => $rama,
            'codigo_producto' => $codprod
        ]);
        return $response->object();
    }
}
