<?php

use App\Http\Controllers\AdministradoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\TrabajosController;
use App\Http\Controllers\IconosController;
use App\Http\Controllers\LideresController;
use App\Http\Controllers\SupervisoresController;
use App\Http\Controllers\InvitadosController;
use App\Http\Controllers\GerentesController;
use App\Http\Controllers\RamasController;
use App\Http\Controllers\GerenteSupervisoresController;
use App\Http\Controllers\SupervisorLideresController;
use App\Http\Controllers\InventariosController;
use App\Http\Controllers\BitacorasController;
use App\Http\Controllers\EvidenciasController;
use App\Http\Controllers\InsumosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//RUTAS USUARIOS
Route::prefix('users')->group(function () {
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/datosUsuario', [AuthController::class, 'datosUsuario']);
    Route::post('/tokenArduino', [AuthController::class, 'traerToken']);
    Route::post('/registro', [AuthController::class, 'register']);
    //Route::group(['middleware' => ['jwt.verify']], function() {
        //Todo lo que este dentro de este grupo requiere verificación de usuario.
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/get-user', [AuthController::class, 'getUser']);
        Route::post('/listaUs', [AuthController::class, 'list'])->name('listajax');        
    //});
});

//RUTAS PRODUCTOS
Route::prefix('prod')->group(function () {
    Route::get('/list', [ProductosController::class, 'index']);
    Route::post('/reg', [ProductosController::class, 'store']);
    Route::put('/updt', [ProductosController::class, 'update']);
    Route::delete('/del', [ProductosController::class, 'destroy']);
    Route::post('/test', [ProductosController::class, 'prueba']);
    Route::post('/test2', [ProductosController::class, 'prueba2']);
});

//RUTAS TRABAJOS
Route::prefix('trab')->group(function () {
    Route::get('/list', [TrabajosController::class, 'index']);//estos son datas
    Route::post('/reg', [TrabajosController::class, 'store']);
    Route::put('/updt', [TrabajosController::class, 'update']);
    Route::delete('/del', [TrabajosController::class, 'destroy']);
    Route::post('/test', [TrabajosController:: class, 'prueba']);
});

//RUTAS ICONOS
Route::prefix('icon')->group(function () {
    Route::get('/list', [IconosController::class, 'index']);
    Route::post('/reg',[IconosController::class, 'store']);
    Route::put('/updt', [IconosController::class, 'update']);
    Route::delete('/del', [IconosController::class, 'destroy']);
});

//RUTAS ADMINISTRADOR
Route::prefix('admin')->group(function () {
    Route::get('/list', [AdministradoresController::class, 'index']);
    Route::post('/reg',[AdministradoresController::class, 'store']);
    Route::put('/updt', [AdministradoresController::class, 'update']);
    Route::delete('/del', [AdministradoresController::class, 'destroy']);
    Route::post('/test', [AdministradoresController::class, 'prueba']);
});

//RUTAS LIDERES
Route::prefix('lid')->group(function () {
    Route::get('/list', [LideresController::class, 'index']);
    Route::post('/reg',[LideresController::class, 'store']);
    Route::put('/updt', [LideresController::class, 'update']);
    Route::delete('/del', [LideresController::class, 'destroy']);
    Route::post('/test', [LideresController::class, 'prueba']);
});

//RUTAS SUPERVISORES
Route::prefix('sup')->group(function () {
    Route::get('/list', [SupervisoresController::class, 'index']);
    Route::post('/reg',[SupervisoresController::class, 'store']);
    Route::put('/updt', [SupervisoresController::class, 'update']);
    Route::delete('/del', [SupervisoresController::class, 'destroy']);
});

//RUTAS INVITADOS
Route::prefix('inv')->group(function () {
    Route::get('/list', [InvitadosController::class, 'index']);
    Route::post('/reg',[InvitadosController::class, 'store']);
    Route::put('/updt', [InvitadosController::class, 'update']);
    Route::delete('/del', [InvitadosController::class, 'destroy']);
    Route::post('/test', [InvitadosController::class, 'prueba']);
});

//RUTAS GERENTES
Route::prefix('ger')->group(function () {
    Route::get('/list', [GerentesController::class, 'index']);
    Route::post('/reg',[GerentesController::class, 'store']);
    Route::put('/updt', [GerentesController::class, 'update']);
    Route::delete('/del', [GerentesController::class, 'destroy']);
});

//RUTAS RAMAS
Route::prefix('rama')->group(function () {
    Route::get('/list', [RamasController::class, 'index']);
    Route::post('/reg',[RamasController::class, 'store']);
    Route::put('/updt', [RamasController::class, 'update']);
    Route::delete('/del', [RamasController::class, 'destroy']);
});

//RUTAS GERENTE_SUPERVISOR
Route::prefix('gersup')->group(function () {
    Route::get('/list', [GerenteSupervisoresController::class, 'index']);
    Route::post('/reg',[GerenteSupervisoresController::class, 'store']);
    Route::put('/updt', [GerenteSupervisoresController::class, 'update']);
    Route::delete('/del', [GerenteSupervisoresController::class, 'destroy']);
});

//RUTAS SUPERVISOR_LIDER
Route::prefix('suplid')->group(function () {
    Route::get('/list', [SupervisorLideresController::class, 'index']);
    Route::post('/reg',[SupervisorLideresController::class, 'store']);
    Route::put('/updt', [SupervisorLideresController::class, 'update']);
    Route::delete('/del', [SupervisorLideresController::class, 'destroy']);
});

//RUTAS INVENTARIOS
Route::prefix('invent')->group(function () {
    Route::get('/list', [InventariosController::class, 'index']);
    Route::post('/reg',[InventariosController::class, 'store']);
    Route::put('/updt', [InventariosController::class, 'update']);
    Route::delete('/del', [InventariosController::class, 'destroy']);
});

//RUTAS BITACORAS
Route::prefix('bit')->group(function () {
    Route::get('/list', [BitacorasController::class, 'index']);
    Route::post('/reg',[BitacorasController::class, 'store']);
    Route::put('/updt', [BitacorasController::class, 'update']);
    Route::delete('/del', [BitacorasController::class, 'destroy']);
    Route::post('/test', [BitacorasController::class, 'prueba'] );
});

//RUTAS EVIDENCIAS
Route::prefix('ev')->group(function () {
    Route::get('/list', [EvidenciasController::class, 'index']);
    Route::post('/reg',[EvidenciasController::class, 'store']);
    Route::put('/updt', [EvidenciasController::class, 'update']);
    Route::delete('/del', [EvidenciasController::class, 'destroy']);
});

//RUTAS INSUMOS
Route::prefix('insm')->group(function () {
    Route::get('/list', [InsumosController::class, 'index']);
    Route::post('/reg',[InsumosController::class, 'store']);
    Route::put('/updt', [InsumosController::class, 'update']);
    Route::delete('/del', [InsumosController::class, 'destroy']);
});