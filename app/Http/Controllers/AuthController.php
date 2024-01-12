<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use JWTAuth;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{   
    public function lista(){
        $url = env('DIR_ROOT')."users/listaUs";
        $response = Http::post($url);
        return $response->object();
    }
     public function SidebarAdmin(){
       return view ('content.administrador.usuarios',[
            "title" => "Ver Usuarios",
            "response" => self::lista()
        ]);
    }
    public function logApi(Request $request){
        $url = env('DIR_ROOT')."users/login";
        $response = Http::post($url,[
            "correo"=>$request->correo,
            "password"=>$request->password
        ]);
        return $response->object();
    }
    
     public function Login(){
        return view('login');
    }
    public function Registro(){
        return view('registro');
    }
    //Función que utilizaremos para registrar al usuario
    public function register(Request $request)
    {
        //Indicamos los datos a recibir en la request
        $data = $request->only('nombre', 'apellido_paterno', 'apellido_materno','correo','telefono','estado', 'password');
        //Realizamos las validaciones
        $validator = Validator::make($data, [
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'required|max:10|string',
            'estado' => 'required|max:15|string',
            'password' => 'required|string|min:6|max:50',
        ]);
        //Devolvemos un error si fallan las validaciones
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el nuevo usuario
        $user = Usuario::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'estado' => $request->estado,
            'password' => bcrypt($request->password)
        ]);
        //Nos guardamos el usuario y la contraseña para realizar la petición de token a JWTAuth
        $credentials = $request->only('correo', 'password');
        //Devolvemos la respuesta con el token del usuario
        return response()->json([
            'message' => 'Usuario registrado',
            'user' => $user
        ], Response::HTTP_OK);
    }
    //Funcion que utilizaremos para hacer login
    public function authenticate(Request $request)
    {
        //Indicamos que solo queremos recibir email y password de la request
        $credentials = $request->only('correo', 'password');
        //Validaciones
        $validator = Validator::make($credentials, [
            'correo' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        //Devolvemos un error de validación en caso de fallo en las verificaciones
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Intentamos hacer login
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                //Credenciales incorrectas.
                return response()->json([
                    'token' => JWTAuth::attempt($credentials),
                    'cred' => $credentials,
                    'validator' => $validator,
                    'message' => 'Login failed 1',
                ], 401);
            }
        } catch (JWTException $e) {
            //Error 
            return response()->json([
                'message' => 'Error',
            ], 500);
        }
        //Devolvemos el token
        return response()->json([
            'token' => $token,
            'user' => Auth::user()
        ]);
    }
    public function datosUsuario(Request $request)
    {
        //Indicamos que solo queremos recibir email y password de la request
        $credentials = $request->only('correo', 'Contraseña');
        //Validaciones
        $validator = Validator::make($credentials, [
            'correo' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);
        //Devolvemos un error de validación en caso de fallo en las verificaciones
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Intentamos hacer login
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                //Credenciales incorrectas.
                return response()->json([
                    'message' => 'Login failed',
                ], 401);
            }
        } catch (JWTException $e) {
            //Error 
            return response()->json([
                'message' => 'Error',
            ], 500);
        }
        $nomUsuario = Auth::user()->nombre;
        $apPUsuario = Auth::user()->apellido_paterno;
        $apMUsuario = Auth::user()->apellido_materno;
        $email = Auth::user()->correo;
        $telefono = Auth::user()->telefono;
        $estado = Auth::user()->estado;
        $contra = Auth::user()->password;

        //Devolvemos el token
        return response()->json([
            'nombre_usuario'=>$nomUsuario,
            'apellido_paterno_usuario'=>$apPUsuario,
            'apellido_materno_usuario'=>$apMUsuario,
            'email'=>$email,
            'telefono'=>$telefono,
            'estado'=>$estado,
            'Contraseña'=>$contra,
        ]);
    }
    //Función que utilizaremos para eliminar el token y desconectar al usuario
    public function logout(Request $request)
    {
        //Validamos que se nos envie el token
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);
        //Si falla la validación
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        try {
            //Si el token es valido eliminamos el token desconectando al usuario.
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'Usuario desconectado'
            ]);
        } catch (JWTException $exception) {
            //Error 
            return response()->json([
                'success' => false,
                'message' => 'Error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    //Función que utilizaremos para obtener los datos del usuario y validar si el token a expirado.
    public function getUser(Request $request)
    {
        //Validamos que la request tenga el token
        $this->validate($request, [
            'token' => 'required'
        ]);
        //Realizamos la autentificación
        $user = JWTAuth::authenticate($request->token);
        //Si no hay usuario es que el token no es valido o que ha expirado
        if(!$user)
            return response()->json([
                'message' => 'Invalid token / token expired',
            ], 401);
        //Devolvemos los datos del usuario si todo va bien. 
        return response()->json(['user' => $user]);
    }
    public function indexWeb(){
        return view ('content.administrador.usuarios',[
            "title" => "Ver Usuarios",
            "response" => self::list()
        ]);
    }
    public function list()
    {
        return Usuario::where('estado', 'Activo')->get();
    }
    public function updateWeb(Request $request)
    {
        //Validación de datos
        $data = $request->only('edit_id','email','edo' );
        $validator = Validator::make($data, [
            'edit_id' => 'required|int',
            'email' => 'required|max:255|string',
            'edo' => 'required|max:50|string'
        ]);
        //Si falla la validación error.
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Buscamos el trabajo
        //$query = DB::select("call getUsuario('$request->correo')");
        $job = Usuario::findOrfail($request->edit_id);
        //Actualizamos el trabajo.>
        $job->update([
            'correo' => $request->email,
            'estado' => $request->edo,
        ]);
        //Devolvemos los datos actualizados.
        // return response()->json([
        //     'message' => 'Dato actualizado correctamente',
        //     'data' => $job
        // ], Response::HTTP_OK);
        return redirect()->route('listaUser');

    }
    public function destroyWeb(Request $request)
    {
        $data = $request->only('del_id');
        $validator = Validator::make($data, [
            'del_id' => 'required|int',
        ]);
        //$query = DB::select("call getTrabajo('$request->nombre')");
        // $id = $query[0]->id;
        $job = Usuario::findOrfail($request->del_id);
        //$job = Trabajo::findOrfail($query);
        //Eliminamos el trabajo
        $job->update(['estado'=> 'Inactivo']);
        //Devolvemos la respuesta
        // return response()->json([
        //     'message' => 'Dato eliminado correctamente'
        // ], Response::HTTP_OK);
        return redirect()->route('listaUser');
    }

   public function registerWeb(Request $request)
    {
        //Indicamos los datos a recibir en la request
        $data = $request->only('nombre', 'apellido_paterno', 'apellido_materno','correo','telefono', 'password');
        //Realizamos las validaciones
        $validator = Validator::make($data, [
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'apellido_materno' => 'required|string',
            'correo' => 'required|email',
            'telefono' => 'required|max:10|string',
            'password' => 'required|string|min:6|max:50',
        ]);
        //Devolvemos un error si fallan las validaciones
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
        //Creamos el nuevo usuario
        $user = Usuario::create([
            'nombre' => $request->nombre,
            'apellido_paterno' => $request->apellido_paterno,
            'apellido_materno' => $request->apellido_materno,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'estado' => 'Activo',
            'password' => bcrypt($request->password)
        ]);
        //Nos guardamos el usuario y la contraseña para realizar la petición de token a JWTAuth
        $credentials = $request->only('correo', 'password');
        //Devolvemos la respuesta con el token del usuario
       return redirect()->route('listaUser');
    }
}

