<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Icono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class IconosController extends Controller
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
     * 
     */
    public function index(){
        return Icono::where('status', 'Activo')->get();
    }
    public function indexWeb()
    {
        //Listamos todos los Iconos
        return view('content.administrador.iconosAdmin',[
            "title" => "Dashboard | Iconos",
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
        $data = $request->only('nombre', 'url');
        $validator = Validator::make($data, [
            'nombre' => 'required|max:50|string',
            'url' => 'required|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el icono en la BD
        $icon = Icono::create([
            'nombre' => $request->nombre,
            'url' => $request->url,
            'status' => 'Activo'
        ]);
        $iconId = $icon->id;
        $url = $request->url;
        //$name = $request->nombre;

        // $rnd = Str::random(4);
        // $slug = Str::slug($name);
        
        $extension = pathinfo($url, PATHINFO_EXTENSION);
        // $filename = $rnd.'-'.$slug.'.'.$extension;
        $filename = 'icono-'.$iconId.'.'.$extension;
        $file = file_get_contents($url);
        file_put_contents('assets/iconos/'.$filename, $file);
        // //file_put_contents("C:\Users\Dell\Desktop".$filename, $file);
        
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Icono registrado correctamente',
        //     'data' => $icon
        // ], Response::HTTP_OK);
        //return self::indexWeb();
        return redirect()->route('iconosListAdmin');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Icono  $icon
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos el icono
        $icon = Icono::find($id);
        //Si el icono no existe devolvemos error no encontrado
        if (!$icon) {
            return response()->json([
                'message' => 'Icono no encontrado.'
            ], 404);
        }
        //Si hay icono lo devolvemos
        return $icon;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Icono  $icon
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id', 'nombre', 'url');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'nombre' => 'required|max:50|string',
            'url' => 'required|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el icono
        //$query = DB::select(("call getIcono('$request->nombre_icono')"));
        $icon = Icono::findOrfail($request->edit_id);
        //Actualizamos el icono.
        $icon->update([
            'nombre'=>$request->nombre,
            'url' => $request->url,
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Icono actualizado de correctamente',
        //     'data' => $icon
        // ], Response::HTTP_OK);
        return redirect()->route('iconosListAdmin');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Icono  $icon
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
         //Buscamos el producto
         //$query=DB::select("call getIcono('$request->nombre_producto')");
        $icon = Icono::findOrfail($request->del_id);
        //Eliminamos el icono
        $icon->update(['status' =>'Inactivo']);
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'Icono eliminado correctamente'
        // ], Response::HTTP_OK);
        return redirect()->route('iconosListAdmin');
    }
}
