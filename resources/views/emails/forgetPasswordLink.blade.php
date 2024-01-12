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
      <form class="rounded bg-white shadow p-5" method="post" enctype="multipart/form-data" action="{{route('reset.password.post')}}">
      @method('post')
        @csrf
        <h3 class="fw-bolder fs-4 mb-2">Cambio de contraseña</h3>
          <div class="mb-3 text-start">
          <label for="" class="form-label">Correo *</label> 
          <input name="correo" type="email" class="form-control" required id="">
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Nueva contraseña *</label> 
          <input name="password" type="password" class="form-control" minlength="6" required id="psd" >
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Confirmar nueva contraseña *</label> 
          <input type="password" class="form-control" minlength="6" required id="confirmPsd" >
        </div>
        <button type="submit" id="button" name="submit" class="btn btn-light submit_btn w-100 my-4">Reiniciar contraseña</button>
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