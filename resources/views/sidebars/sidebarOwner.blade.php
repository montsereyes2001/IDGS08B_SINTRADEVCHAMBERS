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
#dropdownMenuLink:hover{color:  #0a76fa !important;
}
#dropdownMenuLink:hover{
    color: black;

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
   .dropdown-menu li {
      position: relative;
    }
    
    .dropdown-menu .dropdown-submenu {
      display: none;
      position: absolute;
      left: 50%;
      top: -7px;
    }
    
    .dropdown-menu .dropdown-submenu-left {
      right: 100%;
      left: auto;
    }
    
    .dropdown-menu>li:hover>.dropdown-submenu {
      display: block;
    }
</style>
<body>
    



<li>
    <a href="{{route('inicioOwner')}}"  id="nav-link" class="nav-link text-truncate  link-dark ">
    <i class="bi bi-house"></i><span class="ms-1 d-sm-inline">&nbsp; Inicio</span> </a>
</li>
 <li>
            <a href="{{route('registrosOwner')}}" id="nav-link" href="#submenu1" class="nav-link text-truncate link-dark">
            <i class="bi bi-ui-checks"></i><span class="ms-1 d-sm-inline">&nbsp; Reportes</span> </a>
            </li>
<div class="dropdown" >
    <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fs-5 bi-boxes"></i>&nbsp;Trabajos</a>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <?php
            foreach ($tipoT as $tT){
                if($tT->nomTipo=='Troncal' || $tT->nomTipo=='Distribución' || $tT->nomTipo=='Enlace'){
                    echo '<a class="dropdown-item" id="dropdownMenuLink" href="'.env('URL').'owner/trabajos/'.$tT->nomTipo.'">Levantamiento '.$tT->nomTipo.'</a>
                    </li>';
                }else{
                echo '<a class="dropdown-item" id="dropdownMenuLink" href="'.env('URL').'owner/trabajos/'.$tT->nomTipo.'">'.$tT->nomTipo.'</a>
                </li>';
                }    
            }
            echo '</ul>';
        ?>
</div>
<li class="nav-item dropdown">
    <a href="#"  id="nav-link" class="nav-link text-truncate dropdown-toggle link-dark " data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fs-5 bi-people"></i>&nbsp;Usuarios</a>
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item bi bi-person-circle" href="{{route('adminOwner')}}">&nbsp;Administradores</a></li>
        <li><a class="dropdown-item bi-people" href="{{route('gerOwner')}}">&nbsp;Gerentes</a></li>
        <li><a class="dropdown-item bi bi-person-badge" href="{{route('supOwner')}}">&nbsp;Supervisores</a></li>
        <li><a class="dropdown-item bi bi-person-workspace" href="{{route('lidOwner')}}">&nbsp;Lideres</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="{{route('gersupOwner')}}">Gerentes - Supervisores</a></li>
        <li><a class="dropdown-item" href="{{route('supliderOwner')}}">Supervisores - Lideres</a></li>
    </ul>
</li>
<li>
    <a href="{{route('ramaOwner')}}"   id="nav-link" class="nav-link text-truncate  link-dark ">
        <i class="fs-5 bi-bezier2"></i><span class="ms-1 d-sm-inline">&nbsp;Ramas</span> </a>
</li>
<li class="nav-item">
    <form method="GET" action="{{route('logout')}}">
        <button type="submit" id="btn" class="btn btn-dark" name="logout">Cerrar sesión</button>
    </form>
</li>            
</body>
</html>