<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Invitado;
use App\Models\Rama;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class RamasController extends Controller
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
        //Listamos todas las ramas
        return DB::select("call getRamas_invitado()");
    }
    public function indexWeb(){
          return view ('content.administrador.ramasAdmin',[
            "title" => "Dashboard | Ramas",
            "response" => self::index(), 
            "invitados" => Invitado::where('estado', 'Activo')->get(),
            "clientes" => Cliente::where('status', 'Activo')->get()
        ]);
    }
     public function indexWebGerente(){
          return view ('content.gerente.ramasGer',[
            "title" => "Dashboard | Ramas",
            "response" => self::index(), 
            "invitados" => Invitado::get(),
            "clientes" => Cliente::get()
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
        $data = $request->only('nombre', 'cliente', 'nombre_invitado');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:50|string',
            'cliente' => 'required|max:50|string',
            'nombre_invitado' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $queryInv = DB::select("call getInvitado('$request->nombre_invitado')");
         //Creamos la rama en la BD
        $branch = Rama::create([
            'nombre' => $request->nombre,
            'cliente' => $request->cliente,
            'id_invitado' => $queryInv[0]->id,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Rama registrada',
            'data' => $branch
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rama  $branch
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos la rama
        $branch = Rama::find($id);
        //Si la rama no existe devolvemos error no encontrado
        if (!$branch) {
            return response()->json([
                'message' => 'Rama no encontrada.'
            ], 404);
        }
        //Si hay rama la devolvemos
        return $branch;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rama  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validación de datos
        $data = $request->only('nombre_rama', 'nuevo_nombre', 'cliente', 'nombre_invitado');
        $validator = Validator::make($data, [
            'nombre_rama' => 'required|max:50|string',
            'nuevo_nombre' => 'required|max:50|string',
            'cliente' => 'required|max:50|string',
            'nombre_invitado' => 'required|max:50|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //qeury rama
        $queryRama = DB::select("call getRama('$request->nombre_rama')");
        //query invitado
        $queryInv = DB::select("call getInvitado('$request->nombre_invitado')");
        //Buscamos la rama
        $branch = Rama::findOrfail($queryRama[0]->id);
        //Actualizamos la rama.
        $branch->update([
            'nombre' => $request->nuevo_nombre,
            'cliente' => $request->cliente,
            'id_invitado' => $queryInv[0]->id
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Rama modificada correctamente',
            'data' => $branch
        ], Response::HTTP_OK);
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rama  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre_rama');
        $validator = Validator::make($data, [
            'nombre_rama' => 'required|max:70|string',
        ]);
        //sp para traer el idusuario del lider
        $query=DB::select("call getRama('$request->nombre_rama')");
        //Buscamos la rama
        $branch = Rama::findOrfail($query[0]->id);
        //Eliminamos la rama
        $branch->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Rama eliminada correctamente'
        ], Response::HTTP_OK);
    }


    /*-------------------------------------WEB-----------------------------------*/

    public function storeWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre', 'id_cliente', 'id_invitado');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:50|string',
            'id_cliente' => 'required|max:50|string',
            'id_invitado' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
         //Creamos la rama en la BD
        //$queryInv = DB::select("call getInvitado('$request->nombre_invitado')");
          
        $branch = Rama::create([
            'nombre' => $request->nombre,
            'id_cliente' => $request->id_cliente,
            'id_invitado' => $request->id_invitado,
            'status' => 'Activo'

        ]);
        //Respuesta en caso de que todo vaya bien.
         // return view ('content.administrador.ramasAdmin');
         return redirect()->route('ramasAdmin');
    }



    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id','nombre', 'id_cliente', 'id_invitado');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'nombre' => 'required|max:50|string',
            'id_cliente' => 'required|int',
            'id_invitado' => 'required|int',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $branch = Rama::findOrfail($request->edit_id);
        $branch->update([
            'nombre' => $request->nombre,
            'id_cliente' => $request->id_cliente,
            'id_invitado' => $request->id_invitado,
        ]);
        //Devolvemos los datos actualizados.
        return redirect()->route('ramasAdmin');
    }
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'nombre_rama' => 'required|max:70|string',
        ]);
        
        $branch = Rama::findOrfail($request->del_id);
        //Eliminamos la rama
        $branch->update(['status'=> 'Inactivo']);
        //Devolvemos la respuesta
        return redirect()->route('ramasAdmin');
    }
}

