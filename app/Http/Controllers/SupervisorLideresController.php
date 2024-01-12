<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\SupervisorLider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class SupervisorLideresController extends Controller
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
        return DB::select('call getSup_lider_user()');
    }
    public function indexWeb(){
        return view('content.supervisor.lideresSup',[
            'title' => 'Lideres Asociados',
            'lideres' => DB::select('call getLider_available()')
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
        $data = $request->only('correo_sup', 'lid');
        $validator = Validator::make($data, [
            'correo_sup' => 'required|max:50|string',
            'lid' => 'required|max:50|int',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el supervisor
        $querySup = DB::select("call getSupervisor('$request->correo_sup')");
        //Buscamos el lider
        //$queryLid = DB::select("call getLider('$request->correo_lider')");
        //Creamos la relacion en la BD
        $rel = SupervisorLider::create([
            'id_supervisor' => $querySup[0]->id,
            'id_lider' => $request->lid,
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Relacion registrada',
        //     'data' => $rel
        // ], Response::HTTP_OK);
        //return redirect()->route('suplidLista');
        return view ('content.supervisor.actions',[
            'list'=> DB::select('call getSup_lider_user("'.$request->correo_sup.'")'),
            'action'=>'read'
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SupervisorLider  $rel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos la relacion
        $rel = SupervisorLider::find($id);
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
     * @param  \App\Models\SupervisorLider  $rel
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id', 'id_lid','edit_sup');
        $validator = Validator::make($data, [
            'edit_id' => 'required|max:50|int',
            'id_lid' => 'required|max:50|int',
            'edit_sup' => 'required|max:90|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //buscamos el supervisor
        //$querySup = DB::select("call getSup_Lider('$request->correo_supervisor','$request->correo_lider')");
        //Buscamos la relacion
        $rel = SupervisorLider::findOrfail($request->edit_id);
        //Actualizamos la relacion.
        $rel->update([
            // 'correo_lider' => $request->correo_lider,
            'id_lider' => $request->id_lid,
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Relacion modificada correctamente',
        //     'data' => $rel
        // ], Response::HTTP_OK);
        //return redirect()->route('suplidLista');
        return view ('content.supervisor.actions',[
            'list'=> DB::select('call getSup_lider_user("'.$request->edit_sup.'")'),
            'action'=>'read'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SupervisorLider  $rel
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id','del_sup');
        $validator = Validator::make($data, [
            'del_id' => 'required|max:50|int',
            'del_sup' => 'required|max:90|string'
        ]);
        //sp para buscar la relacion
        //$query=DB::select("call getSup_Lider('$request->correo_supervisor', '$request->correo_lider')");
        //Buscamos la relacion
        $rel = SupervisorLider::findOrfail($request->del_id);
        //Eliminamos la relacion
        $rel->delete();
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'Relacion eliminada correctamente'
        // ], Response::HTTP_OK);
        //return redirect()->route('suplidLista');
        return view ('content.supervisor.actions',[
            'list'=> DB::select('call getSup_lider_user("'.$request->del_sup.'")'),
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
        return view ('content.supervisor.actions',[
            'list'=> DB::select('call getSup_lider_user("'.$request->correo.'")'),
            'action'=>'read'
        ]);
    }
}

