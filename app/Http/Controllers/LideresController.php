<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Lider;
use App\Models\SupervisorLider;
use App\Models\Supervisor;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LideresController extends Controller
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
        //Listamos todos los lideres
        return DB::select('call getLider_admin()');
    }

    public function getUsuariosSinRol()
    {
        return DB::select('call getInicio_admin()');
    }
    public function getSupervisoresUsuario(){
        return DB::select('call getSup_user()');
    }
    public function indexWeb(){
        return view('content.administrador.lideresAdmin',[
            'title' => 'Dashboard | Lideres',
            'response' => self::index(),
            'lideres' => self::getUsuariosSinRol(),
            'supervisores' =>self::getSupervisoresUsuario()
                
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
        $data = $request->only('correo', 'estado');
        $validator = Validator::make($data, [
            'correo' => 'required|max:50|string',
            'estado' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        };
        //sp para traer el idusuario del lider
        $query=DB::select("call getUsuario('$request->correo')");
        //Creamos el lider en la BD
        $leader = Lider::create([
            'id_usuario' => $query[0]->id,
            'estado' => $request->estado,
            
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Lider regisrado correctamente',
            'data' => $leader
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lider  $leader
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos al lider
        $leader = Lider::find($id);
        //Si el lider no existe devolvemos error no encontrado
        if (!$leader) {
            return response()->json([
                'message' => 'Lider no encontrado'
            ], 404);
        }
        //Si hay lider lo devolvemos
        return $leader;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lider  $leader
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
        $query=DB::select("call getLider('$request->correo')");
        //Buscamos el lider
        $leader = Lider::findOrfail($query[0]->id);
        //Actualizamos el lider.
        $leader->update([
            'estado' => $request->nuevo_estado,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Los datos del lider se modificaron',
            'data' => $leader
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lider  $leader
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Validamos los datos
        $data = $request->only('correo');
        $validator = Validator::make($data, [
            'correo' => 'required|max:70|string',
        ]);
        //sp para traer el idusuario del lider
        $query=DB::select("call getLider('$request->correo')");
        //Buscamos al lider
        $leader = Lider::findOrfail($query[0]->id);
        //Eliminamos el lider
        $leader->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'El lider fue eliminado correctamente'
        ], Response::HTTP_OK);
    }
    public function prueba(Request $request){
        //Validación de datos
        $data = $request->only('correo');
        $validator = Validator::make($data, [
            'correo' => 'required|max:70|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $product = DB::select("call getUsuario('$request->correo')");
        
        return response()->json([
            'consulta'=> $product,
            'id' => $product[0]->id
        ]);
    }
    
    /*---------------------------------WEB--------------------------------------*/
    public function storeWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('lid');
        $validator = Validator::make($data, [
            'lid' => 'required|max:50|string'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $sup = Lider::create([
            'id_usuario' => $request->lid,
            'estado' => 'Activo',
            
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Supervisor registrado',
        //     'data' => $sup
        // ], Response::HTTP_OK);
        return redirect()->route('listaLideresAdmin');
    }


    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('id_lid', 'sup', 'relacion');
        $validator = Validator::make($data, [
            'sup' => 'int|nullable',
            'id_lid' => 'int|required',
            'relacion' => 'int|nullable'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //buscamos el supervisor
        //$querySup = DB::select("call getSup_Lider('$request->correo_supervisor','$request->correo_lider')");
        //Buscamos la relacion
        $rel = SupervisorLider::findOrfail($request->relacion);
        //Actualizamos la relacion.
        $rel->update([
            // 'correo_lider' => $request->correo_lider,
            'id_supervisor' => $request->sup ? $request->sup : null,
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Relacion modificada correctamente',
        //     'data' => $rel
        // ], Response::HTTP_OK);
        //return redirect()->route('suplidLista');
        return redirect()->route('listaLideresAdmin')->with('message', 'Supervisor actualizado correctamente');
    }

    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('id_lid');
        $validator = Validator::make($data, [
            'id_lid' => 'int|required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Buscamos el supervisor
        $sup = Lider::findOrfail($request->id_lid);
        //Eliminamos el supervisor
        $sup->update([
            'estado' => 'Inactivo',
        ]);

        //Devolvemos la respuesta
        return redirect()->route('listaLideresAdmin')->with('messageDelete', 'Lider eliminado correctamente');
    }
}
