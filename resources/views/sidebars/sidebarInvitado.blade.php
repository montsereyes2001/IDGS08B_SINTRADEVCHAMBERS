<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
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
</style>
<body>
            <li class="nav-item">
                <a href="#submenu1" id="nav" data-bs-toggle="collapse" class="nav-link text-truncate  link-dark ">
                    <i class=" bi bi-card-list"></i><span class="ms-1 d-sm-inline">&nbsp; Reportes</span> </a>
            </li>
            <li class="nav-item">
            <form method="GET" action="{{route('logout')}}">
            <button type="submit" id="btn" class="btn btn-dark" name="logout">Cerrar sesión</button>
            </form>
            </li>
</body>