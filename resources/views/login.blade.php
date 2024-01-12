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
<?php
session_start();
if(isset($_SESSION['dash'])){
  session_unset();
  session_destroy();
  header('Location: '.env('URL').'login ');
  exit();
}
?>
<section class="wrapper">
  <div class="container">
    <div class="col-sm-8 offset-sm-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 text-center">
      <div class="logo">
        <img src="{{URL::asset('/assets/logo.png')}}" alt="logo" class="img-fluid">
      </div>
      <br><br>
      <form class="rounded bg-white shadow p-5" method="post" enctype="multipart/form-data" action="{{route('loginApi')}}">
        @csrf
        <h3 class="text-dark fw-bolder fs-4 mb-2">Inicio de sesión</h3>
        <div class="fw-normal mb-4" id="inicio">
            ¿No tienes una cuenta? <a href="{{route('registro')}}" class="fw-bold text-secondary text-decoration-none">Crea una cuenta</a>
        </div>
        @if (Session::has('messageL'))
        <div class="alert alert-warning" role="alert">{{ Session::get('messageL') }}</div>
        @endif
        @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
        <div class="form-floating mb-3">
          <input name="correo" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
          <label for="floatingInput">Correo</label> 
        </div>
        <div class="form-floating">
          <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="•••••••••••">
          <label for="floatingInput">Contraseña</label> 
        </div>
        <div class="mt-2 text-center" id="inicio">¿Olvidaste tu contraseña?&nbsp;
          <a href="{{route('forget.password.get')}}" class="text-secondary  fw-bold text-decoration-none ">  Haz click aquí</a>
        </div>
        <button type="submit" id="button" class="btn btn-light submit_btn w-100 my-4" name="login">Iniciar sesión</button>
        <?php
        if(isset($_POST['login'])) {
          $_SESSION['correo']=$_POST['email'];
          $_SESSION['password']=$_POST['password'];
        }
        ?>
          <div class="text-center  mb-3">
            <a  class="text-muted text-decoration-none" id="inicio" href="{{route('index')}}" >Volver a inicio</a>
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