<?php

namespace App\Http\Controllers;
use App\Mail\ContactoMail;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\Validator;
use App\Rules\ReCaptcha;
class ContactoController extends Controller
{
     public function contacto(){
        return view('Contacto');
    }
     function enviarCorreo(Request $request){
        // $data = $request->only('nombre','correo','telefono','mensaje','g-recaptcha-response');
        // $request = Validator::make($data,[
        //  'nombre' => 'required|max:100|string',
        //  'correo' =>  'required|email',
        //  'telefono' => 'required', 
        //  'mensaje' =>  'required',
        //  'g-recaptcha-response'=> ['required', new ReCaptcha]
        // ]);
        //  if ($request->fails()) {
        //      return back()->with('mensaje_error', 'La captcha no ha sido verificada, por favor ingrese los datos de nuevo y verifique la casilla.');
        // }
       $detalles =[
        'nombre' => $request->nombre,
        'correo' =>  $request->correo,
        'telefono' =>  $request->telefono,
        'mensaje' =>  $request->mensaje
        ];        
        Mail::to('proyectosti@joscir.com')->send(new ContactoMail($detalles));
        return back()->with('mensaje_enviado', 'El mensaje se ha enviado correctamente');
    }
}
