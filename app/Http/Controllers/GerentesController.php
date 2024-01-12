<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Gerente;
use App\Models\User;
use App\Models\Bitacora;
use App\Models\TipoTrabajo;
use App\Models\Rama;
use App\Models\Lider;
use App\Models\Icono;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GerentesController extends Controller
{
    //
    
    protected $user;
    public function __construct(Request $request)
    {
        $token = $request->header('Authorization');
        if($token != '')
            //En caso de que requiera autentifiación la ruta obtenemos el usuario y lo almacenamos en una variable, nosotros no lo utilizaremos.
            $this->user = JWTAuth::parseToken()->authenticate();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Listamos todos los gerentes
       return DB::select("call getGerente_user()");
    }
    public function indexWeb(){
        return view ('content.administrador.gerentesAdmin',[
            "title" => "Dashboard | Gerentes",
            "response" => self::index(), 
            "usuarios" => DB::select('call getInicio_admin()')
        ]);
    }

    public function inicio(){

        return view ('content.gerente.inicioGer',[
            "title" => "Dashboard | Gerentes"
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('user');
        $validator = Validator::make($data, [
            'user' => 'required|int',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //sp para traer el idusuario del gerente
        //$query=DB::select("call getUsuario('$request->correo')");
        //Creamos el gerente en la BD
        $user = User::findOrFail($request->user);
        $user->estado = 'Activo';
        $user->save();
        $manager = Gerente::create([
            'id_usuario' => $request->user,
            'estado' => 'Activo',
            
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Gerente registrado',
        //     'data' => $manager
        // ], Response::HTTP_OK);
        return redirect()->route('gerListAdmin');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gerente  $manager
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el gerente
        $manager = Gerente::find($id);
        //Si el gerente no existe devolvemos error no encontrado
        if (!$manager) {
            return response()->json([
                'message' => 'Gerente no encontrado.'
            ], 404);
        }
        //Si hay gerente lo devolvemos
        return $manager;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gerente  $manager
     * @return \Illuminate\Http\Response
     */

    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id', 'edo');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'edo' => 'required|max:50|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos a el gerente
        $manager = Gerente::findOrfail($request->edit_id);
        //Actualizamos el gerente.
        $manager->update([
            'estado' => $request->edo,
        ]);
        
        return redirect()->route('gerListAdmin');

    }
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
        $manager = Gerente::findOrfail($request->del_id);
        //Eliminamos el gerente
        $manager->update(['estado'=> 'Inactivo']);
        
        return redirect()->route('gerListAdmin');
    }

    public function registerWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('correo', 'estado');
        $validator = Validator::make($data, [
            'correo' => 'required|max:50|string',
            'estado' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //sp para traer el idusuario del gerente
        $query=DB::select("call getUsuario('$request->correo')");
        //Creamos el gerente en la BD
        $manager = Gerente::create([
            'id_usuario' => $query[0]->id,
            'estado' => $request->estado,
            
        ]);
        //Respuesta en caso de que todo vaya bien.
        return redirect()->route('gerListAdmin');
    }
    
    public function selectsGerente(){
        $ubicaciones=Bitacora::select('ciudad','estado')->distinct()->orderby('estado')->get();
        $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->where('tipo_trabajos.status', 'Activo')->where('t.status','Activo')->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        return view('content.gerente.registrosGerentes',[
            'title'=>'Bitacoras',
            'ramas'=>Rama::where('ramas.status', 'Activo')->orderby('id')->get(),
            'lideres' => DB::select('call getLider_user()'),
            'tipos'=>$tipoT,
            'trabajos'=>Trabajo::select('id','nombre')->get(),
            'ubicaciones'=>$ubicaciones,
        ]);

    }
    public function queryGerente(Request $request)
    {
        $data = $request->only('lider', 'rama','status','ciudad', 'estado',  'trabajo', 'fecha1', 'fecha2');
        $validator = Validator::make($data, [
            'lider' => 'string',
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
        $res['data'] = $bit;
        // return $bit;
        return $bit;
    }
}
