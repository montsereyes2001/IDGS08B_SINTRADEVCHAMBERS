<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupLiderWebController extends Controller
{
    //
    public function index(){
        $url = env('DIR_ROOT')."suplid/list";
        $response = Http::get($url);
        return $response->object();
    }

    public function store($csup, $clid){
        $url = env('DIR_ROOT')."suplid/reg";
        $response = Http::post($url,[
            "correo_supervisor" => $csup,
            "correo_lider" => $clid,
        ]);
        return $response->object();
    }

    public function update($csup, $clid, $cnlid){
        $url = env('DIR_ROOT')."suplid/updt";
        $response = Http::put($url, [
            'correo_supervisor' => $csup,
            'correo_lider' => $clid,
            'correo_nuevo_lider' => $cnlid
        ]);
        return $response->object();
    }

    public function destroy($csup, $clid){
        $url = env('DIR_ROOT')."suplid/del";
        $response = Http::delete($url, [
            'correo_supervisor' => $csup,
            'correo_lider' => $clid
        ]);
        return $response->object();
    }
}
