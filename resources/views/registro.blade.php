@extends('layouts.scripts')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="icon" href="{{URL::asset('/assets/logo.png')}}">
<link href="{{ asset('css/RegistroStyle.css') }}" rel="stylesheet">
 </head>
  <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
</style>
<section class="wrapper">
  <div class="container">
    <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center">
      <div class="logo">
        <img src="{{URL::asset('/assets/logo.png')}}" alt="logo" class="img-fluid">
      </div>
      <br><br>
      <form class="rounded bg-white shadow p-5" method="post" enctype="multipart/form-data" action="{{route('registroLog')}}">
      @method('post')
        @csrf
        <h3 class="fw-bolder fs-4 mb-2">Registro</h3>
        <div class="text-muted  mb-4">
          <a href="{{route('login')}}" class="text-secondary  fw-bold text-decoration-none">Volver a inicio de sesión</a>
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Nombre/s *</label>
          <input name="nombre" type="text" class="form-control" required>
          <div id="nombre" class="form-text"></div>
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Apellido Paterno *</label> 
          <input name="ap_pat" type="text" class="form-control" required id="">
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Apellido Materno *</label> 
          <input name="ap_mat" type="text" class="form-control" required id="">
        </div>
          <div class="mb-3 text-start">
          <label for="" class="form-label">Correo *</label> 
          <input name="correo" type="email" class="form-control" required id="">
        </div>
         <div class="mb-3 text-start">
          <label for="tel" class="form-label">Teléfono *</label> 
           <div class="form-floating text-secondary">
          <input name="tel" type="tel" class="form-control" id="floatingPassword" maxlength="10"
       required>
          <label for="floatingInput">Formato: 8719046523</label> 
        </div>
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Contraseña *</label> 
          <input name="pass" type="password" class="form-control" minlength="6" required id="psd" >
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Confirmar contraseña *</label> 
          <input type="password" class="form-control" minlength="6" required id="confirmPsd" >
        </div>
        <button type="submit" id="button" class="btn btn-light submit_btn w-100 my-4">Registrarme</button>
      </form>
    </div>
  </div>
</section>
<script>
  var password = document.getElementById("psd")
  , confirm_password = document.getElementById("confirmPsd");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Las contraseñas no coinciden, intentelo de nuevo");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
</html>