<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB; 
use App\Models\Usuario; 
use Mail; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class RecuperaContraseñaController extends Controller
{
       public function showForgetPasswordForm()
      {
         return view('emails.forgetPassword');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $data = $request->only('correo' );
        $validator = Validator::make($data, [
            'correo' => 'required|max:255|string'
        ]);
        //Si falla la validación error.
         $token = Str::random(64);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }
            Mail::send('emails.forgetPasswordCorreo', ['token' => $token], function($message) use($request){
              $message->to($request->correo);
              $message->subject('Reinicio de contraseña');
          });
           return redirect('login')->with('message', 'Se ha enviado un correo para el reinicio de tu contraseña.');
      }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm() { 
         return view('emails.forgetPasswordLink');
      }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $data = $request->only('correo, password');
          $validator = Validator::make($data, [
            'correo' => 'required|string',
            'password' => 'required|max:255|string'
        ]);
         //Si falla la validación error.
        //if ($validator->fails()) {
            //return response()->json(['errorP' => $validator->messages()], 400);
          //  return $request->password;
        //}
        $query = DB::select("call getUsuario('$request->correo')");
         $usuario = Usuario::findOrfail($query[0]->id);
          $usuario->update([
            'password' =>bcrypt($request->password)
        ]);
          return redirect('login')->with('message', 'Tu contraseña ha sido actualizada existosamente.');
      }
    }