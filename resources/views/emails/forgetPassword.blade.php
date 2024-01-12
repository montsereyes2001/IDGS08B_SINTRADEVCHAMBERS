@extends('layouts.scripts')
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="icon" href="{{URL::asset('/assets/logo.png')}}">
<link href="{{ asset('css/LoginStyle.css') }}" rel="stylesheet">
<title>JosCir Company & Associates</title>
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
      <form class="rounded bg-white shadow p-5" method="post" enctype="multipart/form-data" action="{{route('forget.password.post')}}">
        @csrf
        <h3 class="text-dark fw-bolder fs-4 mb-2">Recuperación de contraseña</h3>
        <div class="fw-normal mb-4" id="inicio">
            Ingresa tu correo electrónico donde se te enviará un enlace para crear una nueva contraseña.
        </div>
        <div class="form-floating mb-3">
          <input name="correo" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Correo</label> 
        </div>
      
        <button type="submit" id="button" class="btn btn-light submit_btn w-100 my-4">Enviar enlace</button>
          <div class="text-center  mb-3">
            <a  class="text-muted text-decoration-none" id="inicio" href="{{route('login')}}" >Volver a inicio de sesión</a>
          </div>
           <a href="" class="w-100 mb-3 text-decoration-none"><img class="me-3" src="" alt="">&nbsp;</a>
            <a href="" class="w-100 mb-3 text-decoration-none"><img class="me-3" src="" alt="">&nbsp;</a>
              <a href="" class="w-100 mb-3 text-decoration-none"><img class="me-3" src="" alt="">&nbsp;</a>
      </form>
    </div>
    
  </div>
  
</section>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
</html>