<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Administrador;
use App\Models\User;
use App\Models\Bitacora;
use App\Models\Rama;
use App\Models\TipoTrabajo;
use App\Models\Lider;
use App\Models\Icono;
use App\Models\Trabajo;
use App\Models\Cliente;
use App\Models\MaterialBitacora;
use App\Models\Inventario;
use App\Models\Insumo;
use App\Models\Evidencia;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class AdministradoresController extends Controller
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
        //Listamos todos los Administradores
        return DB::select("call getAdmin_user()");
    }
    public function indexWeb(){
        return view ('content.administrador.adminAdmin',[
          "title" => "Dashboard |Administradores",
          "response" => self::index(),
          "usuarios" => User::leftJoin('administradores', 'usuarios.id', '=', 'administradores.id_usuario')
          ->leftJoin('gerentes', 'usuarios.id', '=', 'gerentes.id_usuario')
          ->leftJoin('supervisores', 'usuarios.id', '=', 'supervisores.id_usuario')
          ->leftJoin('lideres', 'usuarios.id', '=', 'lideres.id_usuario')
          ->select('usuarios.id', 'usuarios.nombre', 'usuarios.apellido_materno', 'usuarios.apellido_paterno', 'usuarios.correo', 'usuarios.estado')
          ->where('usuarios.correo', 'NOT LIKE', 'ericbp@joscir.com')
          ->whereNull('administradores.id_usuario')
          ->whereNull('gerentes.id_usuario')
          ->whereNull('supervisores.id_usuario')
          ->whereNull('lideres.id_usuario')
          ->get()
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
        $data = $request->only('user');
        $validator = Validator::make($data, [
            'user' => 'required|max:80|string',
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        };
        //sp para traer el idusuario del Administrador
        //$query=DB::select("call getUsuario('$request->correo')");
        //Creamos el Administrador en la BD
        $admin = Administrador::create([
            'id_usuario' => $request->user,
            'status' => 'Activo'
            
        ]);
        //Respuesta en caso de que todo vaya bien.
        // return response()->json([
        //     'message' => 'Administrador regisrado correctamente',
        //     'data' => $admin
        // ], Response::HTTP_OK);
       return redirect()->route('adminList');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrador  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Bucamos al Administrador
        $admin = Administrador::find($id);
        //Si el Administrador no existe devolvemos error no encontrado
        if (!$admin) {
            return response()->json([
                'message' => 'Administrador no encontrado'
            ], 404);
        }
        //Si hay Administrador lo devolvemos
        return $admin;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administrador  $admin
     * @return \Illuminate\Http\Response
     */
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id', 'edo');
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'edo' => 'required|max:50|string',
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //sp para traer el idusuario del administrador
        //$query=DB::select("call getAdmin('$request->correo')");
        //Buscamos el administrador
        $admin = Administrador::findOrfail($request->edit_id);
        //Actualizamos el administrador.
        $admin->update([
            'status' => $request->edo,
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Los datos del administrador se modificaron',
        //     'data' => $admin
        // ], Response::HTTP_OK);
        return redirect()->route('adminList');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrador  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroyWeb(Request $request)
    {
        //Validamos los datos
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
        //sp para traer el idusuario del Administrador
        //$query=DB::select("call getAdministrador('$request->correo')");
        //Buscamos al Administrador
        $admin = Administrador::findOrfail($request->del_id);
        //Eliminamos el Administrador
        $admin->update(['status'=> 'Inactivo']);
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'El Administrador fue eliminado correctamente'
        // ], Response::HTTP_OK);
        return redirect()->route('adminList');
    }

     public function selectsAdmin(){
        $ubicaciones=Bitacora::select('ciudad','estado')->distinct()->orderby('estado')->get();
        $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->where('tipo_trabajos.status', 'Activo')->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        $lid = DB::select('call getLider_user()');
        return view('content.administrador.registrosAdmin',[
            'title'=>'Dashboard | Registros de las bitácoras',
            'ramas'=>Rama::where('status', 'Activo')->orderby('id')->get(),
            'lideres' => $lid,
            'tipos'=>$tipoT,
            'ubicaciones'=>$ubicaciones,
        ]);


    }

    public function getCrearBitacora(Request $request){
        return view ('content.administrador.bitacorasAdmin',[
            'title' => 'Crear Bitácora',
            'tipotrabajo' => TipoTrabajo::where('status','Activo')->get(),
            'ramas' => Rama::where('status','Activo')->get(),
            'lideres'=> DB::select('call getLider_admin()'),
            
        ]);
    }
    
    public function queryAdmin(Request $request)
    {
        $data = $request->only('lider', 'rama','status','ciudad', 'estado',  'trabajo', 'fecha1', 'fecha2');
        $validator = Validator::make($data, [
            'lider' => 'string|nullable',
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
        $bit = DB::select('call getBitacora_filtrotodo("'.$request->lider.'", "'.$request->fecha1.'", "'.$request->fecha2.'", "'.$request->estado.'","'.$request->ciudad.'", "'.$request->status.'", "'.$request->trabajo.'", "'.$request->rama.'")');
        //Si el bitacora no existe devolvemos error no encontrado
        $res['data'] = $bit;
        // return $bit;
        return $bit;
    
    }


    public function storeBitacora(Request $request)
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
        if ($items == [] || $items == null) {
            return redirect()->route('registrosAdmin', [$idBit]);
        } else {
            foreach ($items as $item) {
                DB::table('material_bitacora')->insert([
                    'id_bitacora' => $idBit,
                    'id_productos' => $item,
                    'status' => 'Activo'
                ]);
            }
            return redirect()->route('registrosAdmin', [$idBit]);
        }

    }



    public function deleteBitacora($id){
        $databit = Bitacora::select('bitacoras.id', 'tipo_trabajos.nombre as trabajo', 'ramas.nombre as rama', 'bitacoras.ciudad', 'bitacoras.estado', 'bitacoras.estatus', 'bitacoras.created_at', 'bitacoras.updated_at', 'supervisor_lider.id_lider', 'supervisor_lider.id_supervisor')
            ->join('tipo_trabajos', 'bitacoras.id_tipo_trabajo', '=', 'tipo_trabajos.id')
            ->join('ramas', 'bitacoras.id_rama', '=', 'ramas.id')
            ->join('supervisor_lider', 'bitacoras.id_supervisor_lider', '=', 'supervisor_lider.id')
            ->join('supervisores', 'supervisor_lider.id_supervisor', '=', 'supervisores.id')
            ->join('lideres', 'supervisor_lider.id_lider', '=', 'lideres.id')
            ->join('usuarios', 'lideres.id_usuario', '=', 'usuarios.id')
            ->whereIn('bitacoras.estatus', ['Terminado', 'En progreso'])
            ->where('tipo_trabajos.status', 'Activo')
            ->where('ramas.status', 'Activo')
            ->where('usuarios.estado', 'Activo')
            ->whereIn('supervisor_lider.id_supervisor', function ($query) {
                $query->select('id_supervisor')
                    ->from('supervisor_lider')
                    ->join('lideres', 'lideres.id', '=', 'supervisor_lider.id_lider')
                    ->join('usuarios', 'usuarios.id', '=', 'lideres.id_usuario');
            })
            ->where('bitacoras.id', $id)
            ->get();
            $databit = $databit->first();
            $bit = Bitacora::findOrfail($id);
            $bit->update([
                'estatus' => 'Inactivo',
            ]);
            session()->flash('message', 'La bitácora de la rama: '.$databit->rama.' del tipo de trabajo '.$databit->trabajo.' se ha borrado.' );
            return redirect()->route('registrosAdmin');
        }

        public function updateBitacora(Request $request, $id){
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
            return redirect()->route('editarBtcAdminVista', ['id' => $id]);
        } else {
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
            return redirect()->route('editarBtcAdminVista', ['id' => $id]);
        }
        }

    public function updateBitacoraView($id)
    {
        // retrieve data for the view
        $ttrabajo = Bitacora::join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', "=", "t.id")
            ->where('bitacoras.id', '=', $id)->select('t.nombre as nombre', 'bitacoras.ciudad as ciudad', 'bitacoras.estado as estado', 'bitacoras.estatus')->get();
        $rama = Bitacora::join('ramas', 'bitacoras.id_rama', "=", "ramas.id")
            ->where('bitacoras.id', '=', $id)->select('ramas.nombre as nombre', 'ramas.id')->get();

        $lider = Bitacora::select((DB::raw("concat_ws(' ',usuarios.nombre, usuarios.apellido_paterno,usuarios.apellido_materno) as nombre")))
            ->join('tipo_trabajos', 'bitacoras.id_tipo_trabajo', '=', 'tipo_trabajos.id')
            ->join('ramas', 'bitacoras.id_rama', '=', 'ramas.id')
            ->join('supervisor_lider', 'bitacoras.id_supervisor_lider', '=', 'supervisor_lider.id')
            ->join('supervisores', 'supervisor_lider.id_supervisor', '=', 'supervisores.id')
            ->join('lideres', 'supervisor_lider.id_lider', '=', 'lideres.id')
            ->join('usuarios', 'lideres.id_usuario', '=', 'usuarios.id')
            ->whereIn('bitacoras.estatus', ['Terminado', 'En progreso'])
            ->where('ramas.status', '=', 'Activo')
            ->where('usuarios.estado', '=', 'Activo')
            ->whereIn('supervisor_lider.id_supervisor', function ($query) {
                $query->select('id_supervisor')
                    ->from('supervisor_lider')
                    ->join('lideres', 'lideres.id', '=', 'supervisor_lider.id_lider')
                    ->join('usuarios', 'usuarios.id', '=', 'lideres.id_usuario');
            })
            ->where('bitacoras.id', '=', $id)->get();


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

        return view('content.administrador.modificarBitacoraAdmin', [
            'title' => 'Modificar registro',
            'tipotrabajo' => TipoTrabajo::get(),
            'ttrabajo' => $ttrabajo,
            'rama' => $rama,
            'lid' => $lider,
            'estatus' => $ttrabajo,
            'ramas' => Rama::get(),
            'lideres' => DB::select('call getLider_user()'),
            'id_bitacora' => $id,
            'selectedCheckboxes' => $selectedCheckboxes,
            'selectedCheckboxesIds' => $selectedCheckboxesIds,
            'inventario' => $inventario
        ]);
    }

    public function updateEvidencia(Request $request){
  
        // Validate the data from the form

        $validator = Validator::make($request->all(), [
            'id' => 'required|int',
            'nombre' => 'required|string',
            'idprods.*' => 'required_with:cantmat.*',
            'cantmat.*' => 'required_with:idprods.*|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        $id = $request->input('id');
        // Retrieve the evidence from the database
        $evidencia = Evidencia::find($id);
        // Update the fields with the data from the form
        $evidencia->nombre = $request->input('nombre');
        $evidencia->descripcion = $request->input('descripcion');

        // Update the related records in the insumos table if idprods and cantmat arrays are present
        if ($request->has('idprods') && $request->has('cantmat')) {
            $idprods = $request->input('idprods');
            $cantmat = $request->input('cantmat');
            for ($i = 0; $i < count($idprods); $i++) {
                $insumo = Insumo::where('id_evidencia', $id)->where('id_productos', $idprods[$i])->first();
                $insumo->cantidad = $cantmat[$i];
                $insumo->save();
            }
        }

        // Save the changes to the evidence table
        $evidencia->save();

        // Redirect the user to the appropriate page
        return redirect()->route('EvidenciaAdmin', $id)->with('message', 'Evidencia actualizada correctamente');
    }

    public function deleteEvidencia($id, $idbit)
    {
        $evi = Evidencia::findOrfail($id);
        $evi->update([
            'status' => 'Inactivo'
        ]);
        return redirect('/admin/gallery/' . $idbit)->with('messagedelete', 'Evidencia borrada correctamente');
    }
    }
     
