<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\TipoTrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
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
        //Listamos todos los clientes
        return Cliente::where('status', 'Activo')->get();
    }

    public function indexWeb(){
        return view ('content.administrador.clientesAdmin',[
          "title" => "Dashboard | Clientes",
          "response" => self::index()
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
        $data = $request->only('nombre', 'city', 'edo');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:50|string',
            'city' => 'required|max:70|string',
            'edo' => 'required|max:70|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el cliente en la BD
        $client = Cliente::create([
            'nombre_empresa' => $request->nombre,
            'ciudad' => $request->city, 
            'estado' => $request->edo,
            'status' => 'Activo'
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Cliente registrado correctamente',
        //     'data' => $client
        // ], Response::HTTP_OK);
       return redirect()->route('clienListAdmin');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el cliente
        $client = Cliente::find($id);
        //Si el cliente no existe devolvemos error no encontrado
        if (!$client) {
            return response()->json([
                'message' => 'Cliente no encontrado.'
            ], 404);
        }
        //Si hay cliente lo devolvemos
        return $client;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $client
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id','nombre', 'city', 'edo');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:50|string',
            'city' => 'required|max:70|string',
            'edo' => 'required|max:70|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el cliente
        $client = Cliente::findOrfail($request->edit_id);
        //Actualizamos el cliente.
        $client->update([
            'nombre_empresa' => $request->nombre,
            'ciudad' => $request->city,
            'estado' => $request->edo
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Cliente actualizado de correctamente',
        //     'data' => $client
        // ], Response::HTTP_OK);
        return redirect()->route('clienListAdmin');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $client
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int'
        ]);
         //Buscamos el cliente
        $client = Cliente::findOrfail($request->del_id);
        //Eliminamos el icono
        $client->update(['status'=> 'Inactivo']);
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'Cliente eliminado correctamente'
        // ], Response::HTTP_OK);
       return redirect()->route('clienListAdmin');
    }
}
