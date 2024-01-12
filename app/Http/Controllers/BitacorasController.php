<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Bitacora;
use App\Models\Cliente;
use App\Models\MaterialBitacora;
use App\Models\TipoTrabajo;
use App\Models\Rama;
use App\Models\Lider;
use App\Models\Icono;
use App\Models\Inventario;
use App\Models\Trabajo;
use App\Models\Insumo;
use App\Models\Evidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DOMDocument;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column as AutoFilterColumn;
use PhpOffice\PhpSpreadsheet\Worksheet\AutoFilter\Column\Rule;
use PhpOffice\PhpSpreadsheet\Worksheet\Column;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use ZipArchive;


class BitacorasController extends Controller
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
        //Listamos todos los bitacora
        return Bitacora::get();
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
        $items = $request->input('mats');
        $data = $request->only('tipo_trabajo', 'rama', 'lider', 'ciudad', 'estados');
        $validator = Validator::make($data, [
            'tipo_trabajo' => 'string|max:50|int',
            'rama' => 'string|max:50|int',
            'lider' => 'string|max:50|string',
            'ciudad' => 'string|max:50|string',
            'estados' => 'string|max:50|string'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //buscamos los datos necesarios con sp's
        //$queryTrab = DB::select("call getTrabajo('$request->nombre_trabajo')");
        //$queryRama = DB::select("call getRama('$request->nombre_rama')");
        $queryLid = DB::select("call getLider('$request->lider')");
        //Creamos el bitacora en la BD
        $bit = Bitacora::create([
            'id_tipo_trabajo' => $request->tipo_trabajo,
            'id_rama' => $request->rama,
            'id_supervisor_lider' => $queryLid[0]->id,
            'ciudad' => $request->ciudad,
            'estado' => $request->estados,
            'estatus' => 'En progreso',
        ]);
        // return view ('content.lider.actions',[
        //     'list'=> DB::select('call getBitacora_data("'.$request->correo.'")'),
        //     'action'=>'register'
        // ]);
        $idBit = $bit->id;
        if ($items == [] || $items == null){
                return redirect()->route('gallery', [$idBit]);
        } else {
            foreach ($items as $item) {
                DB::table('material_bitacora')->insert([
                    'id_bitacora' => $idBit,
                    'id_productos' => $item,
                    'status' => 'Activo'
                ]);
            }
            return redirect()->route('gallery', [$idBit]);
        }

        }

    public function galeria($id){
        return view('content.lider.gallery',[
            'id_bit'=>$id,
            'title'=> 'Galeria de registros',
            'evidencias'=> DB::select("call getBit_evidence('$id')")
            // 'insumos' => DB::select("call getInsumo_ev('$id')")
        ]);
    }
    public function inventario_rama(Request $request){
       $inventario = Inventario::join("productos as p","inventarios.id_producto","=","p.id")
        ->where("inventarios.id_rama","=", $request->id)->select('p.id', 'p.nombre')->get();
        return $inventario;
    }
    public function viewFoto($id){
        // print_r($request->all()); ("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")
        $trab = Bitacora::join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', "=", "t.id")
        ->where('bitacoras.id', '=', $id)->select('t.nombre as nombre')->get();
        // $matbit = DB::select('SELECT productos.nombre as prodmatbit, bitacoras.id as bitmat FROM material_bitacora INNER JOIN productos ON material_bitacora.id_productos = productos.id INNER JOIN bitacoras ON material_bitacora.id_bitacora = bitacoras.id 
        // WHERE bitacoras.id = $id');
        
        $matbit = DB::select("call get_material_bitacora('$id')");
        return view ('content.lider.subirfotoLider',[
            'title'=>'Subir Foto',
            'id_bitacora' => $id,
            'trab_bit'=>$trab[0]->nombre,
            'iconos' => Icono::get(),
            'matbit' => $matbit,
             'icon_oc'=> Icono::where('nombre', '=', 'Obra Civil')->get(),
            'icon_des' => Icono::where('nombre', '=', 'Desmantelamiento')->get(),
            'icon_tron' => Icono::where('nombre', '=', 'Troncal')->get(),
            'icon_dis' => Icono::where('nombre', '=', 'Distribución')->get(),
            

        ]);

       
        // $title = Session::get('title');
        // $id_bitacora = Session::get('id_bitacora');
        // $iconos = Session::get('icono');
        // return view ('content.lider.subirfotoLider',[
        //     'title'=> $title,
        //     'id_bitacora' => $id_bitacora,
        //     'iconos' => $iconos
        // ]);
    }
    public function viewFotoAdmin($id)
    {
        // print_r($request->all()); ("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")
        $trab = Bitacora::join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', "=", "t.id")
            ->where('bitacoras.id', '=', $id)->select('t.nombre as nombre')->get();
        // $matbit = DB::select('SELECT productos.nombre as prodmatbit, bitacoras.id as bitmat FROM material_bitacora INNER JOIN productos ON material_bitacora.id_productos = productos.id INNER JOIN bitacoras ON material_bitacora.id_bitacora = bitacoras.id 
        // WHERE bitacoras.id = $id');
        $icono_oc = Icono::where('nombre', '=', 'Obra Civil')->where('status', '=', 'Activo')->get();
        $icono_des = Icono::where('nombre', '=', 'Desmantelamiento')->where('status', '=', 'Activo')->get();
        $icono_tron = Icono::where('nombre', '=', 'Troncal')->where('status', '=', 'Activo')->get();
        $icono_dis = Icono::where('nombre', '=', 'Distribución')->where('status', '=', 'Activo')->get();
        $matbit = DB::select("call get_material_bitacora('$id')");
        return view('content.administrador.subirfotoAdmin', [
            'title' => 'Subir Foto',
            'id_bitacora' => $id,
            'trab_bit' => $trab[0]->nombre,
            'iconos' => Icono::whereNotIn('nombre', ['Obra Civil', 'Desmantelamiento', 'Troncal', 'Distribución'])->get(),
            'matbit' => $matbit,
            'icon_oc'=> $icono_oc[0]->id,
            'icon_des' => $icono_des[0]->id,
            'icon_tron' => $icono_tron[0]->id,
            'icon_dis' => $icono_dis[0]->id,
            
        ]);
        
        //AQUI FALTA CATEGORIZAR PARA CADA UNO DE LOS TIPOS DE TRABAJO EN LOS ÍCONOS!!!

        // $title = Session::get('title');
        // $id_bitacora = Session::get('id_bitacora');
        // $iconos = Session::get('icono');
        // return view ('content.lider.subirfotoLider',[
        //     'title'=> $title,
        //     'id_bitacora' => $id_bitacora,
        //     'iconos' => $iconos
        // ]);
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bitacora  $bit
     * @return \Illuminate\Http\Response
     */
    public function viewFotoGerente($id)
    {
        // print_r($request->all()); ("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")
        $trab = Bitacora::join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', "=", "t.id")
            ->where('bitacoras.id', '=', $id)->select('t.nombre as nombre')->get();
        // $matbit = DB::select('SELECT productos.nombre as prodmatbit, bitacoras.id as bitmat FROM material_bitacora INNER JOIN productos ON material_bitacora.id_productos = productos.id INNER JOIN bitacoras ON material_bitacora.id_bitacora = bitacoras.id 
        // WHERE bitacoras.id = $id');
        $matbit = DB::select("call get_material_bitacora('$id')");
        return view('content.gerente.subirFotoGerente', [
        'title' => 'Subir Foto',
            'id_bitacora' => $id,
            'trab_bit' => $trab[0]->nombre,
            'iconos' => Icono::get(),
            'matbit' => $matbit
        ]);


        // $title = Session::get('title');
        // $id_bitacora = Session::get('id_bitacora');
        // $iconos = Session::get('icono');
        // return view ('content.lider.subirfotoLider',[
        //     'title'=> $title,
        //     'id_bitacora' => $id_bitacora,
        //     'iconos' => $iconos
        // ]);
    }
    public function show($id)
    {
        //Bucamos el bitacoras
        $bit = Bitacora::find($id);
        //Si el bitacora no existe devolvemos error no encontrado
        if (!$bit) {
            return response()->json([
                'message' => 'Bitacora no encontrada.'
            ], 404);
        }
        //Si hay bitacora la devolvemos
        return $bit;
    }
    public function query(Request $request)
    {
        $data = $request->only('correo', 'rama','status','ciudad', 'estado',  'trabajo', 'fecha1', 'fecha2');
        $validator = Validator::make($data, [
            'correo' => 'string',
            'rama' => 'string|nullable',
            'trabajo' => 'string|nullable',
            'status' => 'string|nullable',
            'ciudad' => 'string|nullable',
            'estado' => 'string|nullable',
            'fecha1' => 'string',
            'fecha2' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(),], 400);
        }
        //Bucamos el bitacoras
        // $us = User::where('id','=', $request->correo)->get();
        $bit = DB::select('call getBL_filtrotodo("'.$request->correo.'", "'.$request->fecha1.'", "'.$request->fecha2.'", "'.$request->estado.'","'.$request->ciudad.'", "'.$request->status.'", "'.$request->trabajo.'", "'.$request->rama.'")');
        //Si el bitacora no existe devolvemos error no encontrado
        $res['data'] = $bit;
        // return $bit;
        return $bit;
    }
     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bitacora  $bit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validación de datos
        $data = $request->only('nombre_trabajo', 'nombre_rama', 'correo_lider', 'ciudad', 'estado', 'nuevo_estatus');
        $validator = Validator::make($data, [
            'nombre_trabajo' => 'string|max:50|string',
            'nombre_rama' => 'string|max:50|string',
            'correo_lider' => 'string|max:50|string',
            'ciudad' => 'string|max:50|string',
            'estado' => 'string|max:50|string',
            'nuevo_estatus' => 'string|max:50|string',
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
        //sp de la tabla
        $query = DB::select("call getBitacora('$trab','$rama','$lider','$request->ciudad','$request->estado')");
        //Buscamos la bitacora
        $bit = Bitacora::findOrfail($query[0]->id);
        //Actualizamos la bitacora.
        $bit->update([
            'estatus' => $request->nuevo_estatus,
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Bitacora modificada correctamente',
            'data' => $bit
        ], Response::HTTP_OK);
    }
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bitacora  $bit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Validación de datos
        $data = $request->only('nombre_trabajo', 'nombre_rama', 'correo_lider', 'ciudad', 'estado');
        $validator = Validator::make($data, [
            'nombre_trabajo' => 'string|max:50|string',
            'nombre_rama' => 'string|max:50|string',
            'correo_lider' => 'string|max:50|string',
            'ciudad' => 'string|max:50|string',
            'estado' => 'string|max:50|string'
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
        //sp de la tabla
        $query = DB::select("call getBitacora('$trab','$rama','$lider','$request->ciudad','$request->estado')");
        $bit = Bitacora::findOrfail($query[0]->id);
        //Eliminamos la bitacora
        $bit->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Bitacora eliminada correctamente'
        ], Response::HTTP_OK);
    }
    public function prueba(Request $request)
    {
        //Validación de datos
        $data = $request->only('nombre_trabajo');
        $validator = Validator::make($data, [
            'nombre_trabajo' => 'string|max:50|string',
        ]);
        //buscamos los datos necesarios con sp's
        $queryTrab = DB::select("call getTrabajo('$request->nombre_trabajo')");
        $trab = $queryTrab[0]->id;
        return response()->json()([
            'trabajo'=>$trab
        ]);
    }
    public function getCorreo(Request $request){
        $data = $request->only('correo','action');
        $validator = Validator::make($data, [
            'correo' => 'string|max:80|string',
            'action' => 'string|max:80|string'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $correo = $request->correo;
        return view ('content.lider.actions',[
            'list'=> DB::select('call getBitacora_data("'.$request->correo.'")'),
            'action'=>$request->action
        ]);
    }

    public function indexWeb(){
        return view ('content.lider.bitacorasLider',[
            'title' => 'Crear Bitácora',
            'tipotrabajo' => TipoTrabajo::where('status','Activo')->get(),
            'ramas' => Rama::where('status','Activo')->get(),
            'lideres'=> Lider::where('estado','Activo')->get(),
            
        ]);
    }

 


public function updtWeb($id) {
    // retrieve data for the view
    $ttrabajo = Bitacora::join('tipo_trabajos as t','bitacoras.id_tipo_trabajo', "=", "t.id")
        ->where('bitacoras.id','=', $id)->select('t.nombre as nombre','bitacoras.ciudad as ciudad','bitacoras.estado as estado','bitacoras.estatus')->get();
    $rama = Bitacora::join('ramas','bitacoras.id_rama', "=", "ramas.id")
        ->where('bitacoras.id','=', $id)->select('ramas.nombre as nombre', 'ramas.id')->get();
    $lider = Bitacora::join('lideres', 'bitacoras.id_lider', "=", "lideres.id")
        ->join('usuarios', 'usuarios.id', "=", 'lideres.id_usuario')
        ->where('bitacoras.id','=', $id)->select(DB::raw("concat_ws(' ',usuarios.nombre, usuarios.apellido_paterno,usuarios.apellido_materno) as nombre"))->get();

        $selectedCheckboxes = collect(DB::select("SELECT material_bitacora.id_bitacora, productos.id as idmats, productos.nombre as prodmatbit FROM productos INNER JOIN material_bitacora ON productos.id = material_bitacora.id_productos INNER JOIN bitacoras ON material_bitacora.id_bitacora = bitacoras.id
INNER JOIN tipo_trabajos ON bitacoras.id_tipo_trabajo = tipo_trabajos.id WHERE  tipo_trabajos.nombre NOT IN ('Obra Civil', 'Desmantelamiento') AND material_bitacora.status = 'Activo' AND material_bitacora.id_bitacora =:id", ['id' => $id]));
    $selectedCheckboxesIds = array();
        
        if (!empty($selectedCheckboxes)) {
            foreach ($selectedCheckboxes as $selectedCheckbox) {
                if (property_exists($selectedCheckbox, 'idmats')) {
                    $selectedCheckboxesIds[] = $selectedCheckbox->idmats;
                }
            }
        }
    // retrieve the id_rama from the selected bitacora
    $id_rama = $rama[0]->id;
    // retrieve the whole materials from the selected rama
        $inventario = Inventario::join("productos as p", "inventarios.id_producto", "=", "p.id")
            ->where("inventarios.id_rama", "=", $id_rama)->select('p.id', 'p.nombre')->get();
       
    return view ('content.lider.modBit',[
        'title' => 'Modificar registro',
        'tipotrabajo' => TipoTrabajo::get(),
        'ttrabajo' =>$ttrabajo,
        'rama'=>$rama,
        'lid'=>$lider,
        'estatus' =>$ttrabajo,
        'ramas' => Rama::get(),
        'lideres'=> DB::select('call getLider_user()'),
        'id_bitacora' =>$id,
        'selectedCheckboxes' => $selectedCheckboxes,
        'selectedCheckboxesIds' => $selectedCheckboxesIds,
        'inventario' => $inventario
]);
}

    public function editarBitacora(Request $request,$id){
        $bitacora = Bitacora::join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', "=", "t.id")
            ->where('bitacoras.id', '=', $id)->select('t.nombre as nombre')->first();
        if ($bitacora->nombre === 'Distribución' || $bitacora->nombre === 'Troncal') {
            // Codigo para los materiales
            $data = $request->only('estatus', 'rama', 'materials');
            $validator = Validator::make($data, [
                'estatus' => 'required|max:50|string',
                'rama' => 'required|int',
                'materials' => 'required|array'
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 400);
            }
            $bit = Bitacora::findOrfail($id);
            $rama = Rama::findOrFail($request->rama);
            $bit->update([
                'estatus' => $request->estatus,
                'id_rama' => $rama->id,
            ]);
            MaterialBitacora::where('id_bitacora', $id)->update(['status' => 'Inactivo']);
            // MaterialBitacora::where('id_bitacora', $id)->delete();
            $materials = $request->materials;
            foreach ($materials as $material) {
                MaterialBitacora::updateOrCreate(
                    ['id_productos' => $material, 'id_bitacora' => $id],
                    ['status' => 'Activo']
                );
            }
            // MaterialBitacora::whereNotIn('id_productos', $materials)->where('id_bitacora', $id)->delete();
            MaterialBitacora::whereNotIn('id_productos', $materials)->where('id_bitacora', $id)->update(['status' => 'Inactivo']);


            session()->flash('message', 'El registro se ha modificado correctamente.');
            return redirect()->route('updtWeb', ['id' => $id]);
        }else{
            $data = $request->only('estatus', 'rama');
            $validator = Validator::make($data, [
                'estatus' => 'required|max:50|string',
                'rama' => 'required|int',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->messages()], 400);
            }
            $bit = Bitacora::findOrfail($id);
            $rama = Rama::findOrFail($request->rama);
            $bit->update([
                'estatus' => $request->estatus,
                'id_rama' => $rama->id,
            ]);
            session()->flash('message', 'El registro se ha modificado correctamente.');
            return redirect()->route('updtWeb', ['id' => $id]);
        }
       
    }

     public function borrarBitacora($id){
        $databit = Bitacora::select('bitacoras.id', 'tipo_trabajos.nombre as trabajo', 'ramas.nombre as rama', 
        DB::raw("concat_ws(' ',usuarios.nombre, usuarios.apellido_paterno) as nombre_lider"), 'bitacoras.ciudad', 
        'bitacoras.estado', 'bitacoras.estatus', 'bitacoras.created_at', 'bitacoras.updated_at')
        ->join('tipo_trabajos', 'bitacoras.id_tipo_trabajo', '=', 'tipo_trabajos.id')
        ->join('ramas', 'bitacoras.id_rama', '=', 'ramas.id')
        ->join('lideres', 'bitacoras.id_lider', '=', 'lideres.id')
        ->join('usuarios', 'lideres.id_usuario', '=', 'usuarios.id')
        ->whereIn('bitacoras.estatus', ['Terminado','En progreso'])
        ->where('tipo_trabajos.status', 'Activo')
        ->where('ramas.status', 'Activo')
        ->where('lideres.estado', 'Activo')
        ->where('usuarios.estado', 'Activo')
        ->where('bitacoras.id', $id)
        ->get();
        $databit = $databit->first();
        $bit = Bitacora::findOrfail($id);
        //Actualizamos el cliente.
        $bit->update([
            'estatus' => 'Inactivo',
        ]);
        session()->flash('message', 'El registro de la rama: '.$databit->rama.' del tipo de trabajo '.$databit->trabajo.' se ha borrado.');
        return redirect()->route('cardsBitacoraDos');
    }
    public function verBorrarBitacora($id){
        return view ('content.lider.delBit',[
            'id_bitacora' => $id,
        ]);
    }

    public function cards(){
        $ubicaciones=Bitacora::select('ciudad','estado')->distinct()->orderby('estado')->get();
        $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->where('tipo_trabajos.status', 'Activo')->where('t.status','Activo')->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        return view('content.lider.cardsBitacoraDos',[
            'title'=>'Bitacoras',
            'ramas'=>Rama::orderby('id')->where('ramas.status','Activo')->get(),
            'lideres' => Lider::where('estado', 'Activo')->get(),
            'tipos'=>$tipoT,
            'trabajos'=>Trabajo::select('id','nombre')->where('status','Activo')->get(),
            'ubicaciones'=>$ubicaciones,

        ]);
    }
        
    public function crearKml(Request $request){
        header('Content-Type: text/xml; charset=utf-8');
        mb_internal_encoding("UTF-8");
        ini_set('default_charset', 'UTF-8');

        $data = $request->only('id');
        $validator = Validator::make($data, [
            'id' => 'required'
        ]);
     
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $bit= Bitacora::join("tipo_trabajos as t", "bitacoras.id_tipo_trabajo", "=", "t.id")
        ->join("ramas as r", "bitacoras.id_rama", "=", "r.id")
        ->where('bitacoras.id', "=", $request->id)
        ->select(["r.nombre as rama", "t.nombre as trabajo"])
        ->first();
        header('Content-Type: application/vnd.google-earth.kml+xml; charset=UTF-8');
        mb_internal_encoding("UTF-8");
        ini_set('default_charset', 'UTF-8');
        header('Content-Disposition: attachment; filename="'.$bit->rama.'-'.$bit->trabajo.'.kml"');
        // Creates the Document.
        $dom = new DOMDocument('1.0', 'utf-8');
        // Creates the root KML element and appends it to the root document.
        $node = $dom->createElementNS('http://earth.google.com/kml/2.1', 'kml');
        $parNode = $dom->appendChild($node);

        // Creates a KML Document element and append it to the KML element.
        $dnode = $dom->createElement('Document');
        $docNode = $parNode->appendChild($dnode);
            // Creates an array of strings to hold the lines of the KML file.
        $kml = array('<?xml version="1.0" encoding="UTF-8"?>');
        $kml[] = '<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom">';
        $kml[] = ' <Document>';
        //para icono del punto
        $query = Evidencia::leftjoin("iconos as i", "evidencias.id_icono", "=", "i.id")
        ->leftjoin("bitacoras as b", "evidencias.id_bitacora", "=", "b.id")
        ->where('evidencias.id_bitacora', '=', $request->id)
        ->where('evidencias.status', '=', 'Activo')
        ->select(['i.url as urlIcono','evidencias.id as idE','evidencias.nombre as nombreEvidencia', 'evidencias.foto','evidencias.latitud','evidencias.longitud','evidencias.altitud', 'evidencias.descripcion as descFoto','evidencias.created_at','evidencias.updated_at'])->get();
        
        foreach($query as $row)
        {
            $kml[] = ' <Style id="punto'.$row->idE.'">';
            $kml[] = ' <IconStyle>';
            $kml[] = ' <Icon>';
            $kml[] = ' <href>'.$row->urlIcono.'</href>';//icono de la imagen en el menu desplegable
            $kml[] = ' </Icon>';
            $kml[] = ' </IconStyle>';
            $kml[] = ' <LabelStyle>';
            $kml[] = ' <scale>0</scale>';
            $kml[] = ' </LabelStyle>';
            $kml[] = ' <BalloonStyle>';
            $kml[] = ' <text>'. htmlspecialchars($row->nombreEvidencia, ENT_QUOTES, 'UTF-8').'</text>';//texto de la imagen que se ve desde explorador de earth 
            $kml[] = ' </BalloonStyle>';
            // $kml[] = ' ';
            $kml[] = ' </Style>';
            $kml[] = ' <StyleMap id="ms_imgP'.$row->idE.'">';
            $kml[] = ' <Pair>';
            $kml[] = ' <key>normal</key>';
            $kml[] = ' <styleUrl>#punto'.$row->idE.'</styleUrl>';
            $kml[] = ' </Pair>';
            $kml[] = ' <Pair>';
            $kml[] = ' <key>highlight</key>';
            $kml[] = ' <styleUrl>#imgPunto'.$row->idE.'</styleUrl>';
            $kml[] = ' </Pair>';
            $kml[] = ' </StyleMap>';

            $kml[] = ' <Style id="imgPunto'.$row->idE.'">';
            $kml[] = ' <IconStyle>';
            $kml[] = ' <scale>2</scale>';
            $kml[] = ' <Icon>';
            $table = '<table width="500">          
            <tr><td>&nbsp;</td></tr>
            <tr height="500">
            <td>
            <img src="'.$row->foto.'" width="100%" height="500">
            <br />
            </td>
            </tr>
            <tr>
            <td></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>' . htmlspecialchars($row->descFoto, ENT_QUOTES, 'UTF-8') . '</tr>
            <tr>
            <td>
            <em>Creado en : '.$row->created_at.' </em>
            <em>Ultima modificacion : '.$row->modified_at.' </em>
            </td>
            </tr>
            </table>';//imagen que se ve al clickear el icono
            $kml[] = ' <href>'.$row->urlIcono.'</href>';
            $kml[] = ' </Icon>';
            $kml[] = ' </IconStyle>';
            $kml[] = ' <BalloonStyle>';
            $kml[] = ' <text>'. htmlspecialchars($table, ENT_QUOTES, 'UTF-8').'</text>';//texto que se ve al clikear el cuadro en el mapa
            $kml[] = ' </BalloonStyle>';
            $kml[] = ' </Style>';

            // Iterates through the MySQL results, creating one Placemark for each row.
            $kml[] = ' <Placemark>';
            $kml[] = ' <name>' . htmlspecialchars($row->nombreEvidencia, ENT_QUOTES, 'UTF-8').'</name>';//nombre del archivo en el explorador de earth
            // $kml[] = ' <name>direccion prueba</name>';
            //   $kml[] = ' <Snippet maxLines="10"></Snippet>';//espacio debajo del recuadro en google earth
            $kml[] = ' <description></description>';//tabla en el menu desplegable
            $kml[] = ' <LookAt>';
            $kml[] = ' <longitude>'. $row->longitud . '</longitude>';
            $kml[] = ' <latitude>'. $row->latitud .'</latitude>';
            // $kml[] = ' <altitude>'.$row->altitud.'</altitude>';
            // $kml[] = ' <heading>0</heading>';//desde donde se ve la imagen en respecto a 360 hacia los lados
            // $kml[] = ' <tilt>0</tilt>';//angulo con respecto al suelo para ve la imagen
            $kml[] = ' <range>100</range>';//distancia a la que se ve la imagen 
            $kml[] = ' </LookAt>';
            $kml[] = ' <styleUrl>#ms_imgP'.$row->idE.'</styleUrl>';
            $kml[] = ' <Point>';
            $kml[] = ' <coordinates>' . $row->longitud . ','  . $row->latitud . '</coordinates>';
            $kml[] = ' </Point>';
            $kml[] = ' </Placemark>';
        }

        // End XML file
        $kml[] = ' </Document>';
        $kml[] = '</kml>';
        $kmlOutput = join("\n", $kml);
        header('Content-type: application/vnd.google-earth.kml+xml');
        echo $kmlOutput;
    }
    // public function xls(Request $request){
    //     // return $q;
    //     // $q= DB::select("call get_cantidad_insumos('$request->id')");

    //     $bit= Bitacora::join("ramas as r", "bitacoras.id_rama", "=", "r.id")
    //     ->join("tipo_trabajos as t", "bitacoras.id_tipo_trabajo","=", "t.id")
    //     ->where("bitacoras.id", "=", $request->id)
    //     ->select(["r.id","r.nombre as nomRama", "t.nombre as trabajo"])
    //     ->first();

    //     $q = Insumo::join("evidencias as e", "insumos.id_evidencia", "=","e.id")
    //     ->join("productos as p", "insumos.id_productos", "=","p.id")
    //     ->join("bitacoras as b", "e.id_bitacora", "=","b.id")
    //     ->where("e.id_bitacora", $request->id)
    //     ->where("insumos.status","=","Activo")
    //     ->select(["e.nombre as evidencia","insumos.id_evidencia as idE","p.nombre as producto", "insumos.cantidad"])
    //     ->groupBy('producto')
    //     ->selectRaw('SUM(insumos.cantidad) as total')
    //     ->orderby('producto','asc')
    //     ->get();
    //     // return $q;

    //     $rama = Bitacora::join("ramas as r", "bitacoras.id_rama", "=", "r.id")
    //     ->where("bitacoras.id", "=", $request->id)
    //     ->select("r.id")
    //     ->first();

    //     $spreadsheet = new Spreadsheet();
    //     $spreadsheet->getProperties()->setCreator("JosCir Company & Associates")->setLastModifiedBy("JosCir Company & Associates")->setTitle("Listado de materiales utilizados")           ;
    //     $hoja = $spreadsheet->getActiveSheet();
    //     $hoja->setCellValue('B2', 'Poste');
    //     $contNom = 2;
    //     $cont=3;//para el renglon donde  inicia
    //     for($c = 0; $c<count($q); $c++){
    //         for($i=0; $i<count($q); $i++){//confirma los ids
    //             $cell=$hoja->getCell('A'.$cont)->getValue();//lleva el get value porqu ehay que obtener el valor de la celda
    //             if($cell == $q[$c]->idE){
    //                 for($f = 2; $f < 4; $f++){
    //                     if($f==2){
    //                         $hoja->setCellValue(chr($c+67).$contNom , $q[$c]->producto);//nombre de los productos
    //                     }elseif($f==3){
    //                         $hoja->setCellValue(chr($c+67).$cont, $q[$c]->total);
    //                     }
    //                 }
    //             }
    //         }
    //     $cell=$hoja->getCell('A'.$cont)->getValue();//lleva el get value porqu ehay que obtener el valor de la celda
    //     if($cell != $q[$c]->idE){
    //         $hoja->setCellValue('A'.$cont, $q[$c]->idE);
    //         $hoja->setCellValue('B'.$cont, $q[$c]->evidencia);
    //             for($f = 2; $f < 4; $f++){
    //                 if($f==2){
    //                     $hoja->setCellValue(chr($c+67).$contNom , $q[$c]->producto);//nombre de los productos
    //                 }elseif($f==3){
    //                     $hoja->setCellValue(chr($c+67).$cont, $q[$c]->total);
    //                 }
    //             }
    //         }
    //     }
    //     //Total ultima fila, por renglon
    //     $hoja->setCellValue(chr($c+67).'2', 'Total' );
    //     for($j = 3; $j <= $cont; $j++) {
    //         $letra=67;
    //         $hoja->setCellValue(chr($c+67).$j, '=SUBTOTAL(109,'.chr($letra).$cont.':'.chr($c+67).$j.')');
    //         $letra++;
    //     }

    //     #encabezado
    //     $hoja->setCellValue("A1", "Lista de productos ".$bit->nomRama."_".$bit->trabajo);
    //     $hoja->mergeCells('A1:'.chr($c+67).'1');
    //     $hoja->getStyle('B2:'.chr($c+67).'2')->getFont()->setBold(true);//negritas del producto
    //     $hoja->getStyle('A1:'.chr($c+67).'1')->getFont()->setBold(true);//negritas de titulo
    //     $hoja->getStyle('A1:'.chr($c+67).'1')->getAlignment()->setHorizontal('center');
    //     $hoja->setAutoFilter('B2:'.chr($c+67).'2');//filtros al principio

    //     foreach (range('A', chr($c+67)) as $col){
    //         $hoja->getColumnDimension($col)->setAutoSize(true);
    //     }
        
    //     // $hoja->getStyle('A1:'.chr($c+65).'1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    //     // ->getStartColor()->setARGB('FFFF0000');//color solido
    //     // $styleArray = [
    //     //     'fill' => [
    //     //         'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
    //     //         'rotation' => 90,
    //     //         'startColor' => [
    //     //             'argb' => 'FFA0A0A0',
    //     //         ]
    //     //         ]];//hace un gradiente
    //     // $styleArray = [
    //     //     'borders' => [
    //     //         'outline' => [
    //     //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
    //     //             'color' => ['argb' => 'FFFF0000'],
    //     //         ],
    //     //     ],
    //     // ];//borde rojo solido
    //     // $spreadsheet->getActiveSheet()->getStyle('A1:A8')->applyFromArray($styleArray);
    //     // $spreadsheet->getActiveSheet()->getColumnDimension('E')->setOutlineLevel(1);//esconde una columna dejando la indicacion en el encabezado para abrirla
    //     $writer = new Xlsx($spreadsheet);
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet charset=utf-8');
    //     header('Content-Disposition: attachment; filename="inventario_'.$bit->nomRama.'_'.$bit->trabajo.'.xlsx"');
    //     $writer->save("php://output");
    //     // para calcular el total
    //     // $spreadsheet->addNamedRange( new \PhpOffice\PhpSpreadsheet\NamedRange('COLUMN_TOTAL', $worksheet, '=A$2:A$4') );

    //     // $spreadsheet->getActiveSheet()
    //     // ->setCellValue('B6', '=SUBTOTAL(109,COLUMN_TOTAL)')
    //     // ->setCellValue('D6', '=SUBTOTAL(109,COLUMN_TOTAL)')
    //     // ->setCellValue('E6', '=SUBTOTAL(109,COLUMN_TOTAL)')
    //     // ->setCellValue('F6', '=SUBTOTAL(109,COLUMN_TOTAL)');
    // }
public function xls(Request $request){
    $bit= Bitacora::join("ramas as r", "bitacoras.id_rama", "=", "r.id")
    ->join("tipo_trabajos as t", "bitacoras.id_tipo_trabajo","=", "t.id")
    ->where("bitacoras.id", "=", $request->id)
    ->select(["r.id","r.nombre as nomRama", "t.nombre as trabajo"])
    ->first();

        $q = Insumo::join("evidencias as e", "insumos.id_evidencia", "=", "e.id")
            ->join("productos as p", "insumos.id_productos", "=", "p.id")
            ->join("bitacoras as b", "e.id_bitacora", "=", "b.id")
            ->where("b.id", $request->id)
            ->where("insumos.status", "=", "Activo")
            ->select(["e.nombre as evidencia", "insumos.id_evidencia as idE", "p.nombre as producto"])
            ->groupBy(['producto', 'evidencia', 'idE'])
            ->selectRaw('SUM(insumos.cantidad) as total')
            ->get();

    $rama = Bitacora::join("ramas as r", "bitacoras.id_rama", "=", "r.id")
    ->where("bitacoras.id", "=", $request->id)
    ->select("r.id")
    ->first();

  $spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator("JosCir Company & Associates")->setLastModifiedBy("JosCir Company & Associates")->setTitle("Listado de materiales utilizados");
$hoja = $spreadsheet->getActiveSheet();
$hoja->setCellValue('A2', '#');
$hoja->setCellValue('B2', 'Nombre de la evidencia');
$contNom = 2;
$cont=3;//para el renglon donde inicia

// Create an array to store the values of idE and evidencia
$evidenciaArray = [];

for($c = 0; $c<count($q); $c++){
$cell=$hoja->getCell('A'.$cont)->getValue();
if(!in_array([$q[$c]->idE, $q[$c]->evidencia], $evidenciaArray)){
$evidenciaArray[] = [$q[$c]->idE, $q[$c]->evidencia];
$hoja->setCellValue('A'.$cont, $q[$c]->idE);
$hoja->setCellValue('B'.$cont, $q[$c]->evidencia);
$cont++;
}
}

// Loop through the $evidenciaArray to get the values of idE and evidencia
$startRow = 3;
foreach ($evidenciaArray as $evidencia) {
$idE = $evidencia[0];
$evidenciaName = $evidencia[1];
$products = Insumo::join("evidencias as e", "insumos.id_evidencia", "=", "e.id")
->join("productos as p", "insumos.id_productos", "=", "p.id")
->join("bitacoras as b", "e.id_bitacora", "=", "b.id")
->where("b.id", $request->id)
->where("insumos.status", "=", "Activo")
->where("e.id", $idE)
->where("e.nombre", $evidenciaName)
->groupBy(['producto'])
->selectRaw('p.nombre as producto, SUM(insumos.cantidad) as total')
->get();
$sumRow2 = $cont + 1;
$sumRow = $cont;
$column = 0;
foreach ($products as $product) {
if ($column > 25) {
$column = $column % 26;
}
$hoja->setCellValue(chr($column + 67) . $contNom, $product->producto);
$hoja->setCellValue(chr($column + 67) . $startRow, $product->total);
$hoja->setCellValue(chr($column + 67) . $sumRow, "=SUM(" . chr($column + 67) . "3:" . chr($column + 67) . ($cont - 1) . ")");
$column++;
}
$startRow++;
}

        $hoja->setCellValue(chr($column + 67) . '2', 'Total');
        for ($j = 3; $j <= $cont; $j++) {
            $letra = 67;
            $hoja->setCellValue(chr($column + 67) . $j, '=SUM(' . chr($letra) . $j . ':' . chr($column + 66) . $j . ')');

            $letra++;
        }
      
    #encabezado
    $hoja->setCellValue("A1", "Lista de materiales ".$bit->nomRama."_".$bit->trabajo);
    $hoja->mergeCells('A1:'.chr($column+67).'1');
    $hoja->getStyle('B2:'.chr($column+67).'2')->getFont()->setBold(true);//
    $hoja->getStyle('B2:'.chr($column+67).'2')->getFont()->setBold(true);//negritas del producto
    $hoja->getStyle('A1:'.chr($column+67).'1')->getFont()->setBold(true);//negritas de titulo
    $hoja->getStyle('A1:'.chr($column+67).'1')->getAlignment()->setHorizontal('center');
    $hoja->setAutoFilter('B2:'.chr($column+67).'2');//filtros al principio

        foreach (range('A', chr($column + 67)) as $col) {
            $hoja->getColumnDimension($col)->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Listado de materiales utilizados.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

}

}