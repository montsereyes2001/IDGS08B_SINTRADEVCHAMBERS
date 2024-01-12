<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;
use App\Models\Invitado;
use App\Models\User;
use App\Models\Gerente;
use App\Models\Supervisor;
use App\Models\Lider;
use App\Models\Administrador;
use Illuminate\Support\Facades\Validator;

class UsuariosWebController extends Controller
{
    public function logout(){
        return view('logout');
    }
    public function error(){
        return view('noAutorizado');
    }
    //
    // public function index(){
    //     return view ('content.administrador.usuarios',[
    //         "title" => "Ver Usuarios",
    //         "response" => self::list()
    //     ]);
    // }
    public function inicioSup(){
        return view('content.supervisor.inicio',[
            "title" => "Dashboard | Inicio",
        ]);
    }
    public function inicioLider(){
        return view('content.lider.inicio',[
            "title" => "Dashboard | Inicio",
        ]);
    }
    public function inicioAdmin(){
        return view('content.administrador.inicioAdmin',[
            "title" => "Dashboard | Usuarios en espera",
            "response" => self::index()
        ]);
    }

    
    public function list(){
        $url = env('DIR_ROOT')."users/listaUs";
        $response = Http::post($url);
        return $response->object();
    }
    public function lista(){
        $url = env('DIR_ROOT')."users/listaUs";
        $response = Http::post($url);
        return $response->object();
    }
    public function SidebarAdmin(){
        return view ('content.administrador.usuarios',[
            "title" => "Dashboard | Usuarios",
            "response" => self::lista()
        ]);
    }
    public function logApi(Request $request){
        $url = env('DIR_ROOT')."users/login";
        $response = Http::post($url,[
            "correo"=>$request->correo,
            "password"=>$request->password
        ]);
        $queryInv = Invitado::where('nombre', $request->correo)->select('estado')->first();
        if (isset($response['error']['password']) ){
            return redirect()->route('login')->with("messageL", "Por favor ingrese una contraseña");
        }elseif(isset($response['error']['correo'])){
            return redirect()->route('login')->with("messageL", "Por favor ingrese un correo");
        }elseif(isset($response['message'])&&is_null($queryInv)){
            return redirect()->route('login')->with("messageL", "El correo o la contraseña no coinciden con los datos registrados");
        }elseif(isset($response['message'])&&!is_null($queryInv)){
            // header('Location: http://127.0.0.1:8000/login?message=2');//correo no existe
            // die();
            switch($queryInv->estado){
                case 'Activo':
                    return view('content.invitado.dash',[
                        'correoUs' => $request->correo,
                        'tipoUs'=>'Invitado',
                        'estatusUsuario' => $queryInv->estado,
                        'title' => 'Vista invitados',
                        'invitados'=> DB::select("call getBInv('$request->correo')")
                    ]);
                    break;
                case 'Inactivo':
                    return view('error',[
                        'correoUs' => $request->correo,
                        'tipoUs'=>'Invitado',
                        'estatusUsuario' => $queryInv->estado,
                        'title' => 'Vista invitados',
                        'message'=>'Gracias por registrarte, espera la validación de un administrador'
                    ]);
                    break;
            }
        }else{
            $valCorreo = self::valCorreo($request->correo);
            // return $valCorreo;
            switch($valCorreo){
                case "Activo":
                    $q = self::valTipoUs($request->correo,$response, $valCorreo);
                    return $q;
                case 'Inactivo':
                    //mensaje de validacion del administrador
                    return view('error',[
                        'response' => $response,
                        'tipoUs'=>'NA',
                        'estatusUsuario' => $valCorreo,
                        'title' => 'Espera validacion',
                        'message' => 'Por favor espere la autenticacion de un administrador'
                    ]);
                }
            }
        }
    
    public function Login(){
        return view('login');
    }

    public function Registro(){
        return view('registro');
    }
    public function registroLog(Request $request){
        $url= env('DIR_ROOT').'users/registro';
        $response = Http::post($url,[
            'nombre'=>$request->nombre,
            'apellido_paterno' => $request->ap_pat,
            'apellido_materno' => $request->ap_mat,
            'correo'=>$request->correo,
            'telefono'=>$request->tel,
            'estado'=>'Inactivo',
            'password' => $request->pass
        ]);
        if ((isset($response['error']['password'])) || isset($response['error']['correo']) || isset($response['error']['apellido_paterno']) || isset($response['error']['apellido_materno']) || isset($response['error']['telefono'])){
            header('Location: '.env('URL').'registro ');//ruta de error en login
            die();
        }else{
            header('Location: '.env('URL').'login ');
            die();
        }
    }

    public function valCorreo($correo){
        $queryUs = DB::select("call getUsuario('$correo')");
        if(empty($queryUs)){
            return 'el correo no esta registrado';
        }
        else{
            $queryStatus = Usuario::find($queryUs[0]->id, ['estado']);//inactivo en tabla usuarios
            if($queryStatus['estado']=='Activo'){
                return $queryStatus['estado'];
            }else{
                return 'Inactivo';
            }
        }
    }

    public function valTipoUs($correo, $response, $status){
        $queryAdmin = DB::select("call getAdmin('$correo')");
        $queryLid = DB::select("call getLider('$correo')");
        $querySup = DB::select("call getSupervisor('$correo')");
        $queryGer = DB::select("call getGerente('$correo')");
        $queryInv = DB::select("call getBInv('$correo')");
        //$listaGer = DB::select("call getGeren_sup_user('$correo')");
        if($correo == env('CORREO_EB')){
            return view('content.owner.dash',[
                'response'=>$response,
                'tipoUs'=>'CEO',
                'estatusUsuario'=>$status,
                ]);
        }else{
            if ((is_null($queryAdmin) || empty($queryAdmin))){
                if (is_null($queryGer) || empty($queryGer)){
                    if(is_null($querySup) || empty($querySup)){
                        if(is_null($queryLid) || empty($queryLid)){
                            return view('error',[
                                'response'=>$response,
                                'tipoUs'=>'NA',
                                'estatusUsuario'=>$status,
                                'message'=>'Gracias por registrarte, por favor espera la validacion de un administrador'//estado inactivo en tabla de rol
                                ]);
                            // return $queryStatus['estado'];
                        }else{
                            $statusLid = Lider::find($queryLid[0]->id, 'estado');
                            if($statusLid->estado == 'Activo'){
                                return view('content.lider.dash',[
                                    'title'=>'Dashboard | JosCir Company & Associates',
                                    'response'=>$response,
                                    'tipoUs'=>'Lider',
                                    'estatusUsuario'=>$status
                                    ]);
                            }else{
                                return view('error',[
                                    'response'=>$response,
                                    'tipoUs'=>'NA',
                                    'estatusUsuario'=>$statusLid->estado,
                                    'message'=>'Su usuario esta inactivo, si desea ingresar al sistema contacte a un administrador'//estado inactivo en tabla de rol
                                    ]);
                            }
                        }
                    }else{
                        $statusSup = Supervisor::find($querySup[0]->id, 'estado');
                        if($statusSup->estado == 'Activo'){
                            return view('content.supervisor.dash',[
                                'title'=>'Dashboard | JosCir Company & Associates',
                                'response'=>$response,
                                'tipoUs'=>'Supervisor',
                                'estatusUsuario'=>$status
                                ]);
                        }else{
                            return view('error',[
                                'response'=>$response,
                                'tipoUs'=>'Supervisor',
                                'estatusUsuario'=>$statusSup->estado,
                                'message'=>'Gracias por registrarte, por favor espera la validacion de un administrador'//estado inactivo en tabla de rol
                                ]);
                        }
                    }
                }else{
                    $statusGer = Gerente::find($queryGer[0]->id, 'estado');
                    if($statusGer->estado =='Activo'){
                        return view('content.gerente.dash',[
                            'title'=>'Dashboard | JosCir Company & Associates',
                            'response'=>$response,
                            'tipoUs'=>'Gerente',
                            'estatusUsuario'=>$status,
                            ]);
                    }else{
                        return view('error',[
                            'response'=>$response,
                            'tipoUs'=>'Gerente',
                            'estatusUsuario'=>$statusGer->estado,
                            'message'=>'Su usuario esta inactivo, si desea ingresar al sistema contacte a un administrador'//estado inactivo en tabla de rol
                            ]);
                    }
                }
            }else{
                $statusAdmin = Administrador::find($queryAdmin[0]->id, 'status');
                if($statusAdmin->status == 'Activo'){
                    return view('content.administrador.dash',[
                        'title'=>'Dashboard | JosCir Company & Associates',
                        'response'=>$response,
                        'tipoUs'=>'Administrador',
                        'estatusUsuario'=>$status,
                        ]);
                    }else{
                    return view('error',[
                        'response'=>$response,
                        'tipoUs'=>'Administrador',
                        'estatusUsuario'=>$statusAdmin->estado,
                        'message'=>'Su usuario esta inactivo, si desea ingresar al sistema contacte a un administrador'//estado inactivo en tabla de rol
                        ]);
                    }
                }
            }
        }
//OPCIONES INICIO ADMINISTRADOR
    
    public function index(){
        return DB::select("call getInicio_admin");
    }

    public function updateWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('edit_id', 'edo', 'rol');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'edo' => 'required|max:50|string',
            'rol' => 'required|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el icono
        //$query = DB::select(("call getIcono('$request->nombre_icono')"));
        $stat = User::findOrfail($request->edit_id);
        //Actualizamos el icono.
        $stat->update([
            'estado'=>$request->edo,
        ]);

        $rol = $request->rol;

        switch ($rol) {
            case "Administrador":
                $admin = Administrador::create([
                    'id_usuario' => $request->edit_id,
                    'status' => 'Activo'
                ]);
                break;
            case "Gerente":
                $manager = Gerente::create([
                    'id_usuario' => $request->edit_id,      
                    'estado' => 'Activo'
                ]);
                break;
            case "Supervisor":
                $sup = Supervisor::create([
                    'id_usuario' => $request->edit_id,
                    'estado' => 'Activo',
                ]);
                break;
            case "Lider":
                $leader = Lider::create([
                    'id_usuario' => $request->edit_id,
                    'estado' => 'Activo',
                ]);
                break;
        }
        
        return redirect()->route('inicioAdmin');
    }
    

}