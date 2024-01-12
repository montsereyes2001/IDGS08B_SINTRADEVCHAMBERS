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
            Escribe el código que llegó a tu correo y confirma tu nueva contraseña.<a href="{{route('RC')}}" class="fw-bold text-secondary text-decoration-none">Aún no tengo código</a>
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Nueva contraseña</label> 
          <input type="password" class="form-control" required id="psd" >
        </div>
        <div class="mb-3 text-start">
          <label for="" class="form-label">Confirmar nueva contraseña</label> 
          <input type="password" class="form-control" required id="confirmPsd" >
        </div>
         <button type="submit" id="button" class="btn btn-light submit_btn w-100 my-4">Enviarme código</button>
        </div>
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
</body>
</html>