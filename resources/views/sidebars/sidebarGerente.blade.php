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
</head>
<style>
  #nav:hover{
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
    <li >
        <a id="nav" href="{{route('inicioGer')}}" class="nav-link text-truncate link-dark">
        <i class="bi bi-house"></i><span class="ms-1 d-sm-inline">&nbsp; Inicio</span> </a>
    </li>
    <!-- <li>
        <a href="{{route('gersupLista')}}"  class="nav-link text-truncate  link-dark ">
            <i class="bi bi-person-badge"></i><span class="ms-1 d-sm-inline">&nbsp;Supervisores asociados</span>
        </a>
    </li> -->
    <form action="{{route('postGer')}}" method ="post">
        @csrf
        @method('post')
        <?php
            echo '<input type="hidden" name="correo" id="" value='.$email.'>';
        ?> 
        <button id=nav type="submit" name="insert" class="nav-link text-truncate link-dark"><i class="bi bi-person-badge"></i>
        <span class="ms-1 d-sm-inline">&nbsp;</span>Supervisores Asociados</button>
    </form>
    <li>
                <a id="nav" href="{{route('ramasGer')}}"   id="nav-link" class="nav-link text-truncate link-dark">
                    <i class="fs-5 bi-bezier2"></i><span class="ms-1 d-sm-inline">&nbsp;Ramas</span> </a>
            </li>

    <li class="nav-item" >
        <a href="{{route('registrosGerente')}}" id="nav"  class="nav-link text-truncate link-dark">
        <i class="bi bi-ui-checks"></i><span class="ms-1 d-sm-inline">&nbsp; Reportes</span> </a>
    </li>
    
    <li class="nav-item">
      <form method="GET" action="{{route('logout')}}">
      <button type="submit" id="btn" class="btn btn-dark" name="logout">Cerrar sesión</button>
      </form>
    </li>
            