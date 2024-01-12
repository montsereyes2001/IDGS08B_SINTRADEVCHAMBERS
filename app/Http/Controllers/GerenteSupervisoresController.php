<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\GerenteSupervisor;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class GerenteSupervisoresController extends Controller
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
        //Listamos todos las relaciones 
        return DB::select('call getGeren_sup_user()');
    }
    public function indexWeb(){
            return view('content.gerente.supervisoresGer',[
                'title' => 'Supervisores Asociados',
                'supervisores' => DB::select('call getSup_available()')
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
        $data = $request->only('correo_gerente', 'sup');
        $validator = Validator::make($data, [
            'correo_gerente' => 'required|max:50|string',
            'sup' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el gerente
        $queryGer = DB::select("call getGerente('$request->correo_gerente')");
        //buscamos el supervisor
        //Creamos la relacion en la BD
        $rel = GerenteSupervisor::create([
            'id_gerente' => $queryGer[0]->id,
            'id_supervisor' => $request->sup,
            'status' => 'Activo'
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Relacion registrada',
        //     'data' => $rel
        // ], Response::HTTP_OK);
        return view ('content.gerente.actions',[
            'list'=> DB::select('call getGeren_sup_user("'.$request->correo_gerente.'")'),
            'action'=>'read'
        ]);
        //return redirect()->route('gersupLista');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GerenteSupervisor  $rel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos la relacion
        $rel = GerenteSupervisor::find($id);
        //Si la relacion no existe devolvemos error no encontrado
        if (!$rel) {
            return response()->json([
                'message' => 'Relacion no encontrada.'
            ], 404);
        }
        //Si hay relacion lo devolvemos
        return $rel;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GerenteSupervisor  $rel
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id', 'id_sup','edit_ger');
        $validator = Validator::make($data, [
            'edit_id' => 'required|max:50|int',
            'id_sup' => 'required|max:50|int',
            'edit_ger' => 'required|max:90|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos al gerente
        // $query = DB::select("call getGerente_Sup('$request->correo_gerente','$request->correo_supervisor')");
        // $querySup = DB::select("call getSupervisor('$request->correo_nuevo_sup')");
        //Buscamos la relacion
        $rel = GerenteSupervisor::findOrfail($request->edit_id);
        //Actualizamos la relacion.
        $rel->update([
            'id_supervisor' => $request->id_sup,
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Relacion modificada correctamente',
        //     'data' => $rel
        // ], Response::HTTP_OK);
        return view ('content.gerente.actions',[
            'list'=> DB::select('call getGeren_sup_user("'.$request->edit_ger.'")'),
            'action'=>'read'
        ]);
        //return redirect()->route('gersupLista');
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GerenteSupervisor  $rel
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id','del_ger');
        $validator = Validator::make($data, [
            'del_id' => 'required|max:50|int',
            'del_ger' => 'required|max:90|string'
        ]);
        //sp para buscar la relacion
        //$query=DB::select("call getGerente_Sup('$request->correo_gerente', '$request->correo_supervisor')");
        //Buscamos la relacion
        $rel = GerenteSupervisor::findOrfail($request->del_id);
        //Eliminamos la relacion
        $rel->delete();
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'Relacion eliminada correctamente'
        // ], Response::HTTP_OK);
        //return redirect()->route('gersupLista');
        return view ('content.gerente.actions',[
            'list'=> DB::select('call getGeren_sup_user("'.$request->del_ger.'")'),
            'action'=>'read'
        ]);
    }
    public function getCorreo(Request $request){
        $data = $request->only('correo');
        $validator = Validator::make($data, [
            'correo' => 'required|max:80|string'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $correo = $request->correo;
        return view ('content.gerente.actions',[
            'list'=> DB::select('call getGeren_sup_user("'.$request->correo.'")'),
            'action'=>'read'
        ]);
    }
}
