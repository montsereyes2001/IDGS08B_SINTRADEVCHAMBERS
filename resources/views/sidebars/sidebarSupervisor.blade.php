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
    
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <li class="nav-item">
        <!-- <?php //echo $email?> -->
        <li>
            <a href="{{route('inicioSup')}}"  id="nav-link"  class="nav-link text-truncate  link-dark ">
            <i class="bi bi-house"></i><span class="ms-1 d-sm-inline">&nbsp; Inicio</span> </a>
        </li>
    <!-- <li>    
        <a href="{{route('suplidLista')}}"  class="nav-link text-truncate  link-dark ">
        <i class="bi bi-person-check-fill"></i><span class="ms-1 d-none d-sm-inline">&nbsp;Lideres Asociados</span></a>
    </li> -->
        <form action="{{route('postSup')}}" method ="post">
            @csrf
            @method('post')
            <?php
                echo '<input type="hidden" name="correo" id="" value='.$email.'>';
            ?> 
            <button type="submit" name="insert"  id="nav-link"  class="nav-link text-truncate link-dark"><i class="bi bi-person-check-fill"></i>
            <span class="ms-1 d-sm-inline">&nbsp;</span>Lideres Asociados</button>
        </form>
    </li>
    
    <li class="nav-item">
        <a href="{{route('registrosSup')}}"  id="nav-link"  class="nav-link text-truncate  link-dark ">
        <i class="bi bi-card-list"></i><span class="ms-1 d-sm-inline">&nbsp; Reportes</span> </a>
    </li>

    <li class="nav-item">
        <form method="GET" action="{{route('logout')}}">
            <button type="submit" id="btn" class="btn btn-dark" name="logout">Cerrar sesión</button>
        </form>
    </li>


</body>