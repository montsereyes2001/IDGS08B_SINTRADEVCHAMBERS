<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    //
    protected $user;
    public function __construct(Request $request){
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
        //Listamos todos los productos
        return Producto::get();
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
        $data = $request->only('codigo_inicial', 'nombre', 'categoria', 'descripcion');
        $validator = Validator::make($data, [
            'codigo_inicial' => 'nullable|string',
            'nombre' => 'required|string',
            'categoria'=>'required|string',
            'descripcion' => 'required|string'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el producto en la BD
        $product = Producto::create([
            'codigo_inicial' => $request->codigo_inicial,
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => "Producto registrado",
            'data' => $product
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el producto
        $product = Producto::find($id);
        //Si el producto no existe devolvemos error no encontrado
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado.'
            ], 404);
        }
        //Si hay producto lo devolvemos
        return $product;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validación de datos
        $data = $request->only('codigo_producto','nuevo_codigo','nuevo_nombre','nueva_categoria', 'nueva_desc');
        $validator = Validator::make($data, [
            'codigo_producto' => 'required|max:70|string',
            'nuevo_codigo' => 'required|string',
            'nuevo_nombre' => 'required|string',
            'nueva_categoria' => 'required|string',
            'nueva_desc' => 'required|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el producto
        $query=DB::select("call getProducto('$request->codigo_producto')");
        $product = Producto::findorfail($query[0]->id);
        //Actualizamos el producto.
        $product->update([
            'codigo_inicial' => $request->nuevo_codigo,
            'nombre' => $request->nuevo_nombre,
            'categoria' => $request->nueva_categoria,
            'descripcion' => $request->nueva_desc
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Producto modificado correctamente',
            'data' => $product
        ], Response::HTTP_OK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Validamos los datos
        $data = $request->only('codigo_inicial');
        $validator = Validator::make($data, [
            'codigo_inicial' => 'nullable|string',
        ]);
        //Buscamos el producto
        $query=DB::select("call getProducto('$request->codigo_inicial')");
        $product = Producto::findOrfail($query[0]->id);
        //Eliminamos el producto
        $product->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Producto eliminado correctamente'
        ], Response::HTTP_OK);
    }
    public function prueba(Request $request){
        //Validación de datos
        $data = $request->only('nombre_producto','nuevo_codigo', 'nuevo_nombre','nueva_categoria');
        $validator = Validator::make($data, [
            'nombre_producto' => 'required|max:70|string',
            'nuevo_codigo' => 'required|string',
            'nuevo_nombre' => 'required|string',
            'nueva_categoria' => 'required|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $product = DB::select("call getProducto('$request->nombre_producto')");
        
        return response()->json([
            'consulta'=> $product,
            'id' => $product[0]->id
        ]);
    }


     public function indexWeb(){
        return view ('content.administrador.productosAdmin',[
            "title" => "Dashboard | Productos",
            "response" => self::list()
        ]);
    }
    public function list()
    {
        return Producto::where('status', 'Activo')->get();
    }
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id','nuevo_codigo','nuevo_nombre','nueva_categoria', 'nueva_desc');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'nuevo_codigo' => 'nullable|string',
            'nuevo_nombre' => 'required|string',
            'nueva_categoria' => 'required|string',
            'nueva_desc' => 'required|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
         //$query=DB::select("call getProducto('$request->codigo_producto')");
        $product = Producto::findorfail($request->edit_id);
        //Actualizamos el producto.
        $product->update([
            'codigo_inicial' => $request->nuevo_codigo,
            'nombre' => $request->nuevo_nombre,
            'categoria' => $request->nueva_categoria,
            'descripcion' => $request->nueva_desc
        ]);
        return redirect()->route('prodVistaAdmin');
    }

    public function destroyWeb(Request $request)
    {
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
        $job = Producto::findOrfail($request->del_id);
        $job->update(['status'=> 'Inactivo']);
        return redirect()->route('prodVistaAdmin');
    }

public function storeWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('codigo_inicial', 'nombre', 'categoria', 'descripcion');
        $validator = Validator::make($data, [
            'codigo_inicial' => 'nullable|string',
            'nombre' => 'required|string',
            'categoria'=>'required|string',
            'descripcion' => 'required|string'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el producto en la BD
        $product = Producto::create([
            'codigo_inicial' => $request->codigo_inicial,
            'nombre' => $request->nombre,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'status' => 'Activo'
        ]);
        //Respuesta en caso de que todo vaya bien.
       return redirect()->route('prodVistaAdmin');
    }
}