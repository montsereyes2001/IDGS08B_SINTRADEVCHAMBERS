
<?php

if (!isset($_SESSION)){
  session_start();
}elseif(empty($_SESSION['TipoUs'])){
  header('Location: '.env('URL').'login ');
  exit();
}
?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @if ($_SESSION['TipoUs'] == 'Invitado')
    <title>Dashboard | Invitado</title>
    @else
    <title>{{ $title }}</title>
    @endif
    <link rel="icon" href="{{URL::asset('/assets/logo.png')}}">
      <link href="{{ URL::asset('css/SidebarAdminStyle.css') }}" type="text/css" rel="stylesheet">
       <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap' rel='stylesheet'>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
    
          <!-- CSS only -->
  </head>
      <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
.not-active { 
            pointer-events: none; 
            cursor: default; 
        } 

</style>
  <body>
    <div class="offcanvas offcanvas-start w-26" tabindex="-1" id="offcanvas" data-bs-keyboard="false" data-bs-backdrop="false">
      
    <div class="offcanvas-header">
         
        <h6 class="offcanvas-title d-none d-sm-block d-block" id="offcanvas"><img src="{{URL::asset('/assets/logo.png')}}" alt="JosCir Company & Associates" width="100" height="60"></h6>
        <h6 class="offcanvas-title 	d-block d-sm-none"><img src="{{URL::asset('/assets/logo.png')}}" alt="JosCir Company & Associates" width="100" height="50"></h6>
        <h4><button type="button" class="btn-close ms-auto d-block" data-bs-dismiss="offcanvas" aria-label="Close"></button></h4> 
        
    </div>
    
    <div class="offcanvas-body px-0">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">
    @includeWhen($_SESSION['TipoUs']=='Administrador', 'sidebars.sidebarAdministrador')
    @includeWhen($_SESSION['TipoUs']=='Supervisor', 'sidebars.sidebarSupervisor')
    @includeWhen($_SESSION['TipoUs']=='Gerente', 'sidebars.sidebarGerente')
    @includeWhen($_SESSION['TipoUs']=='Lider', 'sidebars.sidebarLider')
    @includeWhen($_SESSION['TipoUs']=='CEO', 'sidebars.sidebarOwner')
        </ul>
    </div>
</div>

<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">@if($_SESSION['TipoUs']=='Invitado')
  <a class="navbar-brand not-active" href="#"><img src="{{URL::asset('/assets/retrato.png')}}" role="button">&nbsp; {{$_SESSION['TipoUs']}}</a>
  
    @else
    <a class="navbar-brand" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" role="button"><img src="{{URL::asset('/assets/aplicaciones.png')}}" > &nbsp; &nbsp;Menú</a>
    @endif
    <div class="nabvar" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      @if($_SESSION['TipoUs']=='Invitado')
      {{-- <a class="navbar-brand not-active" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" role="button"> &nbsp; &nbsp;Inicio</a> --}}
    @include('sidebars.sidebarInvitado')
    @else
        <li class="nav-item">
            <a class="navbar-brand" href="#"><img src="{{URL::asset('/assets/retrato.png')}}" role="button">&nbsp; {{$_SESSION['TipoUs']}}</a>
            @endif
        </li>
      </ul>
    </div>
  </div>
</nav>
</div>
</div>
  </body>
</html>

