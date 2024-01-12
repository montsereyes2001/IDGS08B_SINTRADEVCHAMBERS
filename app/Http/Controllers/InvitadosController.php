<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Invitado;
use App\Models\Bitacora;
use App\Models\TipoTrabajo;
use App\Models\Rama;
use App\Models\Lider;
use App\Models\Icono;
use App\Models\User;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class InvitadosController extends Controller
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
    public function inicio(){
        return view('content.invitado.inicio');
    }
    public function index()
    {
        //Listamos todos los Invitados
        return Invitado::where('estado', 'Activo')->get();
    }
    public function indexWeb(){
        return view ('content.administrador.invitadosAdmin',[
            "title" => "Dashboard | Invitados",
            "response" => self::index()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre', 'password', 'estado');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:50|string',
            'password' => 'required|min:6|max:10|string',
            'estado' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        
        //Creamos el invitado en la BD
        $inv = Invitado::create([
            'nombre' => $request->nombre,
            'password' => bcrypt($request->password),
            'estado' => $request->estado,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Invitado registrado',
            'data' => $inv
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invitado  $inv
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos al invitado
        $inv = Invitado::find($id);
        //Si el invitado no existe devolvemos error no encontrado
        if (!$inv) {
            return response()->json([
                'message' => 'Invitado no encontrado.'
            ], 404);
        }
        //Si hay invitado lo devolvemos
        return $inv;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invitado  $inv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validación de datos
        $data = $request->only('nombre_invitado', 'password', 'estado');
        $validator = Validator::make($data, [
            'nombre_invitado' => 'required|max:50|string',
            'password' => 'required|min:6|max:50|string',
            'estado' => 'required|max:50|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el invitado
        $inv = Invitado::where('nombre',$request->nombre_invitado)->firstOrFail();
        //Actualizamos el invitado.
        $inv->update([
            'password' => $request->password,
            'estado' => $request->estado,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Invitado modificado correctamente',
            'data' => $inv
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invitado  $inv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
         //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el invitado
        $inv = Invitado::where('nombre', $request->nombre)->firstOrFail();
        //Eliminamos el invitado
        $inv->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Invitado eliminado correctamente'
        ], Response::HTTP_OK);
    }
    public function prueba(Request $request){
        $data = $request->only('nombre_invitado');
        $validator = Validator::make($data, [
            'nombre_invitado' => 'required|max:70|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        // $inv = Invitado::where('nombre',$request->nombre_invitado)->firstOrFail();
        $inv = DB::select("call getInvitado('$request->nombre_invitado')");
        return response()->json([
            'datos'=>$inv
        ]);
    }

    public function RegisterWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre', 'password', 'estado');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:500|string',
            'password' => 'required|min:6|max:10|string',
            'estado' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        
        //Creamos el invitado en la BD
        $inv = Invitado::create([
            'nombre' => $request->nombre,
            'password' => bcrypt($request->password),
            'estado' => $request->estado,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return redirect()->route('invitadoAdmin');
    }
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id', 'estado');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'estado' => 'required|max:50|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el invitado
        $inv = Invitado::findOrfail($request->edit_id);
        //Actualizamos el invitado.
        $inv->update([
            'estado' => $request->estado,
        ]);
        //Devolvemos los datos actualizados.
        return redirect()->route('invitadoAdmin');  }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invitado  $inv
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
         //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el invitado
        $inv = Invitado::findOrfail($request->del_id);
        //Eliminamos el icono
        $inv->update(['estado'=> 'Inactivo']);
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'Invitado eliminado correctamente'
        // ], Response::HTTP_OK);
        return redirect()->route('invitadoAdmin');
    }
    public function selectsInvitado(){
        $ubicaciones=Bitacora::select('ciudad','estado')->distinct()->orderby('estado')->get();
        $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->where('tipo_trabajos.status', 'Activo')->where('t.status','Activo')->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        return view('content.invitado.inicio',[
            'title'=>'Registros de la bitácora',
            'ramas'=>Rama::where('ramas.status','Activo')->orderby('id')->get(),
            'lideres' => Lider::where('estado', 'Activo')->get(),
            'tipos'=>$tipoT,
            'trabajos'=>Trabajo::select('id','nombre')->where('status','Activo')->get(),
            'ubicaciones'=>$ubicaciones,
        ]);
    }

    public function queryInvitado(Request $request)
    {
        $data = $request->only('correo', 'rama','status','ciudad', 'estado',  'trabajo', 'fecha1', 'fecha2');
        $validator = Validator::make($data, [
            'correo' => 'string',
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
        $bit = DB::select('call getBInv_filtrotodo("'.$request->correo.'", "'.$request->fecha1.'", "'.$request->fecha2.'", "'.$request->rama.'","'.$request->status.'", "'.$request->trabajo.'", "'.$request->ciudad.'", "'.$request->estado.'")');
        // return $bit;
        return $bit;
    }
}
