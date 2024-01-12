<?php
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
    header('Location: '.env('URL').'login ');
            exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Lider'){
    header('Location: '.env('URL').'login ');
            exit();
}
$tipoUs=$_SESSION['TipoUs'];
$lider=$_SESSION['Correo'];?>

@include('layouts.sidebarDashboard')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
body{
    font-family: 'Poppins';
}
#btn-reg:hover{
    color: white !important;
}
</style>
<body class="p-3">
    <div class="ms-3 mt-1 mb-3 text-start container">
        <a class="btn btn-outline-dark align-item-center" id="btn-reg" href='<?php echo env('URL').'ev/gallery/'.$bitacora;?>'><span
                class="ms-1 d-sm-inline bi bi-arrow-bar-left fs-4"></span>&nbsp;Regresar</a>
    </div>
    <div class='container-fluid'>
    <h2 class="text-center mb-4">Modificar Evidencia</h2><br>
        <form action="{{ route('modEvi') }}" method="post" enctype="multipart/form-data" class="row g-3" >
            @csrf
            @method('PUT')
            <div class="col col-md-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text">Identificador del registro</label>
                            <select class="form-select" name='bit'>
                                <option value='{{$bitacora}}'>{{$bitacora}}</option>
                            </select>
                        </div>
                </div>
                <div class=" col col-md-6">
                    <div class="input-group mb-3">
                        <label class="input-group-text">Identificador de la evidencia</label>
                        <select class="form-select" name='id'>
                          <option value='{{$evidencia->id}}'>{{$evidencia->id}}</option>
                        </select>
                    </div>
                </div>
            
                <div class=" col-lg-6 col-md-6">
                    <!-- nombre -->
                    <div class="input-group mb-2">
                    <span class="input-group-text">Modificar nombre</span>
                    <input type="text" class="form-control" name="nombre" id="nombre" aria-describedby="basic-addon1" value ="<?php echo $evidencia->nombre; ?>">
                    </div> 
                </div>
                <?php
                if(!empty($evidencia->icono)){
                    echo '<div class="col-lg-6 col-md-6">
                    <div class="input-group mb-2">
                    <label for="" class="input-group-text">Modificar icono</label>
                    <select class="form-select" name="id_icono" id="id_icono">
                    <option value="'.$evidencia->id_icono.'" selected>'.$evidencia->icono.'</option>';
                    foreach($iconos as $i){
                        echo '<option value="' . $i->id . '">'.$i->nombre.'</option>';
                    }
                    echo '</select></div></div>';
                }
                ?>
           
            
            <br>
                <div class='col-12'>
                    <div class="input-group mb-3">
                        <label for="" class="input-group-text">Modificar estatus</label>
                        <select class="form-select" name='status'>
                            <option value='Activo'>Activo</option>
                            <option value='Inactivo'>Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group mb-3">
                    <label for="" class="input-group-text">Modificar descripcion</label>
                    <textarea class="form-control w-50" name="desc" id="desc" rows="3">{{$evidencia->descripcion}}</textarea>
                    </div>
                </div>
            </div>
                <div class="col-12 text-center mt-4">
                    <button type="submit" name="" class="btn btn-outline-dark align-item-center" id="">Guardar Cambios</button>
                </div>
                </div>
            </form>
            </div>
            </div>
</body>