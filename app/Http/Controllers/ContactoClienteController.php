<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\ContactoCliente;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ContactoClienteController extends Controller
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
        //Listamos todos los Iconos
        return DB::select("call getContacto_cliente()");
    }
    public function indexWeb(){
        return view ('content.administrador.contactoClienteAdmin',[
          "title" => "Dashboard | Contacto Cliente",
          "response" => self::index(),
          "clientes" => Cliente::where('status', 'Activo')->get()
      ]);}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('cliente', 'email', 'name', 'puesto', 'tel');
        $validator = Validator::make($data, [
            'cliente' => 'required|max:50|string',
            'email' => 'required|max:70|string',
            'name' => 'required|max:70|string',
            'puesto' => 'required|max:70|string',
            'tel' => 'required|max:50|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el contacto en la BD
        $cont = ContactoCliente::create([
            'id_cliente' => $request->cliente,
            'contacto_email' => $request->email,
            'contacto_nombre' => $request->name,
            'contacto_cargo' => $request->puesto,
            'telefono' => $request->tel,
            'status'=> 'Activo'
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Contacto registrado correctamente',
        //     'data' => $cont
        // ], Response::HTTP_OK);
        return redirect()->route('concliListAdmin');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContactoCliente  $cont
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el contacto
        $cont = ContactoCliente::find($id);
        //Si el contacto no existe devolvemos error no encontrado
        if (!$cont) {
            return response()->json([
                'message' => 'Contacto no encontrado.'
            ], 404);
        }
        //Si hay contacto lo devolvemos
        return $cont;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContactoCliente  $cont
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id','cliente', 'email', 'name', 'puesto', 'tel');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'email' => 'required|max:70|string',
            'name' => 'required|max:70|string',
            'puesto' => 'required|max:70|string',
            'tel' => 'required|max:50|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el contacto
        $cont = ContactoCliente::findOrfail($request->edit_id);
        //Actualizamos el contacto.
        $cont->update([
            'contacto_email' => $request->email,
            'contacto_nombre' => $request->name,
            'contacto_cargo' => $request->puesto,
            'contacto_telefono' => $request->tel,
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Contacto actualizado de correctamente',
        //     'data' => $cont
        // ], Response::HTTP_OK);
        return redirect()->route('concliListAdmin');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContactoCliente  $cont
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
         //Buscamos el contacto
        $cont = ContactoCliente::findOrfail($request->del_id);
        //Eliminamos el contacto
        $cont->update(['status'=> 'Inactivo']);
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'Contacto eliminado correctamente'
        // ], Response::HTTP_OK);
        return redirect()->route('concliListAdmin');
    }
}
