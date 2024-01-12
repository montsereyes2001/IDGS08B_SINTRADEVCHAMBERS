<?php 
  $email = $_SESSION['Correo']
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<style>
 #nav-link:hover{
    color:  #0a76fa !important;
}
#btn{
  margin-left: 15px !important;
  margin-top: 5px !important;
  }
#btn:hover{
    background-color: red !important;
    border: red !important;
  }
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');

</style>
<body>
  

  <li class="nav-item">
        <a href="{{ route('inicioLider') }}" id="nav-link"  class="nav-link text-truncate  link-dark ">
        <i class="bi bi-house"></i><span class="ms-1 d-sm-inline">&nbsp; Inicio</span> </a>
      </li>
  <!-- <li>
      <a href=""  class="nav-link text-truncate  link-dark ">
      <i class="bi bi-card-checklist"></i><span class="ms-1 d-none d-sm-inline">&nbsp;Bitacoras</span>
      </a>
  </li> -->
  <li>
    <form action="{{route('postLid')}}" method ="post">
      @csrf
      @method('post')
      <?php
          echo '<input type="hidden" name="correo" id="" value='.$email.'>';
          echo '<input type="hidden" name="action" id="" value="register">';
      ?> 
      <button type="submit" name="insert" id="nav-link" class="nav-link text-truncate link-dark"><i class="bi bi-card-checklist"></i>
      <span class="ms-1 d-sm-inline">&nbsp;</span>Crear bitácora</button>
    </form>
  </li>
  <!-- <li>
    <form action="{{route('postLid')}}" method ="post">
      @csrf
      @method('post')
      <?php
          echo '<input type="hidden" name="correo" id="" value='.$email.'>';
          echo '<input type="hidden" name="action" id="" value="list">';
      ?> 
      <button type="submit" name="list" class="nav-link text-truncate link-dark"><i class="bi bi-list-ol"></i>
      <span class="ms-1 d-sm-inline">&nbsp;</span>Listado de registros</button>
    </form>
  </li> -->
  {{-- <li class="nav-item">
      <a href="#submenu1" data-bs-toggle="collapse" class="nav-link text-truncate  link-dark ">
      <i class="bi bi-file-image"></i><span class="ms-1 d-sm-inline">&nbsp; Evidencias</span></a>
  </li> --}}
  <li class="nav-item">
  <form action="{{route('postLid')}}" method ="post">
      @csrf
      @method('post')
      <?php
          echo '<input type="hidden" name="correo" id="" value='.$_SESSION['Correo'].'>';
          echo '<input type="hidden" name="action" id="" value="list_cards">';
      ?> 
      <button type="submit" name="list" id="nav-link"  class="nav-link text-truncate link-dark"><i class="bi bi-ui-checks"></i>
      <span class="ms-1 d-sm-inline">&nbsp;</span>Registros de las bitácoras</button>
      <!-- <a href="#"   class="nav-link text-truncate  link-dark ">
      <i class="bi bi-file-image"></i><span class="ms-1 d-sm-inline">&nbsp; Cards Bitacoras</span></a> -->
    </form> 
  </li>
  <!-- <li class="nav-item">
      <a href="#" class="nav-link text-truncate  link-dark ">
      <i class="bi bi-list-columns-reverse"></i><span class="ms-1 d-sm-inline">&nbsp; Reportes</span> </a>
  </li> -->
  <li class="nav-item">
    <form method="GET" action="{{route('logout')}}">
      <button type="submit" id="btn" class="btn btn-dark" name="logout">Cerrar sesión</button>
    </form>
  </li>
</body>