<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Evidencia;
use App\Models\Icono;
use App\Models\Insumo;
use Illuminate\Support\Facades\Http;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use App\Models\TipoTrabajo;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Spatie\Dropbox\Client;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class EvidenciasController extends Controller
{
    //
    protected $user;
    public function __construct(Request $request)
    {

        $this->dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
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
        //Listamos todas las evidencias
        return Evidencia::get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function getCoords(Request $request){


    function getGps($exifCoord,  $hemi) {
        $degrees = count($exifCoord) > 0 ? Self::gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? Self::gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? Self::gps2Num($exifCoord[2]) : 0;

        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;
        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }

    function gps2Num($coordPart) {
    $parts = explode('/', $coordPart);
    if (count($parts) <= 0)
        return 0;
    if (count($parts) == 1)
    return $parts[0];
    return floatval($parts[0]) / floatval($parts[1]);
    }

    public function refreshAccessToken(){
    $url = 'https://api.dropbox.com/oauth2/token';
    $key = env('DROPBOX_APP_KEY');
    $secret =env('DROPBOX_APP_SECRET');
    $response = Http::withBasicAuth($key,$secret)->asForm()->post($url,[
      'refresh_token'=> env('DROPBOX_REFRESH_TOKEN'),
      'grant_type'=> 'refresh_token'
    ]);
    $response->object();
    $new_token = $response['access_token'];
    $this->dropbox->setAccessToken($new_token);
    return $new_token;
    }

    public function storeWeb(Request $request)
    {
        //Validamos los datos
        $mats = $request->input('prodmat');
        $cantmats = $request->input('cantmat');
        $data = $request->only('id_bit', 'id_icon', 'descr', 'file', 'nombre');
        $validator = Validator::make($data, [
            'id_bit' => 'required|max:50|string',
            'id_icon' => 'max:50|string|nullable',
            'descr' => 'max:255|string|nullable',
            'nombre' => 'max:255|string|nullable'
            // 'file' => 'required|image|mimes:jpeg,jpg,png',

        ]);
      
        $file = $request->file;
        $data = exif_read_data($request->file);
        $name = $_FILES['file']['name'];

        $ext = $file->getClientOriginalExtension();
        $destination_path = "storage/evidencias";
        //C:\Users\Dell\Desktop\JosCirWeb\public\storage\evidencias
        $filename = $file->getClientOriginalName();
        //dd($data);
        $lat = self::getGps($data["GPSLatitude"], $data['GPSLatitudeRef']);
        $lon = self::getGps($data["GPSLongitude"], $data['GPSLongitudeRef']);
        $alt = self::gps2Num($data["GPSAltitude"]);
        //$file->move(public_path('storage/evidencias'), $filename);
        //dd($file, $ext, $name, $data, $lat, $lon, $alt, $filename);
        //Si falla la validación

        $this->refreshAccessToken();
        // $url = 'https://content.dropboxapi.com/2/files/upload/';
        // $response = Http::withToken($token)->withHeaders([
        //     'Content-Type' => 'application/octet-stream',
        //     'Dropbox-API-Arg'=>'{    
        //         "autorename": true,
        //         "mode": "add",
        //         "mute": false,
        //         "path": "/Img_joscir/'.$filename.'",
        //         "strict_conflict": false}'
        //     ])->withBody($file, $ext)->post($url);
        //Storage::disk('dropbox')->putFileAs('/Img_Joscir/', $file, $filename);
        //$response = $this->dropbox->createSharedLinkWithSettings(
        //    '/Img_joscir/'.$filename,["requested_visibility" => "public"]
        //);
        //$test = '/'
        $photo = fopen($file, 'rb');
        $this->dropbox->upload('/Img_joscir/' . $filename, $photo, $mode = 'add');
        $response2 = $this->dropbox->getTemporaryLink('/Img_joscir/' . $filename);
        //dd($response2, $filename);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //buscamos los datos necesarios con sp's
        // $queryTrab = DB::select("call getTrabajo('$request->nombre_trabajo')");
        // $trab = $queryTrab[0]->id;
        // $queryRama = DB::select("call getRama('$request->nombre_rama')");
        // $rama = $queryRama[0]->id;
        // $queryLid = DB::select("call getLider('$request->correo_lider')");
        // $lider = $queryLid[0]->id;
        // $queryIcon = DB::select("call getIcono('$request->nombre_icono')");
        // //sp de la tabla
        // $queryBit = DB::select("call getBitacora('$trab','$rama','$lider','$request->ciudad','$request->estado')");
        //Creamos la evidencia en la BD
        if ($request->id_icon == null) {
            $icon = null;
        } else {
            $queryIcon = DB::select("call getIcon_name('$request->id_icon')");
            $icon = $queryIcon[0]->nombre;
        }


        $ev = Evidencia::create([
            'id_bitacora' => $request->id_bit,
            'id_icono' => $request->id_icon,
            'foto' => $response2,
            'nombre' => $request->nombre,
            'nombre_foto' => $filename,
            'latitud' => $lat,
            'longitud' => $lon,
            'altitud' => $alt,
            'descripcion' => $request->descr,
            'status' => 'Activo'
        ]);
        $idEv = $ev->id;

        if ($mats == [] || $mats == null) {
            return back()
                ->with('success', 'La imagen se ha subido con exito.')
                ->with('image', $response2)
                ->with('latitud', $lat)
                ->with('longitud', $lon)
                ->with('altitud', $alt)
                ->with('name', $filename);
        } else {
            foreach ($mats as $key => $m) {
                DB::table('insumos')->insert([
                    'id_evidencia' => $idEv,
                    'id_productos' => $m,
                    'cantidad' => $cantmats[$key],
                    'status' => 'Activo',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        
            return back()
                ->with('success', 'La imagen se ha subido con exito.')
                ->with('image', $response2)
                ->with('latitud', $lat)
                ->with('longitud', $lon)
                ->with('altitud', $alt)
                ->with('name', $filename);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Evidencias  $evi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evidencias = DB::select("call get_detalle_evidencia('$id')");
        $this->refreshAccessToken();
        $ev = $evidencias[0];
        $link = $this->dropbox->getTemporaryLink('/Img_joscir/' . $ev->nombre_foto);
        DB::select("call update_evlink('$link','$ev->nombre_foto')");
        $evidencia = $ev;
        $tt = $evidencias[0]->trabajos;
        $idev = $evidencias[0]->id;
        if ($tt == 'Levantamiento Distribución' || $tt == 'Levantamiento Troncal') {
            $insumos = DB::select("call getInsumo_ev('$idev')");
            return view('content.lider.detalleEvidencia', [
                'evidencia' => $evidencia,
                'insumos'=> $insumos,
                'title' => 'Detalle de la evidencia',
            ]);


        } else {
            return view('content.lider.detalleEvidencia', [
                'evidencia' => $evidencia,
                'title' => 'Detalle de la evidencia',
            ]);
        }
    }
    public function showInvitado($id)
    {
        $evidencias = DB::select("call get_detalle_evidencia('$id')");
        $this->refreshAccessToken();
        $ev = $evidencias[0];
        $link = $this->dropbox->getTemporaryLink('/Img_joscir/' . $ev->nombre_foto);
        DB::select("call update_evlink('$link','$ev->nombre_foto')");
        $evidencia = $ev;
        $tt = $evidencias[0]->trabajos;
        $idev = $evidencias[0]->id;
        if ($tt == 'Levantamiento Distribución' || $tt == 'Levantamiento Troncal') {
            $insumos = DB::select("call getInsumo_ev('$idev')");
            return view('content.invitado.detalleregistros', [
                'evidencia' => $evidencia,
                'insumos' => $insumos,
                'title' => 'Detalle de la evidencia',
            ]);


        } else {
            return view('content.lider.detalleEvidencia', [
                'evidencia' => $evidencia,
                'title' => 'Detalle de la evidencia',
            ]);
        }
    }

    public function showAdmin($id)
    {
        $evidencias = DB::select("call get_detalle_evidencia('$id')");
        $this->refreshAccessToken();
        $ev = $evidencias[0];
        $link = $this->dropbox->getTemporaryLink('/Img_joscir/' . $ev->nombre_foto);
        DB::select("call update_evlink('$link','$ev->nombre_foto')");
        $evidencia = $ev;
        $tt = $evidencias[0]->trabajos;
        $idev = $evidencias[0]->id;
        if ($tt == 'Levantamiento Distribución' || $tt == 'Levantamiento Troncal') {
            $insumos = DB::select("call getInsumo_ev('$idev')");
            return view('content.administrador.detalleEvidenciaAdmin', [
                'evidencia' => $evidencia,
                'insumos' => $insumos,
                'title' => 'Detalle de la evidencia',
            ]);


        } else {
            return view('content.administrador.detalleEvidenciaAdmin', [//aqui tenias para mostrar lider .-. soy una pendeja xd AJJAJAJAJA
                'evidencia' => $evidencia,
                'title' => 'Detalle de la evidencia',
            ]);
        }
    }

    public function showOwner($id)
    {
        $tipoT = TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->get(["t.id as idTrab", "t.nombre as nombreTrab", "tipo_trabajos.id as idTipo", "tipo_trabajos.nombre as nomTipo"]);
        $evidencias = DB::select("call get_detalle_evidencia('$id')");
        $this->refreshAccessToken();
        $ev = $evidencias[0];
        $link = $this->dropbox->getTemporaryLink('/Img_joscir/' . $ev->nombre_foto);
        DB::select("call update_evlink('$link','$ev->nombre_foto')");
        $evidencia = $ev;
        $tt = $evidencias[0]->trabajos;
        $idev = $evidencias[0]->id;
        if ($tt == 'Levantamiento Distribución' || $tt == 'Levantamiento Troncal') {
            $insumos = DB::select("call getInsumo_ev('$idev')");
            return view('content.owner.detalleregistros', [
                'evidencia' => $evidencia,
                'insumos' => $insumos,
                'title' => 'Detalle de la evidencia',
                'tipoT' => $tipoT,
            ]);


        } else {
            return view('content.owner.detalleregistros', [
                'evidencia' => $evidencia,
                'title' => 'Detalle de la evidencia',
                'tipoT' => $tipoT,
            ]);
        }
    }
    public function showGerente($id)
    {
        $evidencias = DB::select("call get_detalle_evidencia('$id')");
        $this->refreshAccessToken();
        $ev = $evidencias[0];
        $link = $this->dropbox->getTemporaryLink('/Img_joscir/' . $ev->nombre_foto);
        DB::select("call update_evlink('$link','$ev->nombre_foto')");
        $evidencia = $ev;
        $tt = $evidencias[0]->trabajos;
        $idev = $evidencias[0]->id;
        if ($tt == 'Levantamiento Distribución' || $tt == 'Levantamiento Troncal') {
            $insumos = DB::select("call getInsumo_ev('$idev')");
            return view('content.gerente.detalleEvidencia', [
                'evidencia' => $evidencia,
                'insumos' => $insumos,
                'title' => 'Detalle de la evidencia',
            ]);


        } else {
            return view('content.gerente.detalleEvidencia', [
                'evidencia' => $evidencia,
                'title' => 'Detalle de la evidencia',
            ]);
        }
    }
    public function update(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre_trabajo', 'nombre_rama', 'correo_lider', 'ciudad', 'estado', 'nuevo_icono',  'descripcion');
        $validator = Validator::make($data, [
            'nombre_trabajo' => 'required|max:50|string',
            'nombre_rama' => 'required|max:50|string',
            'correo_lider' => 'required|max:50|string',
            'ciudad' => 'required|max:50|string',
            'estado' => 'required|max:50|string',
            'nuevo_icono' => 'required|max:50|string',
            'descripcion' => 'required|max:100|string',
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
        $icon = $queryIcon[0]->id;
        //sp de la tabla bitacoras
        $queryBit = DB::select("call getBitacora('$trab','$rama','$lider','$request->ciudad','$request->estado')");
        $bit = $queryBit[0]->id;
        //sp de la tabla evidencias
        $query = DB::select("call getEvidencia('$bit')");
        //sp icono
        $queryIcon = DB::select("call getIcono('$request->nuevo_icono')");
        $icon = $queryIcon[0]->id;
        //Buscamos la evidencia
        $evi = Evidencia::findOrfail($query[0]->id);
        //Actualizamos la evidencia.
        $evi->update([
            'id_icono' => $icon,
            'descripcion' => $request->descripcion
        ]);
        //Devolvemos los datos actualizados.
        return response()->json([
            'message' => 'Evidencia actualizada correctamente',
            'data' => $evi
        ], Response::HTTP_OK);
    }
    public function updtWeb(Request $request){ 
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
    return redirect()->route('getFotoEv', $id)->with('message', 'Evidencia actualizada correctamente');
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Evidencia  $evi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Validamos los datos
        $data = $request->only('nombre_trabajo', 'nombre_rama', 'correo_lider', 'ciudad', 'estado', 'descripcion');
        $validator = Validator::make($data, [
            'nombre_trabajo' => 'required|max:50|string',
            'nombre_rama' => 'required|max:50|string',
            'correo_lider' => 'required|max:50|string',
            'ciudad' => 'required|max:50|string',
            'estado' => 'required|max:50|string',
            'descripcion' => 'required|max:100|string',
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
        //sp de la tabla evidencias
        $query = DB::select("call getEvi_des('$bit', '$request->descripcion')");
        //Buscamos la evidencia
        $evi = Evidencia::findOrfail($query[0]->id);
        //Eliminamos la evidencia
        $evi->delete();
        //Devolvemos la respuesta
        return response()->json([
            'message' => 'Evidencia eliminada correctamente'
        ], Response::HTTP_OK);
    }
    public function delWeb($id, $idbit){
        $evi = Evidencia::findOrfail($id);
        $evi->update([
            'status'=>'Inactivo'
        ]);
        return redirect('/ev/gallery/'.$idbit)->with('messagedelete', 'Evidencia borrada correctamente');
    }

    public function updtView($id, $idbit){
        $ev=Evidencia::leftjoin('iconos as i', 'evidencias.id_icono', '=', 'i.id')
        ->select(['evidencias.id','evidencias.id_icono', 'i.nombre as icono', 'evidencias.nombre', 'evidencias.nombre_foto', 'evidencias.foto', 'evidencias.descripcion', 'evidencias.status'])->where('evidencias.id', $id)->first();
        return view('content.lider.modEvidencia',[
            'evidencia'=>$ev,
            'iconos'=>Icono::get(),
            'title'=>'Modificar Evidencia',
            'bitacora'=>$idbit
        ]);
        // return $ev;
    }

    public function cards(){
        return view('content.lider.test_cards',
    [
                'title' => 'cards evidencias',
            ]);
    }
    public function Ev_bitacora($bit){
        $ev_data=Evidencia::join('bitacoras as b','evidencias.id_bitacora', '=', 'b.id')
        ->join('iconos as i', 'evidencias.id_icono', '=', 'i.id')
        ->where('evidencias.id_bitacora', '=', $bit)
        ->get(['i.nombre as icono','i.url as url','evidencias.id','evidencias.nombre as nombre','evidencias.foto','evidencias.latitud','evidencias.longitud','evidencias.altitud', 'evidencias.descripcion','evidencias.status','evidencias.created_at','evidencias.updated_at']);
        return $ev_data;
    }
    public function evView(){
        return view('content.lider.evidencias',[
            'title'=>'Evidencias por bitacora',
        ]);
    }
    public function galeria($id){
        $evidencias = DB::select("call getBit_evidence('$id')");
        $this->refreshAccessToken();
        if(!empty($evidencias)){
            foreach ($evidencias as $ev) {
                $link = $this->dropbox->getTemporaryLink('/Img_joscir/'.$ev->nombre_foto);
                DB::select("call update_evlink('$link','$ev->nombre_foto')");
            }
            $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
            ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
            ->where('bitacoras.id', '=', $id)
            ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
            ->first();
             $e = DB::select("call getBit_evidence('$id')");
            return view('content.lider.gallery',[
                'id_bit'=>$id,
                'title'=> 'Galeria de registros de la bitácora',
                'evidencias'=> $e,
                'bitacora'=>$bit,
                
            ]);
        }else{
            $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
            ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
            ->where('bitacoras.id', '=', $id)
            ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
            ->first();
             $e = DB::select("call getBit_evidence('$id')");
            return view('content.lider.gallery',[
                'id_bit'=>$id,
                'title'=> 'Galeria de registros de la bitácora',
                'evidencias'=> $e,
                'bitacora'=>$bit,
                'message' => 'No existen evidencias'

            ]);
        }
    }


    public function galeriaAdmin($id){
    $evidencias = DB::select("call getBit_evidence('$id')");
        $this->refreshAccessToken();
        if(!empty($evidencias)){
            foreach ($evidencias as $ev) {
                $link = $this->dropbox->getTemporaryLink('/Img_joscir/'.$ev->nombre_foto);
                DB::select("call update_evlink('$link','$ev->nombre_foto')");
            }
            $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
            ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
            ->where('bitacoras.id', '=', $id)
            ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
            ->first();
             $e = DB::select("call getBit_evidence('$id')");
            return view('content.administrador.galeria',[
                'id_bit'=>$id,
                'title'=> 'Galeria de registros de la bitácora',
                'evidencias'=> $e,
                'bitacora'=>$bit,
                
            ]);
        }else{
            $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
            ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
            ->where('bitacoras.id', '=', $id)
            ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
            ->first();
             $e = DB::select("call getBit_evidence('$id')");
            return view('content.administrador.galeria',[
                'id_bit'=>$id,
                'title'=> 'Galeria de registros de la bitácora',
                'evidencias'=> $e,
                'bitacora'=>$bit,
                'message' => 'No existen evidencias'

            ]);
        }
    } 

    public function galeriaGerente($id){
        $evidencias = DB::select("call getBit_evidence('$id')");
        $this->refreshAccessToken();
        //dd($evidencias);
        foreach ($evidencias as $ev) {
            $link = $this->dropbox->getTemporaryLink('/Img_joscir/'.$ev->nombre_foto);
            DB::select("call update_evlink('$link','$ev->nombre_foto')");
        }
        $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
        ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
        ->where('bitacoras.id', '=', $id)
        ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
        ->first();
        return view('content.gerente.galeria',[
            'id_bit'=>$id,
            'title'=> 'Galeria de registros de la bitácora',
            'evidencias'=> DB::select("call getBit_evidence('$id')"),
            'bitacora'=>$bit
        ]);

    }
    public function galeriaInvitado($id){
        $evidencias = DB::select("call getBit_evidence('$id')");
        $this->refreshAccessToken();
        //dd($evidencias);
        foreach ($evidencias as $ev) {
            $link = $this->dropbox->getTemporaryLink('/Img_joscir/'.$ev->nombre_foto);
            DB::select("call update_evlink('$link','$ev->nombre_foto')");
        }
        $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
        ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
        ->where('bitacoras.id', '=', $id)
        ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
        ->first();
        return view('content.invitado.galeria',[
            'id_bit'=>$id,
            'title'=> 'Galeria de registros de la bitácora',
            'evidencias'=> DB::select("call getBit_evidence('$id')"),
            'bitacora'=>$bit
        ]);

    }
    public function galeriaOwner($id){
        // $tipoT=TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->get(["t.id as idTrab","t.nombre as nombreTrab","tipo_trabajos.id as idTipo","tipo_trabajos.nombre as nomTipo"]);
        // $evidencias = DB::select("call getBit_evidence('$id')");
        // $this->refreshAccessToken();
        // //dd($evidencias);
        // foreach ($evidencias as $ev) {
        //     $link = $this->dropbox->getTemporaryLink('/Img_joscir/'.$ev->nombre_foto);
        //     DB::select("call update_evlink('$link','$ev->nombre_foto')");
        // }
        // $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
        // ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
        // ->where('bitacoras.id', '=', $id)
        // ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
        // ->first();
        // return view('content.owner.galeria',[
        //     'id_bit'=>$id,
        //     'title'=> 'Galeria de registros de la bitácora',
        //     'tipoT'=>$tipoT,
        //     'evidencias'=> DB::select("call getBit_evidence('$id')"),
        //     'bitacora'=>$bit
        // ]);
        $tipoT = TipoTrabajo::join("trabajos as t", "tipo_trabajos.id_trabajo", "=", "t.id")->get(["t.id as idTrab", "t.nombre as nombreTrab", "tipo_trabajos.id as idTipo", "tipo_trabajos.nombre as nomTipo"]);
    $evidencias = DB::select("call getBit_evidence('$id')");
        $this->refreshAccessToken();
        if(!empty($evidencias)){
            foreach ($evidencias as $ev) {
                $link = $this->dropbox->getTemporaryLink('/Img_joscir/'.$ev->nombre_foto);
                DB::select("call update_evlink('$link','$ev->nombre_foto')");
            }
            $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
            ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
            ->where('bitacoras.id', '=', $id)
            ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
            ->first();
             $e = DB::select("call getBit_evidence('$id')");
            return view('content.owner.galeria',[
                'id_bit'=>$id,
                'tipoT' => $tipoT,
                'title'=> 'Galeria de registros de la bitácora',
                'evidencias'=> $e,
                'bitacora'=>$bit,
                
            ]);
        }else{
            $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
            ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
            ->where('bitacoras.id', '=', $id)
            ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
            ->first();
             $e = DB::select("call getBit_evidence('$id')");
            return view('content.owner.galeria',[
                'id_bit'=>$id,
                'title'=> 'Galeria de registros de la bitácora',
                'tipoT' => $tipoT,
                'evidencias'=> $e,
                'bitacora'=>$bit,
                'message' => 'No existen evidencias'

            ]);
        }
    
    }
    public function galeriaSup($id){
        $evidencias = DB::select("call getBit_evidence('$id')");
        $this->refreshAccessToken();
        //dd($evidencias);
        foreach ($evidencias as $ev) {
            $link = $this->dropbox->getTemporaryLink('/Img_joscir/'.$ev->nombre_foto);
            DB::select("call update_evlink('$link','$ev->nombre_foto')");
        }
        $bit= Bitacora::join('ramas as r', 'bitacoras.id_rama', '=', 'r.id')
        ->join('tipo_trabajos as t', 'bitacoras.id_tipo_trabajo', '=', 't.id')
        ->where('bitacoras.id', '=', $id)
        ->select(['r.nombre as nomRama', 't.nombre as trab','bitacoras.ciudad', 'bitacoras.estado'])
        ->first();
        return view('content.supervisor.galeria',[
            'id_bit'=>$id,
            'title'=> 'Galeria de registros de la bitácora',
            'evidencias'=> DB::select("call getBit_evidence('$id')"),
            'bitacora'=>$bit
        ]);

    }
    // public function insumo($id){
    //     $insumos = DB::select("call getInsumo_ev('$id')");
    //     return back()
    //         ->with('success','La imagen se ha subido con exito.')
    //         ->with('id_ev', $id)
    //         ->with(['insumos' => $insumos]);
    // }

    public function insumo(Request $request){
        $request->only('id');
        $insumos = DB::select("call getInsumo_ev('$request->id')");
        //$res['insum'] = $insumos;
        return $insumos;

    }
}
