<?php
// dd($evidencias);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap');
    body{
    font-family: 'Poppins';
    }
    #iev{
     max-width: 100%;
    height: auto;
    }
    a:hover{
    color: white !important;
    }
</style>
<body>
   <div class="ms-3 mt-3 mb-5 text-start container">
        <a class="btn btn-outline-dark align-item-center" id="btn-reg" href='<?php echo env('URL').'ev/gallery/'.$evidencia->id_bitacora;?>'><span
                class="ms-1 d-sm-inline bi bi-arrow-bar-left fs-4"></span>&nbsp;Regresar</a>
    </div>
    @if(Session::has('message'))
    <div class="alert alert-success" role="alert">
        <h3 class="text-center">{{ Session::get('message') }}</h3>
    </div>
   
    @endif
            <div class="container-fluid" style="margin-bottom: 50px">
            <div class="card" style="max-width: 1200px; border:none;">
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
                            <p class="card-text">Supervisor: <br> {{$evidencia->supervisor}}</p>
                            <p class="card-text">Lider: <br> {{$evidencia->lider}}</p>
                            <p class="card-text">Ciudad: <br> {{$evidencia->ciudad}}</p>
                            <p class="card-text">Estado: <br> {{$evidencia->estado}}</p>
                            <p class="card-text">Estatus del registro: <br> {{$evidencia->estatus}}</p>
                            @if (isset($insumos) && count($insumos) > 0)
                            <p class="card-text">Material utilizado:</p>
                            <div class="container overflow-auto" style="height:120px; margin-top:-5px;">
                                    @foreach ($insumos as $item)
                                    <div class="card-text">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">{{ $item->nombre}}</span>
                                            <input disabled class=" form-control w-85" type="number" value={{$item->cantidad}} name="cantmat[]"
                                            id="cant">
                                        </div>
                                    </div>
                                    @endforeach
                            </div> 
                                    <br>
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editarEvidencia">Editar</button>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#eliminarEvidencia">Eliminar</button>
                                   
                            @else
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editarEvidencia">Editar</button>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#eliminarEvidencia">Eliminar</button>
                            @endif                         
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!--MODAL EDITAR !-->
            <form action="{{route('modEvi')}}" method="post">
                @csrf
                @method('PUT')
            <div class="modal fade" id="editarEvidencia" tabindex="-1" aria-labelledby="editarEvidenciaLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="editarEvidenciaLabel">Modificar detalle de la evidencia</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                     
                         @if (isset($insumos) && count($insumos) > 0)
                                    <div class="modal-body">
                                   <input type="hidden" name="id" value="{{$evidencia->id}}">
                                   <div class="input-group mb-2">
                                        <span class="input-group-text">Nombre de la evidencia</span>
                                        <input required type="text" name="nombre" class="form-control" value="{{$evidencia->nombre}}">
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-text">Descripción</span>
                                        <textarea required class="form-control" name="descripcion"
                                            id="floatingTextarea">{{$evidencia->descripcion}}</textarea>
                                    </div>
                                    <p class="">Material utilizado:</p>
                                    @foreach ($insumos as $item)
                                    <div class="input-group mb-2">
                                        <input type="hidden" name="idprods[]" value={{$item->id}}>
                                        <span class="input-group-text" id="basic-addon1">{{ $item->nombre}}</span>
                                       <input class=" form-control w-85" type="number" value={{$item->cantidad}} name="cantmat[]"
                                        id="cant">
                                    </div>
                                    @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                    
                                    </div>

                        @else
                        <input type="hidden" name="id" value="{{ $evidencia->id }}">
                        <div class="modal-body">
                            <div class="input-group mb-2">
                                <span class="input-group-text">Nombre de la evidencia</span>
                                <input required type="text" name="nombre" class="form-control" value="{{$evidencia->nombre}}">
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text">Descripción</span>
                                <textarea required class="form-control" name="descripcion" id="floatingTextarea">{{$evidencia->descripcion}}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            
                            </div>
                        @endif
                        </div>
                     
                    </div>
                </div>
            </div>
            </form>
            <!-- MODAL ELIMINAR !-->
            <div class="modal fade" id="eliminarEvidencia" tabindex="-1" aria-labelledby="editarEvidenciaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning ">
                            <h5 class="modal-title" id="editarEvidenciaLabel">Advertencia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('delEvi', ['id' => $evidencia->id, 'idbit' => $evidencia->id_bitacora])}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="id" value="{{ $evidencia->id }}">
                                <input type="hidden" name="id_bitacora" value="{{$evidencia->id_bitacora}}">
                                ¿Estás seguro que deseas eliminar esta evidencia?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" name="delete" class="btn btn-danger">Si, estoy seguro</button>
                            </div>
                        </form>
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