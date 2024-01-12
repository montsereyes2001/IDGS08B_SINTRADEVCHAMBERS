<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Insumo;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class InsumosController extends Controller
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
        //Listamos todos los insumos
        return Insumo::get();
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
        $data = $request->only('nombre_trabajo', 'nombre_rama', 'correo_lider', 'ciudad', 'estado', 'codigo_producto',  'cantidad');
        $validator = Validator::make($data, [
           'nombre_trabajo' => 'required|max:50|string',
           'nombre_rama' => 'required|max:50|string',
           'correo_lider' => 'required|max:50|string',
           'ciudad' => 'required|max:50|string',
           'estado' => 'required|max:50|string',
           'codigo_producto' => 'required|max:50|string',
           'cantidad' => 'required|numeric',
        ]);
         //Si falla la validación
         if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //buscamos los datos necesarios con sp's
        $queryTrab = DB::select("call getTrabajo('$request->nombre_trabajo')");
        $trab = $queryTrab[0]->id;
        $queryRama = DB::select("call getRama('$request->nombre_rama')");
        $rama = $queryRama[0]->id;
        $queryLid = DB::select("call getLider('$request->correo_lider')");
        $lider = $queryLid[0]->id;
        $queryIcon = DB::select("call getIcono('$request->nombre_icono')");
        //sp de la tabla bitacoras
        $queryBit = DB::select("call getBitacora('$trab','$rama','$lider','$request->ciudad','$request->estado')");
        $bit = $queryBit[0]->id;
        //sp de la tabla productos
        $queryProd =DB::select("call getProducto('$request->codigo_producto')");
        $product = $queryProd[0]->id;
        //Creamos el insumo en la BD
        $in = Insumo::create([
            'id_bitacora' => $bit,
            'id_producto' => $product,
            'cantidad' => $request->cantidad,
        ]);
        //Respuesta en caso de que todo vaya bien.
        return response()->json([
            'message' => 'Insumo registrado',
            'data' => $in
        ], Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Insumo  $in
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el insumo
        $in = Insumo::find($id);
        //Si el insumo no existe devolvemos error no encontrado
        if (!$in) {
            return response()->json([
                'message' => 'Insumo no encontrado.'
            ], 404);
        }
        //Si hay insumo lo devolvemos
        return $in;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Insumo  $in
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre_trabajo', 'nombre_rama', 'correo_lider', 'ciudad', 'estado', 'codigo_producto', 'nuevo_producto', 'cantidad');
        $validator = Validator::make($data, [
           'nombre_trabajo' => 'required|max:50|string',
           'nombre_rama' => 'required|max:50|string',
           'correo_lider' => 'required|max:50|string',
           'ciudad' => 'required|max:50|string',
           'estado' => 'required|max:50|string',
           'codigo_producto' => 'required|max:50|string',
           'nuevo_producto' => 'required|max:50|string',
           'cantidad' => 'required|numeric',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //buscamos los datos necesarios con sp's
        $queryTrab = DB::select("call getTrabajo('$request->nombre_trabajo')");
        $trab = $queryTrab[0]->id;
        $queryRama = DB::select("call getRama('$request->nombre_rama')");
        $rama = $queryRama[0]->id;
        $queryLid = DB::select("call getLider('$request->correo_lider')");
        $lider = $queryLid[0]->id;
        $queryIcon = DB::select("call getIcono('$request->nombre_icono')");
        //sp de la tabla bitacoras
        $queryBit = DB::select("call getBitacora('$trab','$rama','$lider','$request->ciudad','$request->estado')");
        $bit = $queryBit[0]->id;
        //sp de la tabla productos
        $queryProd =DB::select("call getProducto('$request->codigo_producto')");
        $product = $queryProd[0]->id;
        //sp de la tabla insumos
        $queryIns = DB::select("call getInsumo('$bit', '$product')");
        $insumo = $queryIns[0]->id;
        //nuevo producto a registrar
        $queryNProd =DB::select("call getProducto('$request->nuevo_producto')");
        $nproduct = $queryProd[0]->id;
         //Buscamos el insumo
         $in = Insumo::findOrfail($insumo);
         //Actualizamos el insumo.
         $in->update([
            'id_producto' => $nproduct,
            'cantidad' => $request->cantidad,
         ]);
         //Devolvemos los datos actualizados.
         return response()->json([
             'message' => 'Insumo actualizado correctamente',
             'data' => $in
         ], Response::HTTP_OK);
     }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Insumo  $in
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Buscamos el insumo
        $in = Insumo::findOrfail($id);
        //Eliminamos el insumo
        $in->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Insumo eliminado correctamente'
        ], Response::HTTP_OK);
    }
}
