<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Trabajo;
use App\Models\User;
use App\Models\TipoTrabajo;
use App\Models\Invitado;
use App\Models\Cliente;
use App\Models\Lider;
use App\Models\Bitacora;
use App\Models\Rama;

class OwnerController extends Controller
{
    //
    // public function index(){
    //     return view ('content.administrador.usuarios',[
    //         "title" => "Ver Usuarios",
    //         "response" => self::list()
    //     ]);
    // }
    public function inicio(){
        return view('content.owner.inicio',[
            'title'=>'Dashboard | Inicio',
            'trabajos'=> self::trabajos(),
            'tipoT'=> self::tipoT(),
            'sp'=> DB::select('call getTipotrab()')
        ]);
    }
    public function trabajos(){
        return Trabajo::where('trabajos.status', '=','Activo')->get(['id','nombre']);
    }
    public function tipoT(){
        $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")
        ->where('tipo_trabajos.status', '=','Activo')
        ->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        return $tipoT;
    }
    public function admin(){
        return view ('content.owner.admin',[
            "title" => "Dashboard | Administradores",
            "response" => DB::select("call getAdmin_user()"),
            "usuarios" => User::get(),
            'trabajos'=> self::trabajos(),
            'tipoT'=> self::tipoT(),
        ]);
    }
    public function ger(){
        return view ('content.owner.gerentes',[
            "title" => "Dashboard | Gerentes",
            "response" => DB::select("call getGerente_user()"), 
            "usuarios" => User::get(),
            'trabajos'=> self::trabajos(),
            'tipoT'=> self::tipoT(),
        ]);
    }
    public function sup(){
        return view('content.owner.supervisor',[
            'title' => 'Dashboard |Supervisores',    
            'response' => DB::select('call getSup_Admin()'),
            'supervisores' => DB::select('call getInicio_admin()'),
            'trabajos'=> self::trabajos(),
            'tipoT'=> self::tipoT(),
        ]);
    }
    public function lid(){
        //select concat(us.nombre, ' ',us.apellido_paterno) as nombre, lideres.id_usuario, lideres.created_at, lideres.updated_at from lideres
// join usuarios as us on lideres.id_usuario = us.id;
        $lideres = Lider::join("usuarios as us", "lideres.id_usuario", "=", "us.id")
        ->get(['lideres.id',DB::raw('CONCAT(us.nombre, " ",us.apellido_paterno) as nombre'),'us.estado','us.id as idUs', 'lideres.created_at', 'lideres.updated_at']);
        return view('content.owner.lideres',[
            'title' => 'Dashboard | Lideres',
            'response' => User::get(),
            // 'lideres' => DB::select('call getInicio_admin()'),
            'lideres'=>$lideres,
            'trabajos'=> self::trabajos(),
            'tipoT'=> self::tipoT(),
            'relacion' =>  DB::select('call getLider_admin()'),
        ]);
    }
    public function rama(){
        return view ('content.owner.ramas',[
            "title" => "Dashboard | Ramas",
            "response" => DB::select("call getRamas_invitado"), 
            "invitados" => Invitado::get(),
            "clientes" => Cliente::get(),
            'trabajos'=> self::trabajos(),
            'tipoT'=> self::tipoT(),
        ]);
    }

    public function gersup(){
          return view('content.owner.gersup',[
            'title' => 'Dashboard |Supervisores',    
            'response' => DB::select('call getSup_Admin()'),
            'supervisores' => DB::select('call getInicio_admin()'),
            'trabajos'=> self::trabajos(),
            'tipoT'=> self::tipoT(),
        ]);
    }

    public function suplider(){
        return view('content.owner.suplider',[
            'title' => 'Dashboard | Lideres',
            'response' => User::get(),
            'lideres' => DB::select('call getInicio_admin()'),
            'trabajos'=> self::trabajos(),
            'tipoT'=> self::tipoT(),
             'relacion' =>  DB::select('call getLider_admin()'),
        ]);
    }

    public function selects(){
        $ubicaciones=Bitacora::select('ciudad','estado')->distinct()->orderby('estado')->get();
        $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->where('tipo_trabajos.status', 'Activo')->where('t.status','Activo')->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        return view('content.owner.registros',[
            'title'=>'Bitacoras',
            'ramas'=>Rama::where('ramas.status', 'Activo')->orderby('id')->get(),
            'lideres' => DB::select('call getLider_user()'),
            'tipoT'=>$tipoT,
            'trabajos'=>Trabajo::select('id','nombre')->get(),
            'ubicaciones'=>$ubicaciones,
        ]);

    }

    public function query(Request $request)
    {
        $data = $request->only('lider', 'rama','status','ciudad', 'estado',  'trabajo', 'fecha1', 'fecha2');
        $validator = Validator::make($data, [
            'lider' => 'string|nullable',
            'rama' => 'string|nullable',
            'trabajo' => 'string|nullable',
            'status' => 'string|nullable',
            'ciudad' => 'string|nullable',
            'estado' => 'string|nullable',
            'fecha1' => 'string',
            'fecha2' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(),], 400);
        }
        //Bucamos el bitacoras
        // $us = User::where('id','=', $request->correo)->get();
        $bit = DB::select('call getBitacora_filtrotodo("'.$request->lider.'", "'.$request->fecha1.'", "'.$request->fecha2.'", "'.$request->estado.'","'.$request->ciudad.'", "'.$request->status.'", "'.$request->trabajo.'", "'.$request->rama.'")');
        //Si el bitacora no existe devolvemos error no encontrado
        // return $bit;
        return $bit;
    }

    public function tipotrab(Request $request, $trabajo){
        $ubicaciones=Bitacora::select('ciudad','estado')->get();
        $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        return view('content.owner.tipotrab',[
            'title' => 'Tipos de trabajo',
            'response' => DB::select('call getBitacora_filtroOwnerTrabajos("'.$trabajo.'")'),
            'trabajoTipo' => $trabajo,
            'ramas'=>Rama::get(),
            'lideres' => DB::select('call getLider_user()'),
            'tipoT'=>$tipoT,
            'trabajos'=>Trabajo::select('id','nombre')->get(),
            'ubicaciones'=>$ubicaciones,
        ]);

    }

    
    
}
