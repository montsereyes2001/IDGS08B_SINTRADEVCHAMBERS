<?php 
  $email = $_SESSION['Correo']
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
</head>

<style>
    #nav-link:hover {
        color: #0a76fa !important;
    }

    #btn {
        margin-left: 15px !important;
        margin-top: 5px !important;
    }

    #btn:hover {
        background-color: red !important;
        border: red !important;
    }

    #navbarDropdown:hover {
        color: #0a76fa !important;
    }

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
</style>

<body>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <li class="nav-item">

    <li>
        <a href="{{route('inicioAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
            <i class="bi bi-house"></i><span class="ms-1 d-sm-inline">&nbsp; Inicio</span> </a>
    </li>

    <li>
        <a href="{{route('prodVistaAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
            <i class="fs-5 bi-box"></i><span class="ms-1 d-sm-inline">&nbsp; Materiales</span> </a>
    </li>
    <li>
        <a href="{{route('iconosListAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
            <i class="fs-5 bi-pin-map"></i><span class="ms-1 d-sm-inline">&nbsp;Iconos</span> </a>
    </li>
    <a href="{{route('trabListAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
        <i class="fs-5 bi-boxes"></i><span class="ms-1 d-sm-inline">&nbsp;Trabajos</span></a>
    </li>
    <li>
        <a href="{{route('tipotrabAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
            <i class="bi bi-clipboard2-check"></i><span class="ms-1 d-sm-inline">&nbsp;Tipos de Trabajo</span> </a>
    </li>
    </li>
    <li>
        <a href="{{route('ramasAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
            <i class="fs-5 bi-bezier2"></i><span class="ms-1 d-sm-inline">&nbsp;Ramas</span> </a>
    </li>
    <li>
        <a href="{{route('listaInventario')}}" id="nav-link" class="nav-link text-truncate link-dark"><i
                class="bi bi-card-checklist"></i><span class="ms-1 d-sm-inline">&nbsp; Inventario</span></a>
    </li>
    <li>
        <a href="{{route('clienListAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
            <i class="fs-5 bi-people"></i><span class="ms-1 d-sm-inline">&nbsp;Clientes</span> </a>
    </li>
    <li>
        <a href="{{route('concliListAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
            <i class="bi bi-person-lines-fill"></i><span class="ms-1 d-sm-inline">&nbsp;Contacto Cliente</span> </a>
    </li>
    <li class="nav-item">
        <a href="{{route('registrosAdmin')}}" id="nav-link" href="#submenu1" class="nav-link text-truncate link-dark">
            <i class="bi bi-ui-checks"></i><span class="ms-1 d-sm-inline">&nbsp; Bitácoras</span> </a>
    </li>
    <li class="nav-item">
       <a href="{{route('getCrearBitacora')}}" id="nav-link" class="nav-link text-truncate link-dark ">
                    <i class="bi bi-card-checklist"></i><span class="ms-1 d-sm-inline">&nbsp;Crear bitácora</span> </a>
    </li>
    <li>
        <div class="dropdown">
            <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false"><i class="bi bi-file-earmark-person"></i>
                <span class="ms-1 d-sm-inline">&nbsp;Gestión de usuarios</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a href="{{route('listaUser')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
                        <i class="fs-5 bi-people"></i><span class="ms-1 d-sm-inline">&nbsp;Usuarios</span></a></li>

                <li><a href="{{route('adminList')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
                        <i class="bi bi-person-circle"></i><span class="ms-1 d-sm-inline">&nbsp; Administradores</span>
                    </a></li>
                <li><a href="{{route('supervisoresAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
                        <i class="bi bi-person-badge"></i><span class="ms-1 d-sm-inline">&nbsp;Supervisores</span></a>
                </li>
                <li>
                    <a href="{{route('listaLideresAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
                        <i class="bi bi-person-workspace"></i><span class="ms-1 d-sm-inline">&nbsp;Líderes</span></a>
                </li>

                <li>
                    <a href="{{route('gerListAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
                        <i class="fs-5 bi-people"></i><span class="ms-1 d-sm-inline">&nbsp;Gerentes</span> </a>
                </li>
                <li>
                    <a href="{{route('invitadoAdmin')}}" id="nav-link" class="nav-link text-truncate  link-dark ">
                        <i class="fs-5 bi-person-video3"></i><span class="ms-1 d-sm-inline">&nbsp;Invitados</span> </a>
                </li>
            </ul>
        </div>
    </li>

    <li class="nav-item">
        <form method="GET" action="{{route('logout')}}">
            <button type="submit" id="btn" class="btn btn-dark" name="logout">Cerrar sesión</button>
        </form>
    </li>

</body>

</html>