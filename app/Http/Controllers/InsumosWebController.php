<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InsumosWebController extends Controller
{
    //
    public function index(){
        $url = env('DIR_ROOT')."insm/list";
        $response = Http::get($url);
        return $response->object();
    }
    public function store($trab, $rama, $clid, $ciu, $esta, $cprod, $cant){
        $url = env('DIR_ROOT')."insm/reg";
        $response = Http::post($url,[
            "nombre_trabajo" => $trab,
            "nombre_rama" => $rama,
            "correo_lider" => $clid,
            "ciudad" => $ciu,
            "estado" => $esta,
            "codigo_producto" => $cprod,
            "cantidad" => $cant
        ]);
        return $response->object();
    }
    public function update($trab, $rama, $clid, $ciu, $esta, $cprod, $cnprod, $cant){
        $url = env('DIR_ROOT')."insm/updt";
        $response = Http::put($url, [
            'nombre_trabajo' => $trab,
            'nombre_rama' => $rama,
            'correo_lider' => $clid,
            'ciudad' => $ciu,
            'estado' => $esta,
            'codigo_producto' => $cprod,
            'nuevo_producto' => $cnprod,
            'cantidad' => $cant
        ]);
        return $response->object();
    }

    public function destroy($id){
        $url = env('DIR_ROOT')."insm/del";
        $response = Http::delete($url, [
            'id' => $id,
        ]);
        return $response->object();
    }
}
