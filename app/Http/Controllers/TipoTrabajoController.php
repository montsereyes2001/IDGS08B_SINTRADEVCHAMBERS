<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\TipoTrabajo;
use App\Models\Trabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class TipoTrabajoController extends Controller
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
        //Listamos todos los Iconos
        
        return view('content.administrador.tipotrabajoAdmin',[
            'title' => 'Dashboard | Tipos de trabajo',
            'response' => DB::select('call getTipotrab()'),
            'trabajos' => Trabajo::where('status', 'Activo')->get()
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
        $data = $request->only('tipo', 'trabajo');
        $validator = Validator::make($data, [
            'tipo' => 'required|max:50|string',
            'trabajo' => 'required|int',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el tipo en la BD
        $tipoTrab = TipoTrabajo::create([
            'id_trabajo' => $request->trabajo,
            'nombre' => $request->tipo,
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Tipo de trabajo registrado correctamente',
        //     'data' => $tipoTrab
        // ], Response::HTTP_OK);
        return redirect()->route('tipotrabAdmin');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoTrabajo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el tipo
        $tipo = TipoTrabajo::find($id);
        //Si el tipo no existe devolvemos error no encontrado
        if (!$tipo) {
            return response()->json([
                'message' => 'tipo no encontrado.'
            ], 404);
        }
        //Si hay tipo lo devolvemos
        return $tipo;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoTrabajo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id', 'tipo','id_trab');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'tipo' => 'required|max:100|string',
            'id_trab' => 'required|int',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el tipo de trabajo
        $tipo = TipoTrabajo::findOrfail($request->edit_id);
        //Actualizamos el tipo.
        $tipo->update([
            'nombre' => $request->tipo,
            'id_trabajo' => $request->id_trab,
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Tipo actualizado de correctamente',
        //     'data' => $tipo
        // ], Response::HTTP_OK);
        return redirect()->route('tipotrabAdmin');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoTrabajo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int'
        ]);
         //Buscamos el tipo
        $tipo = TipoTrabajo::findOrfail($request->del_id);
        //Eliminamos el tipo
        $tipo->update(['status'=> 'Inactivo']);
        //Devolvemos la respuesta
        return redirect()->route('tipotrabAdmin');
    }
}
