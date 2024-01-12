@extends('layouts.scripts')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="icon" href="{{URL::asset('/assets/logo.png')}}">
     <link href="{{ asset('css/RCStyle.css') }}" rel="stylesheet">
     <title>JosCir Company & Associates</title>
</head>
<body>
    <section class="wrapper">
  <div class="container">
    <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center">
      <div class="logo">
        <img src="{{URL::asset('/assets/logo.png')}}" alt="logo" class="img-fluid">
      </div>
      <br><br>
      <form class="rounded bg-white shadow p-5">
        <h3 class="text-dark fw-bolder fs-4 mb-2">Recuperación de contraseña</h3>
        <div class="fw-normal mb-4 text-secondary" id="inicio">
            Escribe tu correo electrónico, se te enviará un codigo. Revise su bandeja de spam o correo no deseado. En caso de no recibir nada, intentelo de nuevo.
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Correo</label> 
        </div>
            <a href="{{route('RCDos')}}" id="button" class="btn btn-light submit_btn w-100 my-4">Enviarme correo</a>
        </div>
      </form>
    </div>
  </div>
</section>
</body>
</html>