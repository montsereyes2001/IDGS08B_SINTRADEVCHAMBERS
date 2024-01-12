<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
     <link href="{{ asset('css/navbarHomeStyle.css') }}" rel="stylesheet">
    <link rel="icon" href="{{URL::asset('/img/logo.png')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/img/logo.png')}}">

        <title>JosCir Company & Associates</title>
    <title>Hello, world!</title>
  </head>
  <body>
     <!-- NAVBAR -->
      <nav class="navbar sticky-top navbar-expand-lg bg-light">
    <div class="container">
       <a class="navbar-brand" href="#">
      <img src="{{URL::asset('/img/logo.png')}}" alt="JosCir Company & Associates" width="100" height="60">
    </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <i class="fas fa-bars"></i>
  </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto w-100 justify-content-end blank">
          <li class="nav-item">
            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{url('galleryHome')}}">Nosotros</a>
            <li class="nav-item">
              <a class="nav-link" href="#">Servicios</a>
              <li class="nav-item">
                <a class="nav-link" href="#">Contacto</a>
        </ul>
      </div>
    </div>
  </nav>

<!-- SCRIPTS -->
  </body>
</html>