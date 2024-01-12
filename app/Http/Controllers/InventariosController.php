<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Rama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class InventariosController extends Controller
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
        //Listamos todos los inventarios
        return DB::select('call getInventario_rama()');
    }
    public function indexWeb(){
        return view('content.administrador.inventarioAdmin',[
            "title" => "Dashboard | Inventario",
            "response" => self::index(),
            "productos" => Producto::where('status', 'Activo')->get(),
            "ramas"=>Rama::where('status', 'Activo')->get()
        ]
    );
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
        $data = $request->only('nombre_rama', 'codigo_producto', 'cantidad');
        $validator = Validator::make($data, [
            'nombre_rama' => 'required|max:50|string',
            'codigo_producto' => 'required|max:50|string',
            'cantidad' => 'required|numeric',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos la rama
        $queryRama = DB::select("call getRama('$request->nombre_rama')");
        // buscamos el producto
        $queryProd = DB::select("call getProducto('$request->codigo_producto')");
        //Creamos el inventario en la BD
        $inventario = Inventario::create([
            'id_rama' => $queryRama[0]->id,
            'id_producto' => $queryProd[0]->id,
            'cantidad' => $request->cantidad,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Inventario registrado',
            'data' => $inventario
        ], Response::HTTP_OK);
    }
    public function getProductos_Rama(Request $request)
    {
        $id = $request->get('selectedRamaId');
        $inventarios = Inventario::where('id_rama', $id)->pluck('id_producto');
        $productos = Producto::whereNotIn('id', $inventarios)->where('status', 'Activo')->get();
        return response()->json($productos);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el inventario
        $inventario = Inventario::find($id);
        //Si el inventario no existe devolvemos error no encontrado
        if (!$inventario) {
            return response()->json([
                'message' => 'Inventario no encontrado.'
            ], 404);
        }
        //Si hay inventario lo devolvemos
        return $inventario;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validación de datos
        $data = $request->only('nombre_rama', 'codigo_producto', 'cantidad');
        $validator = Validator::make($data, [
            'nombre_rama' => 'required|max:50|string',
            'codigo_producto' => 'required|max:50|string',
            'cantidad' => 'required|numeric',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el registro
        $query = DB::select("call getInventario('$request->nombre_rama')");
        //buscamos el producto
        $queryProd = DB::select("call getProducto('$request->codigo_producto')");
        //Buscamos el inventario
        $inventario = Inventario::findOrfail($query[0]->id);
        //Actualizamos el inventario.
        $inventario->update([
            'id_producto' => $queryProd[0]->id,
            'cantidad' => $request->cantidad,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Inventario actualizado correctamente',
            'data' => $inventario
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre_rama', 'codigo_producto');
        $validator = Validator::make($data, [
            'nombre_rama' => 'required|max:70|string',
            'codigo_producto' => 'required|max:50|string'
        ]);
        //Buscamos registro
        $query =DB::select("call getInv_rama('$request->nombre_rama','$request->codigo_producto')");
        //Buscamos el inventario
        $inventario = Inventario::findOrfail($query[0]->id);
        //Eliminamos el inventario
        $inventario->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Inventario borrado correctamente'
        ], Response::HTTP_OK);
    }

    /*-----------------------WEB-----------------------*/
    public function storeWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('id_rama', 'id_producto', 'cantidad');
        $validator = Validator::make($data, [
            'id_rama' => 'required|max:50|string',
            'id_producto' => 'required|max:50|string',
            'cantidad' => 'required|numeric'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos la rama
        $inventario = Inventario::create([
            'id_rama' => $request->id_rama,
            'id_producto' => $request->id_producto,
            'cantidad' => $request->cantidad,
            'status' => 'Activo'
        ]);
        //Respuesta en caso de que todo vaya bien.
       return redirect()->route('listaInventario');
    }

     public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id', 'cantidad','id_producto','id_rama');
        $validator = Validator::make($data, [
            'edit_id' => 'required|max:50|string',
            'cantidad' => 'required|numeric',
            'id_producto'=>'required|integer',
            'id_rama'=>'required|integer'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $inventario = Inventario::findOrfail($request->edit_id);
        //Actualizamos el inventario.
        $inventario->update([
            'cantidad' => $request->cantidad,
            'id_producto' => $request->id_producto,
            'id_rama' => $request->id_rama
        ]);
        //Devolvemos los datos actualizados.
        return redirect()->route('listaInventario');
    }
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'nombre_rama' => 'required|max:70|string',
            'codigo_producto' => 'required|max:50|string'
        ]);
        $inventario = Inventario::findOrfail($request->del_id);
        //Eliminamos el inventario
        $inventario->delete();
        //Devolvemos la respuesta
        return redirect()->route('listaInventario');
    }

}
