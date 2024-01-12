<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BitacorasWebController;
use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\NavegacionWebController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ContactoClienteController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\GerenteSupWebController;
use App\Http\Controllers\GerenteSupervisoresController;
use App\Http\Controllers\InvitadosController;
use App\Http\Controllers\GerentesController;
use App\Http\Controllers\TrabajosController;
use App\Http\Controllers\EvidenciasController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProductosWebController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\IconosWebController;
use App\Http\Controllers\IconosController;
use App\Http\Controllers\InsumosWebController;
use App\Http\Controllers\InventariosController;
use App\Http\Controllers\TrabajosWebController;
use App\Http\Controllers\InvitadosWebController;
use App\Http\Controllers\RamasController;
use App\Http\Controllers\SupLiderWebController;
use App\Http\Controllers\UsuariosWebController;
use App\Http\Controllers\RecuperaContraseñaController;
use App\Http\Controllers\SupervisoresController;
use App\Http\Controllers\LideresController;
use App\Http\Controllers\SupervisorLideresController;
use App\Http\Controllers\BitacorasController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\TipoTrabajoController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [NavegacionWebController::class, 'index'])->name('index');
Route::get('/galeria', [NavegacionWebController::class, 'galeria'])->name('galeria');
Route::get('/servicios', [NavegacionWebController::class, 'servicios'])->name('servicios');
Route::get('/contacto', [ContactoController::class, 'contacto'])->name('contacto');
Route::post('/enviar_mensaje',[ContactoController::class, 'enviarCorreo'])->name('Contacto.Enviado');
Route::get('/login', [UsuariosWebController::class, 'Login'])->name('login');//web, vista
Route::post('/dash', [UsuariosWebController::class, 'logApi'])->name('loginApi');//recibe datos api
Route::get('/inicio',[UsuariosWebController::class, 'inicio'])->name('inicio');//
Route::get('/registro', [UsuariosWebController::class, 'registro'])->name('registro');
Route::post('/reg', [UsuariosWebController::class, 'registroLog'])->name('registroLog');
Route::get('/logout', [UsuariosWebController::class, 'logout'])->name('logout');//solo regresa vista
Route::get('/noAutorizado',[UsuariosWebController::class, 'error'])->name('NA');
// InvitadosWebController//ruta idiomas
Route::get('/RC', [RecuperaContraseñaController::class, 'RC'])->name('RC');
Route::get('/RCDos', [RecuperaContraseñaController::class, 'RCDos'])->name('RCDos');

//ruta idiomas
Route::get('locale/{locale}', function($locale){
    session()->put('locale', $locale);
    return Redirect::back();
});
//RUTAS USUARIOS
Route::prefix('user/')->group(function(){
    Route::get('lista', [AuthController::class, 'indexWeb'])->name('listaUser');
    Route::get('nav', [UsuariosWebController::class, 'nav']);
    Route::post('/reg', [AuthController::class, 'registerWeb'])->name('registroApi');
    Route::post('/updt', [AuthController::class, 'updateWeb'])->name('editApi');
    Route::put('/del', [AuthController::class, 'destroyWeb'])->name('delApi');
});

//RUTAS ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/list', [AdministradoresController::class, 'indexWeb'])->name('adminList');
    Route::post('/reg', [AdministradoresController::class, 'storeWeb'])->name('regAdmin');
    Route::post('/updt', [AdministradoresController::class, 'updateWeb'])->name('editAdmin');
    Route::put('/list', [AdministradoresController::class, 'destroyWeb'])->name('delAdmin');
    Route::post('/type', [UsuariosWebController::class, 'updateWeb'])->name('editTipo');
    Route::get('/inicio',[UsuariosWebController::class, 'inicioAdmin'])->name('inicioAdmin');
    Route::get('/registros',[AdministradoresController::class,'selectsAdmin'])->name('registrosAdmin');
     Route::post('/query',[AdministradoresController::class, 'queryAdmin'])->name('queryAdmin');
      Route::get('/gallery/{id}',[EvidenciasController::class, 'galeriaAdmin']);
    Route::get('/evidencia/{id}', [EvidenciasController::class, 'showAdmin'])->name('EvidenciaAdmin');
    Route::get('/bit', [AdministradoresController::class, 'getCrearBitacora'])->name('getCrearBitacora');
    Route::put('/bit/del/{id}',[AdministradoresController::class, 'deleteBitacora'])->name('borrarBtcAdmin');
    Route::put('/bit/mod/{id}',[AdministradoresController::class, 'updateBitacora'])->name('editarBtcAdmin');
    Route::get('/bitview/mod/{id}',[AdministradoresController::class,'updateBitacoraView'])->name('editarBtcAdminVista');
    Route::get('/bit/view/{id}',[BitacorasController::class, 'viewFotoAdmin'])->name('viewFotoAdmin');
    Route::put('/updtev', [AdministradoresController::class, 'updateEvidencia'])->name('modEviAdmin');
    Route::put('/del/{id}/{idbit}', [AdministradoresController::class, 'deleteEvidencia'])->name('delEviAdmin');
    /*Route::get('/view/{id}',[BitacorasController::class, 'viewFoto'])->name('view');
    Route::get('/mod/{id}', [BitacorasController::class, 'updtWeb'])->name('updtWeb');
    Route::put('/mod/{id}', [BitacorasController::class, 'editarBitacora'])->name('modificarWeb');
    Route::get('/delV/{id}', [BitacorasController::class, 'verborrarBitacora'])->name('borrarWeb');
    Route::put('/del/{id}', [BitacorasController::class, 'borrarBitacora'])->name('borrarBitacora'); */

});
//RUTAS Lider
Route::prefix('lid')->group(function () {
    Route::get('/inicio',[UsuariosWebController::class, 'inicioLider'])->name('inicioLider');
    Route::get('/list',[LideresController::class,'indexWeb'])->name('listaLideresAdmin');
    Route::post('/reg',[LideresController::class, 'storeWeb'])->name('lideresRegAdmin');
    Route::put('/update',[LideresController::class,'updateWeb'])->name('updateLiderAdmin');
    Route::put('/deleteLidSup', [LideresController::class, 'destroyWeb'])->name('deleteLiderAdmin');

});

//RUTAS PRODUCTOS
Route::prefix('prod')->group(function () {
    Route::get('/list', [ProductosController::class, 'indexWeb'])->name('prodVistaAdmin');
    Route::post('/register', [ProductosController::class, 'storeWeb'])->name('registroProd');
    Route::put('/delete', [ProductosController::class, 'destroyWeb'])->name('delProd');
    Route::post('/update', [ProductosController::class, 'updateWeb'])->name('editProd');
});

//RUTAS SUPERVISORES
Route::prefix('sup')->group(function () {
    Route::get('/list', [SupervisoresController::class, 'indexWeb'])->name('supervisoresAdmin');
    Route::post('/reg',[SupervisoresController::class, 'storeWeb'])->name('supervisoresRegAdmin');
    Route::put('/updt', [SupervisoresController::class, 'updateWeb'])->name('supervisoresUpdateAdmin');
    Route::put('/del', [SupervisoresController::class, 'destroyWeb'])->name('supervisoresDelete');
    Route::get('/inicio',[UsuariosWebController::class, 'inicioSup'])->name('inicioSup');
     Route::get('/registros',[SupervisoresController::class,'selectsSup'])->name('registrosSup');
     Route::post('/query',[SupervisoresController::class, 'querySup'])->name('querySup');
       Route::get('/gallery/{id}',[EvidenciasController::class, 'galeriaSup']);
});

//RUTAS ICONOS
Route::prefix('icon')->group(function () {
    Route::get('/list', [IconosController::class, 'indexWeb'])->name('iconosListAdmin');
    Route::post('/register', [IconosController::class, 'storeWeb'])->name('regIcon');
    Route::put('/delete', [IconosController::class, 'destroyWeb'])->name('delIcon');
    Route::post('/update', [IconosController::class, 'updateWeb'])->name('editIcon');

});

//RUTAS TRABAJOS
Route::prefix('trab')->group(function () {
    Route::get('/list', [TrabajosController::class, 'indexWeb'])->name('trabListAdmin');
    Route::post('/register', [TrabajosController::class, 'storeWeb'])->name('regTrab');
    Route::put('/update', [TrabajosController::class, 'updateWeb'])->name('editTrab');
    Route::put('/delete', [TrabajosController::class, 'destroyWeb'])->name('delTrab');
});

//RUTAS GERENTESs
Route::prefix('ger')->group(function () {
    //Route::get('/list', [GerentesWebController::class, 'inicio'])->name('gerListAdmin');
    Route::get('/list', [GerentesController::class, 'indexWeb'])->name('gerListAdmin');
    Route::post('/updt', [GerentesController::class, 'updateWeb'])->name('editGerente');
    Route::post('/reg',[GerentesController::class, 'storeWeb'])->name('registroGerente');
    Route::put('/del', [GerentesController::class, 'destroyWeb'])->name('delGerente');

    Route::get('/inicio',[GerentesController::class, 'inicio'])->name('inicioGer');
    Route::get('/test2',[GerentesController::class, 'test2'])->name('test2');
        Route::get('/registros',[GerentesController::class,'selectsGerente'])->name('registrosGerente');
    Route::post('/query',[GerentesController::class, 'queryGerente'])->name('queryGerente');
    Route::get('/gallery/{id}',[EvidenciasController::class, 'galeriaGerente']);
    Route::get('/evidencia/{id}', [EvidenciasController::class, 'showGerente'])->name('EvidenciaGerente');
});

//RUTAS INVITADOS
Route::prefix('inv')->group(function () {
    Route::get('/list', [InvitadosController::class, 'indexWeb'])->name('invitadoAdmin');
    Route::post('/reg',[InvitadosController::class, 'RegisterWeb'])->name('registroInvitado');
    Route::put('/updt', [InvitadosController::class, 'updateWeb'])->name('editarInvitado');
    Route::put('/del', [InvitadosController::class, 'destroyWeb'])->name('delInvitado');
    Route::get('/inicio',[InvitadosController::class,'selectsInvitado'])->name('registrosInvitado');
    Route::post('/query',[InvitadosController::class, 'queryInvitado'])->name('queryInvitado');
     //Route::get('/inicio', [InvitadosController::class, 'inicio']);
    Route::get('/gallery/{id}',[EvidenciasController::class, 'galeriaInvitado']);
    Route::get('/evidencia/{id}', [EvidenciasController::class, 'showInvitado'])->name('EvidenciaInv');
});

Route::prefix('cliente')->group(function () {
    Route::get('/list', [ClienteController::class, 'indexWeb'])->name('clienListAdmin');
    Route::post('/edit', [ClienteController::class, 'updateWeb'])->name('editCliente');
    Route::post('/register', [ClienteController::class, 'storeWeb'])->name('regCliente');
    Route::put('/delete', [ClienteController::class, 'destroyWeb'])->name('delCliente');
});

Route::prefix('concli')->group(function () {
    Route::get('/list', [ContactoClienteController::class, 'indexWeb'])->name('concliListAdmin');
    Route::post('/edit', [ContactoClienteController::class, 'updateWeb'])->name('editConcli');
    Route::post('/register', [ContactoClienteController::class, 'storeWeb'])->name('regConcli');
    Route::put('/delete', [ContactoClienteController::class, 'destroyWeb'])->name('delConcli');
});

//RUTAS RAMAS
Route::prefix('rama')->group(function () {
    Route::get('/list', [RamasController::class, 'indexWeb'])->name('ramasAdmin');
    Route::post('/reg',[RamasController::class, 'storeWeb'])->name('registroRama');
    Route::put('/updt', [RamasController::class, 'updateWeb'])->name('editarRama');
    Route::delete('/del', [RamasController::class, 'destroyWeb'])->name('delRama');
    Route::get('/listg', [RamasController::class, 'indexWebGerente'])->name('ramasGer');
});

//RUTAS INVENTARIOS
Route::prefix('invent')->group(function () {
    Route::get('/lista', [InventariosController::class, 'indexWeb'])->name('listaInventario');
    Route::post('/reg',[InventariosController::class, 'storeWeb'])->name('addInventario');
    Route::put('/updt', [InventariosController::class, 'updateWeb'])->name('updateInventario');
    Route::delete('/del', [InventariosController::class, 'destroyWeb'])->name('destroyInventario');
    Route::post('/rama',[BitacorasController::class, 'inventario_rama'])->name('inventRama');
    Route::post('/filter', [InventariosController::class, 'getProductos_Rama'])->name('filtroInvProd');
});

//RUTAS GERENTE_SUPERVISOR
Route::prefix('gersup')->group(function () {
    Route::get('/list', [GerenteSupervisoresController::class, 'indexWeb'])->name('gersupLista');
    Route::post('/reg',[GerenteSupervisoresController::class, 'storeWeb'])->name('regGerSup');
    Route::put('/updt', [GerenteSupervisoresController::class, 'updateWeb'])->name('editGerSup');
    Route::delete('/del', [GerenteSupervisoresController::class, 'destroyWeb'])->name('delGerSup');

    Route::post('/mail',[GerenteSupervisoresController::class, 'getCorreo'])->name('postGer');


});

//RUTAS SUPERVISOR_LIDER
Route::prefix('suplid')->group(function () {
    Route::get('/list', [SupervisorLideresController::class, 'indexWeb'])->name('suplidLista');
    Route::post('/reg',[SupervisorLideresController::class, 'storeWeb'])->name('regSuplid');
    Route::put('/updt', [SupervisorLideresController::class, 'updateWeb'])->name('editSuplid');
    Route::delete('/del', [SupervisorLideresController::class, 'destroyWeb'])->name('delSuplid');

    Route::post('/mail',[SupervisorLideresController::class, 'getCorreo'])->name('postSup');
});

//RUTAS INVENTARIOS
Route::prefix('tipotrab')->group(function () {
    Route::get('/list', [TipoTrabajoController::class, 'indexWeb'])->name('tipotrabAdmin');
    Route::post('/reg', [TipoTrabajoController::class, 'storeWeb'])->name('regTipoTrab');
    Route::put('/edit', [TipoTrabajoController::class, 'updateWeb'])->name('editTipoTrab');
    Route::put('/del', [TipoTrabajoController::class, 'destroyWeb'])->name('delTipoTrab');
});

//RUTAS BITACORAS
Route::prefix('bit')->group(function () {
    Route::get('/list', [BitacorasController::class, 'indexWeb'])->name('bitacoraList');

    Route::get('/mod/{id}', [BitacorasController::class, 'updtWeb'])->name('updtWeb');
    Route::put('/mod/{id}', [BitacorasController::class, 'editarBitacora'])->name('modificarWeb');
    Route::get('/delV/{id}', [BitacorasController::class, 'verborrarBitacora'])->name('borrarWeb');
    Route::put('/del/{id}', [BitacorasController::class, 'borrarBitacora'])->name('borrarBitacora');
    Route::post('/regBitMat', [BitacorasController::class, 'materiales_bitacora'])->name('matxbit');
    Route::post('/reg', [BitacorasController::class, 'storeWeb'])->name('regBitacora');
    //Route::get('/reg', [BitacorasController::class, 'storeWeb'])->name('regBitacora');
    Route::get('/show', [BitacorasController::class, 'showList'])->name('showBitacora');
    Route::post('/mail',[BitacorasController::class, 'getCorreo'])->name('postLid');
    Route::get('/view/{id}',[BitacorasController::class, 'viewFoto'])->name('view');
     Route::get('/view/ger/{id}',[BitacorasController::class, 'viewFotoGerente'])->name('viewGer');
    Route::get('/cards', [BitacorasController::class, 'cards'])->name('cardsBitacoraDos');
    Route::post('/filtrar', [BitacorasController::class, 'filtro'])->name('filtroBitacora');
    Route::get('/select',[BitacorasController::class, 'select'])->name('selectBitacora');
    Route::post('/query',[BitacorasController::class, 'query'])->name('query');
    Route::post('/kml',[BitacorasController::class, 'crearkml'])->name('kml');
    Route::post('/xls',[BitacorasController::class, 'xls'])->name('xls');
});
//RUTAS EVIDENCIAS
Route::prefix('ev')->group(function () {
    Route::put('/updt', [EvidenciasController::class, 'updtWeb'])->name('modEvi');//cambio
    Route::put('/del/{id}/{idbit}', [EvidenciasController::class, 'delWeb'])->name('delEvi');
    Route::get('/updtW/{id}/{idbit}', [EvidenciasController::class, 'updtView'])->name('modWeb');//vista
    Route::get('/list', [EvidenciasController::class, 'cards'])->name('testCards');
    Route::post('/coords', [EvidenciasController::class, 'getCoords'])->name('getCoords');
    Route::post('/upload', [EvidenciasController::class, 'storeWeb'])->name('regEvidencia');
    Route::post('/get/{bit}', [EvidenciasController::class, 'Ev_bitacora'])->name('pruebaEloquent');
    Route::get('/listado',[EvidenciasController::class, 'evView']);
    Route::get('/gallery/{id}',[EvidenciasController::class, 'galeria'])->name('gallery');
    //Route::get('/gallery/ins/{id}',[EvidenciasController::class, 'insumo']);
    Route::post('/gallery/ins/',[EvidenciasController::class, 'insumo'])->name('insum');
    Route::get('/get/{id}', [EvidenciasController::class, 'show'])->name('getFotoEv');
});

//RUTAS INSUMOS
Route::prefix('insm')->group(function () {
    Route::get('/list', [InsumosWebController::class, 'index']);
    Route::post('/reg/{trab}/{rama}/{clid}/{ciu}/{esta}/{cprod}/{cant}',[InsumosWebController::class, 'store']);
    Route::put('/updt/{trab}/{rama}/{clid}/{ciu}/{esta}/{cprod}/{cnprod}/{cant}', [InsumosWebController::class, 'update']);
    Route::delete('/del/{id}', [InsumosWebController::class, 'destroy']);
});

//RUTAS EB
Route::prefix('owner')->group(function () {
    Route::get('/inicio', [OwnerController::class, 'inicio'])->name('inicioOwner');
    Route::get('/admin/list', [OwnerController::class, 'admin'])->name('adminOwner');
    Route::get('/ger/list', [OwnerController::class, 'ger'])->name('gerOwner');
    Route::get('/sup/list', [OwnerController::class, 'sup'])->name('supOwner');
    Route::get('/lid/list', [OwnerController::class, 'lid'])->name('lidOwner');
    Route::get('/rama/list', [OwnerController::class, 'rama'])->name('ramaOwner');
    Route::get('/gersup/list', [OwnerController::class, 'gersup'])->name('gersupOwner');
    Route::get('/suplider', [OwnerController::class, 'suplider'])->name('supliderOwner');
    Route::get('/registros',[OwnerController::class,'selects'])->name('registrosOwner');
    Route::post('/query',[OwnerController::class, 'query'])->name('queryOwner');
    Route::get('/trabajos/{tipo}',[OwnerController::class,'tipotrab'])->name('trabajosOwner');
    Route::get('/gallery/{id}',[EvidenciasController::class, 'galeriaOwner']);

    Route::get('/evidencia/{id}', [EvidenciasController::class, 'showOwner'])->name('EvidenciaOwner');
});
//RUTAS DE RECUPERAR CONTRASEÑAS
Route::get('forget-password', [RecuperaContraseñaController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [RecuperaContraseñaController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [RecuperaContraseñaController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [RecuperaContraseñaController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/testToken',[EvidenciasController::class, 'refreshAccessToken']);
?>