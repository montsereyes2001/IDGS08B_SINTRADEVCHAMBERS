<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Models\Gerente;
use App\Models\GerenteSupervisor;
use App\Models\Bitacora;
use App\Models\TipoTrabajo;
use App\Models\Rama;
use App\Models\Lider;
use App\Models\Icono;
use App\Models\User;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use JWTAuth;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SupervisoresController extends Controller
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
         //Listamos todos los Supervisores
        return DB::select('call getSup_Admin()');
    }
    public function getUsuariosSinRol()
    {
        return DB::select('call getInicio_admin()');
    }
    public function getGerenteUsuario(){
        return DB::select('call getGerente_user()');
    }
    public function indexWeb(){
        return view('content.administrador.supervisorAdmin',[
            'title' => 'Dashboard | Supervisores',
            'response' => self::index(),
            'supervisores' => self::getUsuariosSinRol(),
            'gerentes'=>self::getGerenteUsuario()
                
        ]);
    }

    public function storeWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('supervisor', 'gerente');
        $validator = Validator::make($data, [
            'supervisor' => 'required|int',
            'gerente' => 'nullable|int',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $query = $request->supervisor;
        if ($request->gerente != null || $request->gerente != "") {
            
            //Creamos el supervisor en la BD
            $sup = Supervisor::create([
                'id_usuario' => $query,
                'estado' => 'Activo',
                'created_at'=> Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);
            // $idBit = $bit->id;
            $idSup = $sup->id;

            $supger = GerenteSupervisor::create([
                'id_gerente' => $request->gerente,
                'id_supervisor' => $idSup,
                'status' => 'Activo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ]);
            //Respuesta en caso de que todo vaya bien.
            return redirect()->route('supervisoresAdmin')->with('message', 'Supervisor agregado correctamente');
        }else{
            $sup = Supervisor::create([
                'id_usuario' => $query,
                'estado' => 'Activo',

            ]);
            return redirect()->route('supervisoresAdmin')->with('message', 'Supervisor agregado correctamente');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supervisor  $sup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el supervisor
        $sup = Supervisor::find($id);
        //Si el supervisor no existe devolvemos error no encontrado
        if (!$sup) {
            return response()->json([
                'message' => 'Supervisor no encontrado.'
            ], 404);
        }
        //Si hay supervisor lo devolvemos
        return $sup;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supervisor  $sup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validación de datos
        $data = $request->only('correo', 'nuevo_estado');
        $validator = Validator::make($data, [
            'correo' => 'required|max:50|string',
            'nuevo_estado' => 'required|max:50|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //sp para traer el idusuario del lider
        $query=DB::select("call getSupervisor('$request->correo')");
        //Buscamos el supervisor
        $sup = Supervisor::findOrfail($query[0]->id);
        //Actualizamos el supervisor.
        $sup->update([
            'estado' => $request->nuevo_estado,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Supervisor modificado correctamente',
            'data' => $sup
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supervisor  $sup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Validamos los datos
        $data = $request->only('correo');
        $validator = Validator::make($data, [
            'correo' => 'required|max:70|string',
        ]);
        //sp para traer el idusuario del supervisor
        $query=DB::select("call getSupervisor('$request->correo')");
        //Buscamos el supervisor
        $sup = Supervisor::findOrfail($query[0]->id);
        //Eliminamos el supervisor
        $sup->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Supervisor eliminado correctamente'
        ], Response::HTTP_OK);
    }
    

    /*---------------------------------WEB--------------------------------------*/
    public function store(Request $request)
    {
        //Validamos los datos
        $data = $request->only('sup', 'edo');
        $validator = Validator::make($data, [
            'sup' => 'required|max:50|int',
            'edo' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $sup = Supervisor::create([
            'id_usuario' => $request->sup,
            'estado' => $request->edo,
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Supervisor registrado',
        //     'data' => $sup
        // ], Response::HTTP_OK);
        return redirect()->route('supervisoresAdmin');
    }

    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('id_sup', 'relacion','id_ger');
        $validator = Validator::make($data, [
            'id_sup' => 'int|required',
            'relacion' => 'int|nullable',
            'id_ger' => 'int|nullable',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        // dd($request->id_ger);
        //sp para traer el idusuario del lider
        // $query=DB::select("call getSupervisor('$request->correo')");
        // $query = Supervisor::join('usuarios', 'supervisores.id_usuario', '=', 'usuarios.id')
        //     ->where('supervisores.id', '=', $request->id_sup)
        //     ->select('supervisores.id')
        //     ->get();
        
        //Buscamos el supervisor
        $sup = GerenteSupervisor::findOrfail($request->relacion);
        //Actualizamos el supervisor.
        $sup->update([
            'id_gerente' => $request->id_ger ? $request->id_ger : null,
        ]);
        //Devolvemos los datos actualizados.
        return redirect()->route('supervisoresAdmin')->with('message', 'Gerente actualizado correctamente');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supervisor  $sup
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('id_sup');
        $validator = Validator::make($data, [
            'id_sup' => 'int|required',
        ]);
        // //sp para traer el idusuario del supervisor
        // $query=DB::select("call getSupervisor('$request->correo')");
        // //Buscamos el supervisor
        $sup = Supervisor::findOrfail($request->id_sup);
        //Eliminamos el supervisor
        $sup->update([
            'estado'=>'Inactivo',
        ]);
        
        //Devolvemos la respuesta
        return redirect()->route('supervisoresAdmin')->with('messageDelete', 'Supervisor eliminado correctamente');
    }

    public function selectsSup(){
        $ubicaciones=Bitacora::select('ciudad','estado')->distinct()->orderby('estado')->get();
        $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->where('tipo_trabajos.status', 'Activo')->where('t.status','Activo')->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        return view('content.supervisor.registrosSup',[
            'title'=>'Bitacoras',
            'ramas'=>Rama::where('ramas.status', 'Activo')->orderby('id')->get(),
            'lideres' => DB::select('call getLider_user()'),
            'tipos'=>$tipoT,
            'trabajos'=>Trabajo::select('id','nombre')->get(),
            'ubicaciones'=>$ubicaciones,
        ]);

    }
    public function querySup(Request $request)
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


 