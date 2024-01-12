<?php
// dd($evidencias);
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
   header('Location: '.env('URL').'login ');
           exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Invitado'){
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
    <title>Galeria</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');

    body {
        font-family: 'Poppins';
    }

    #iev {
        max-width: 100%;
        height: auto;
    }

    a:hover {
        color: white !important;
    }
</style>

<body>
    <div class="ms-3 mt-3 mb-5 text-start container">
        <a class="btn btn-outline-dark align-item-center" id="btn-reg" href='<?php echo env('URL').'inv/gallery/'.$evidencia->id_bitacora;?>'><span
                class="ms-1 d-sm-inline bi bi-arrow-bar-left fs-4"></span>&nbsp;Regresar</a>
    </div>
    <div class="container-fluid" style="margin-bottom: 50px">
        <div class="card" style="max-width: 1000px; border:none;">
            <div class="row g-0">
                <div class="col-sm-5">
                    <img src="{{$evidencia->foto}}" class="card-img-top h-100" alt="...">
                </div>
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title">Detalle de la evidencia: {{$evidencia->nombre}}</h5>
                        <p class="card-text">Rama: <br> {{$evidencia->rama}}</p>
                        <p class="card-text">Descripción: <br> {{$evidencia->descripcion}}</p>
                        <p class="card-text">Trabajo: <br> {{$evidencia->trabajos}}</p>
                        <p class="card-text">Lider: <br> {{$evidencia->lider}}</p>
                        <p class="card-text">Ciudad: <br> {{$evidencia->ciudad}}</p>
                        <p class="card-text">Estado: <br> {{$evidencia->estado}}</p>
                        <p class="card-text">Estatus del registro: <br> {{$evidencia->estatus}}</p>
                        @if (isset($insumos))
                        <p class="card-text">Material utilizado:</p>
                        <div class="container overflow-auto" style="height:120px; margin-top:-5px;">
                            @foreach ($insumos as $item)
                            <div class="card-text">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">{{ $item->nombre}}</span>
                                    <input disabled class=" form-control w-85" type="number" value={{$item->cantidad}}
                                    name="cantmat[]"
                                    id="cant">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <br>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
</body>

</html>