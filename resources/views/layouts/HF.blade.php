<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <link href="{{ asset('css/HFStyle.css') }}" rel="stylesheet">
    <link rel="icon" href="{{URL::asset('/assets/logo.png')}}">
        <title>JosCir Company & Associates</title>
  </head>
  <style>
  </style>
  <body>
    
     <!-- NAVBAR -->
<div class="fiber-bg"></div>
      <nav class="navbar navbar-expand-lg ">
    <div class="container-fluid">
       <a class="navbar-brand" href="{{route('index')}}"  >
      <img src="{{URL::asset('/assets/logo.png')}}" alt="JosCir Company & Associates" width="100" height="60">
    </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <i class="fas fa-bars"></i>
  </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto w-100 justify-content-end ">
          <li class="nav-item active">
            <a class="nav-link" href="{{route('index')}}" id="a">@lang('pagina.nav_home')<span class="sr-only"></span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{route('galeria')}}" id="a">@lang('pagina.nav_galery')</a>
            <li class="nav-item">
              <a class="nav-link" href="{{route('servicios')}}" id="a">@lang('pagina.nav_services')</a>
              <li class="nav-item">
                <a class="nav-link" href="{{route('contacto')}}" id="a">@lang('pagina.nav_contact')</a>
              </li>
                 <li class="nav-item dropdown" >
          <a class="nav-link dropdown-toggle" id="a" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           @lang('pagina.choose_lang')
          </a>
                <ul class="dropdown-menu" style="background-color: rgb(4,52,84)">
                  <li> <a class="dropdown-item" id="a" href="{{url('locale/es')}}">@lang('pagina.spanish')</a></li>
                    <li><a class="dropdown-item" id="a" href="{{url('locale/en')}}">@lang('pagina.english')</a></li>
           </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

   <!-- <div class="dropdown">
      <button class="btn btn-primary bg-transparent dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        @lang('pagina.choose_lang')
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="{{url('locale/es')}}">@lang('pagina.spanish')</a>
        <a class="dropdown-item" href="{{url('locale/en')}}">@lang('pagina.english')</a>
      </div>
    </div>
  </nav>-->
  <div class="container-fluid" style="margin: 0%; padding:0%">
   @yield('Inicio')
    @yield('Galeria')
    @yield('Servicios')
    @yield('Contacto')
  </div>
  

<!-- SCRIPTS -->
      {{-- <div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div> --}}
  <footer class="text-center text-lg-start text-light" >
         {{-- <div class="bg"></div>
<div class="bg bg2"></div>
<div class="bg bg3"></div> --}}
    <!-- Grid container -->
    <div class="container p-4">
      <!--Grid row-->
      <div class="row mt-4">
        <!--Grid column-->
        <div class="col-lg-4 col-md-12 mb-4 mb-md-0" id="footer">
          <h5 class="text-uppercase mb-4">JosCir Company & Associates</h5>
  
          <p>
            @lang('pagina.footer_desc')
          </p>
  
          <div class="mt-4">
            <!-- Facebook -->
            <a type="button" href="https://www.facebook.com/profile.php?id=100089707944492&mibextid=LQQJ4d" id="ic" class="btn btn-floating btn-outline-light btn-lg"><i class="fab fa-facebook-f" style="color: white"></i></a>
            <!-- Twitter
            <a type="button" id="ic" class="btn btn-floating btn-outline-light btn-lg"><i class="fab fa-twitter"></i></a> -->
          </div>
        </div>
  
        <!--Grid column-->
        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
  
          <ul class="fa-ul" style="margin-left: 1.65em;">
            <li class="mb-3">
              <span class="fa-li"><i class="fa-solid fa-location-dot"></i></span><span class="ms-2"> Av. Bravo 780, Segundo de Cobián Centro, 27000 Torreón, Coah.</span>
            </li>
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-envelope "></i></span><span class="ms-2">info@joscir.com</span>
            </li>
            <li class="mb-3">
              <span class="fa-li"><i class="fas fa-phone "></i></span><span class="ms-2">871-904-6523</span>
            </li>
               <li class="mb-3">
               <span class="fa-li" style="margin-top: 9px !important;" ><i class="fa-solid fa-user"></i></span> <a id="a" disabled href="{{route('login')}}"> <span class="ms-2">@lang('pagina.login')</span></a>
            </li>
          </ul>
        </div>
        <!--Grid column-->
  
        <!--Grid column-->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h5 class="text-uppercase mb-4 text-center text-light">@lang('pagina.footer_schedule')</h5>
  
          <table class="table text-center">
            <tbody class="font-weight-normal text-light">
              <tr>
                <td>@lang('pagina.footer_days_1')</td>
                <td>@lang('pagina.footer_time_1')</td>
              </tr>
              <tr>
                <td>@lang('pagina.footer_days_2')</td>
                <td>@lang('pagina.footer_time_2')</td>
              </tr>
              <tr>
                <td>@lang('pagina.footer_days_3')</td>
                <td>@lang('pagina.footer_time_3')</td>
              </tr>
            </tbody>
          </table>
        </div>
        <!--Grid column-->
      </div>
      <!--Grid row-->
    </div>
    <!-- Grid container -->
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2022 Copyright:
      <a class="text-muted" href="https://joscir.com" id="a" style="font-size: 15px !important; ">JosCir Company & Associates</a>
    </div>
    <!-- Copyright -->
  </footer>
</body>

 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
</html>