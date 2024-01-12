<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InvitadosWebController extends Controller
{
    //
    public function inicio(){
        return view('content.administrador.invitadosAdmin',[
            'response'=>self::index(),
            'title'=>'Lista invitados'
        ]);
    }

    public function index(){
        $url = env('DIR_ROOT')."inv/list";
        $response = Http::get($url);
        return $response->object();
    }

    public function store(Request $request){
        $url = env('DIR_ROOT')."inv/reg";
        $response = Http::post($url,[
            "nombre" => $request->nom,
            "password" => $request->pass,
            "estado" => $request->est,
        ]);
        return $response->object();
    }

    public function update(Request $request){
        $url = env('DIR_ROOT')."inv/updt";
        $response = Http::put($url, [
            'nombre_invitado' => $request->nom,
            'password' => $request->pass,
            'estado' => $request->est
        ]);
        return $response->object();
    }

    public function destroy(Request $request){
        $url = env('DIR_ROOT')."inv/del";
        $response = Http::delete($url, [
            'nombre' => $request->nom
        ]);
        return $response->object();
    }
}
