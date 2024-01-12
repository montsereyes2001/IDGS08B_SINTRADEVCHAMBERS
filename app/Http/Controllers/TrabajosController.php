<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\facades\Validator;
use Illuminate\Support\Facades\DB;

class TrabajosController extends Controller
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
    public function indexWeb()
    {
        //Listamos todos los jobos
        return view('content.administrador.trabajosAdmin',[
            "title" => "Dashboard | Trabajos",
            "response" => Trabajo::where('status', 'Activo')->get()
        ]);
        // return Trabajo::get();
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
        $data = $request->only('nombre');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el jobo en la BD
        $job = Trabajo::create([
            'nombre' => $request->nombre,
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Trabajo registrado correctamente',
        //     'data' => $job
        // ], Response::HTTP_OK);
         return redirect()->route('trabListAdmin');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Trabajo  $job
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el jobo
        $job = Trabajo::find($id);
        //Si el jobo no existe devolvemos error no encontrado
        if (!$job) {
            return response()->json([
                'message' => 'Trabajo no encontrado.'
            ], 404);
        }
        //Si hay jobo lo devolvemos
        return $job;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trabajo  $job
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id','nombre' );
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'nombre' => 'required|max:255|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el trabajo
        //$query = DB::select("call getTrabajo('$request->nombre_trabajo')");
        $job = Trabajo::findOrfail($request->edit_id);
        //Actualizamos el trabajo.
        $job->update([
            'nombre' => $request->nombre
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Dato actualizado correctamente',
        //     'data' => $job
        // ], Response::HTTP_OK);
      return redirect()->route('trabListAdmin');
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trabajo  $job
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        $data = $request->only('del_id' );
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
        //$query = DB::select("call getTrabajo('$request->nombre')");
        // $id = $query[0]->id;
        $job = Trabajo::findOrfail($request->del_id);
        //Eliminamos el trabajo
        $job->update(['status'=> 'Inactivo']);
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'Dato eliminado correctamente'
        // ], Response::HTTP_OK);
        return redirect()->route('trabListAdmin');
    }
    public function prueba(Request $request){
        //Validación de datos
        $data = $request->only('nombre');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:70|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $job = DB::select("call getTrabajo('$request->nombre')");
        
        return response()->json([
            'consulta'=> $job,
            'id' => $job[0]->id
        ]);
    }
}