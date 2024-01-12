<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GerenteSupWebController extends Controller
{
    //
    public function index(){
        $url = env('DIR_ROOT')."gersup/list";
        $response = Http::get($url);
        return $response->object();
    }

    public function store($cger, $csup, $est){
        $url = env('DIR_ROOT')."gersup/reg";
        $response = Http::post($url, [
            'correo_gerente'=> $cger,
            'correo_supervisor' => $csup,
            'estatus' => $est,
        ]);
        return $response->object();
    }

    public function update($cger, $csup, $cnsup){
        $url = env('DIR_ROOT')."gersup/updt";
        $response = Http::put($url, [
            'correo_gerente'=> $cger,
            'correo_supervisor' => $csup,
            'correo_nuevo_supervisor' => $cnsup,
        ]);
        return $response->object();
    }

    public function destroy($cger, $csup){
        $url = env('DIR_ROOT')."gersup/del";
        $response = Http::delete($url, [
            'correo_gerente' => $cger,
            'correo_supervisor' => $csup
        ]);
        return $response->object();
    }
}
