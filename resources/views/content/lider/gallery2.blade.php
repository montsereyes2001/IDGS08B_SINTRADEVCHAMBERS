<?php
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
    header('Location: '.env('URL').'login ');
            exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Lider'){
    header('Location: '.env('URL').'login ');
            exit();
}
$tipoUs=$_SESSION['TipoUs'];?>
@include('layouts.sidebarDashboard')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
    <title>Inicio</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</style>
</head>
<body>
<div class="container-fluid">
<div class="m-2">
    <div class="ms-5 mt-3">
        <a class="btn btn-outline-dark align-item-center" href='<?php echo env('URL').'bit/view/'.$id_bit;?>'>Registrar evidencia</a>
    </div>
    @if(Session::has('message'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('message') }}
    </div>
    @endif
    <form action='{{route("kml")}}' method="post">
        @csrf
        @method('post')
        <?php
            echo '<input type="hidden" name="id" value='.$id_bit.'>';
        ?> 
        <button type="submit" class="mx-auto btn btn-outline-dark btn-lg">KML</button>
    </form>
    <a class="btn btn-outline-dark align-item-center" href='<?php echo env('URL').'ev/updtW/4/'.$id_bit;?>'>Modificar evidencia</a>
    <div class="container-fluid">
        <div class="section"> 
            <div class="container">
                <div class="catalog">
                    <div class="catalog__flex card-content">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ms-5 mt-3 pagination-1">
    </div>
</div>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
</body>
</html>

