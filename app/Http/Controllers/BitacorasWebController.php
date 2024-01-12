<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BitacorasWebController extends Controller
{
    //
    public function index(){
        $url = env('DIR_ROOT')."bit/list";
        $response = Http::get($url);
        return $response->object();
    }
     public function indexWeb(){
        return view ('content.lider.bitacorasLider',[
          "title" => "Dashboard | Bitacora",
          "response" => self::index()
      ]);
  }

    public function store($trab, $rama, $clid, $ciu, $esta, $sta){
        $url = env('DIR_ROOT')."bit/reg";
        $response = Http::post($url,[
            "nombre_trabajo" => $trab,
            "nombre_rama" => $rama,
            "correo_lider" => $clid,
            "ciudad" => $ciu,
            "estado" => $esta,
            "estatus" => $sta
        ]);
        return $response->object();
    }

    public function update($trab, $rama, $clid, $ciu, $esta, $nsta){
        $url = env('DIR_ROOT')."bit/updt";
        $response = Http::put($url, [
            'nombre_trabajo' => $trab,
            'nombre_rama' => $rama,
            'correo_lider' => $clid,
            'ciudad' => $ciu,
            'estado' => $esta,
            'nuevo_estatus' => $nsta
        ]);
        return $response->object();
    }
    public function destroy($trab, $rama, $clid, $ciu, $esta){
        $url = env('DIR_ROOT')."bit/del";
        $response = Http::delete($url, [
            'nombre_trabajo' => $trab,
            'nombre_rama' => $rama,
            'correo_lider' => $clid,
            'ciudad' => $ciu,
            'estado' => $esta
        ]);
        return $response->object();
    }
}
