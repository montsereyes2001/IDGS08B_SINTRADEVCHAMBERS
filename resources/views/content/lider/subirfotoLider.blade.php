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
a:hover{
color: white !important;
}
</style>
<body>
   <div class="ms-3 mt-3 text-start container">
    <a class="btn btn-outline-dark align-item-center" id="btn-reg" href='<?php echo env('URL').'ev/gallery/'.$id_bitacora;?>'><span
            class="ms-1 d-sm-inline bi bi-arrow-bar-left fs-4"></span>&nbsp;Regresar</a>
</div>
<div class="p-3">
    <h2 class="text-center mb-4">Agregar Evidencias</h2>
    @switch($trab_bit)
        @case('Obra Civil')
            <form action="{{ route('regEvidencia') }}" method="post" enctype="multipart/form-data" class="row g-3" >
            @csrf
            @method('POST')
                <div class="col-md-6 d-none">
                    <label for="" class="form-label">Registro relacionado</label>
                    <select name="id_bit" id="" class="form-select">
                    <!-- <option value="" disabled selected>Seleccione un trabajo...</option> -->
                    <?php
                    echo '<option value="'.$id_bitacora.'"selected> Registro no.'.$id_bitacora.'</option>';
                    ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Nombre de la evidencia</label>
                    <input required type="text" name="nombre" class="form-control" placeholder="Escriba un nombre...">
                </div>
                <div class="col-md-6 d-none">
                    <label for="" class="form-label">Tipo de trabajo</label>
                    {{-- <select name="id_icon" id="" class="form-select">
                        @foreach ($icon_des as $i )
                        <option disabled selected value={{$i->id}}>{{$i->nombre}}</option>
                        @endforeach
                    </select> --}}
                    <input type="hidden" name="id_icon" value={{$icon_oc}} class="form-select">
                
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Agregar una descripcion</label>
                    <textarea class="form-control" placeholder="Escriba aqui..." name="descr" id="" rows="3"></textarea>
                </div>
               
                <div class="mb-3">
                    <label for="" class="form-label col-12">Agregar foto..</label>
                    <div class="col-12">
                        <input required class="form-control" type="file" name="file" id="">
                    </div>
                    <!-- <button type="submit" name="submit" class="col-2 btn btn-outline-primary align-item-center">Enviar</button> -->
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="submit" name="" class="btn btn-outline-dark align-item-center" id="">Guardar Cambios</button>
                </div>
            </form>
            @if ($message = Session::get('success'))
            <br>
            <div class="text-center" style="justify-content:center">
                <div class="alert alert-success col-md-10 col-sm-12 mx-auto" role="alert">{{ $message }}
            </div>
            <div class="card col-md-6 col-sm-10 mx-auto">
                <?php
                $name = Session::get('name');
                $foto = Session::get('image');
                //echo'
                //<img class="card-img-top" src="'.$foto.'" alt="Card image cap">
                //<div class="card-body">
                //    <h5 class="card-title">'.$name.'</h5>';
                ?>
                <img class="card-img-top" src="{{ Session::get('image') }}" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title">{{ Session::get('name') }}</h5>'
                <!-- <img class="card-img-top" src="storage/evidencias/{{ $foto }}" alt="Card image cap"> -->
                <!-- <div class="card-body">
                    <h5 class="card-title">Card title</h5> -->
                <p class="card-text">
                    Latitud: {{ Session::get('latitud') }} <br>
                    Longitud: {{ Session::get('longitud') }} <br>
                    Altitud: {{ Session::get('altitud') }} <br>
                </p>
            </div>
            </div>
                @endif
        @break
        @case('Desmantelamiento')
            <form action="{{ route('regEvidencia') }}" method="post" enctype="multipart/form-data" class="row g-3" >
            @csrf
            @method('POST')
                <div class="col-md-6 d-none">
                    <label for="" class="form-label">Registro relacionado</label>
                    <select name="id_bit" id="" class="form-select">
                    <!-- <option value="" disabled selected>Seleccione un trabajo...</option> -->
                    <?php
                    echo '<option value="'.$id_bitacora.'"selected> Registro no.'.$id_bitacora.'</option>';
                    ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Nombre de la evidencia</label>
                    <input required type="text" name="nombre" class="form-control" placeholder="Escriba un nombre...">
                </div>
                <div class="col-md-6 d-none">
                    <label for="" class="form-label">Tipo de trabajo</label>
                    {{-- <select name="id_icon" id="" class="form-select">
                        @foreach ($icon_des as $i )
                        <option disabled selected value={{$i->id}}>{{$i->nombre}}</option>
                        @endforeach
                    </select> --}}
                    <input type="hidden" name="id_icon" value={{$icon_des}} class="form-select">
                
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Agregar una descripcion</label>
                    <textarea class="form-control" placeholder="Escriba aqui..." name="descr" id="" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label col-12">Agregar foto..</label>
                    <div class="col-12">
                        <input required class="form-control" type="file" name="file" id="">
                    </div>
                    <!-- <button type="submit" name="submit" class="col-2 btn btn-outline-primary align-item-center">Enviar</button> -->
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="submit" name="" class="btn btn-outline-dark align-item-center" id="">Guardar Cambios</button>
                </div>
            </form>
            @if ($message = Session::get('success'))
            <br>
            <div class="text-center" style="justify-content:center">
                <div class="alert alert-success col-md-10 col-sm-12 mx-auto" role="alert">{{ $message }}
            </div>
            <div class="card col-md-6 col-sm-10 mx-auto">
                <img class="card-img-top" src="{{ Session::get('image') }}" alt="Card image cap">
                <?php
                echo'
                <div class="card-body">
                    <h5 class="card-title">'.Session::get('name').'</h5>';
                ?>
                <p class="card-text">
                    Latitud: {{ Session::get('latitud') }} <br>
                    Longitud: {{ Session::get('longitud') }} <br>
                    Altitud: {{ Session::get('altitud') }} <br>
                </p>
            </div>
            </div>
                @endif
        @break
        @case('Troncal')
            <form action="{{ route('regEvidencia') }}" method="post" enctype="multipart/form-data" class="row g-3" >
            @csrf
            @method('POST')
            <div class="col-md-6 d-none">
                <label for="" class="form-label">Registro relacionado</label>
                <select name="id_bit" id="" class="form-select">
                <!-- <option value="" disabled selected>Seleccione un trabajo...</option> -->
                <?php
                echo '<option value="'.$id_bitacora.'"selected> Registro no.'.$id_bitacora.'</option>';
                ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Nombre de la evidencia</label>
                <input required type="text" name="nombre" class="form-control" placeholder="Escriba un nombre...">
            </div>
            <div class="col-md-6 d-none">
                <label for="" class="form-label">Tipo de trabajo</label>
                {{-- <select name="id_icon" id="" class="form-select">
                    @foreach ($icon_des as $i )
                    <option disabled selected value={{$i->id}}>{{$i->nombre}}</option>
                    @endforeach
                </select> --}}
                <input type="hidden" name="id_icon" value={{$icon_tron}} class="form-select">
            
            </div>
            <div class="col-12">
                <label for="" class="form-label">Agregar una descripcion</label>
                <textarea class="form-control" placeholder="Escriba aqui..." name="descr" id="" rows="3"></textarea>
                </div>

            
                <!-- <textarea class="form-control" placeholder="Escriba aqui..." name="descr" id="" rows="3"></textarea> -->
            <div class="mb-1">
                <label for="" class="form-label col-12">Agregar foto..</label>
                <div class="col-12">
                    <input required class="form-control" type="file" name="file" id="">
                </div>
                <br />
                <!-- <button type="submit" name="submit" class="col-2 btn btn-outline-primary align-item-center">Enviar</button> -->
            </div>
            <h5 style="margin-bottom: -5px">Material utilizado</h5>
            <div class="container overflow-auto" style="height:120px;" >              
            <table class="table table-borderless">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               
             @foreach ($matbit as $item)
                <tr>
                    {{-- <input required type="hidden" name="edit_id" id="edit_id"> --}}
                    <td>{{ $item->prodmatbit }} <input required type="hidden" value={{ $item->idmats }} class="form-control" name="prodmat[]"></td>
                    <td><input required class=" form-control w-85" type="number" name="cantmat[]" id="cant"></td>
                </tr>
                @endforeach
                </tbody>
        </table> 
            </div>
            <div class="col-12 text-center mt-4">
                <button type="submit" name="" class="btn btn-outline-dark align-item-center" id="">Guardar Cambios</button>
            </div>

            </form>
            @if ($message = Session::get('success'))
            <br>
            <div class="text-center" style="justify-content:center">
                <div class="alert alert-success col-md-10 col-sm-12 mx-auto" role="alert">{{ $message }}
                </div>
                <div class="card col-md-6 col-sm-10 mx-auto">
                    <img class="card-img-top" src="{{ Session::get('image') }}" alt="Card image cap">
                    <?php
                    echo'
                    <div class="card-body">
                    <h5 class="card-title">'.Session::get('name').'</h5>';
                    ?>
                    <!-- <img class="card-img-top" src="" alt="Card image cap">
                     <div class="card-body">
                    <h5 class="card-title">Card title</h5> -->
                    <p class="card-text">
                        Latitud: {{ Session::get('latitud') }} <br>
                        Longitud: {{ Session::get('longitud') }} <br>
                        Altitud: {{ Session::get('altitud') }} <br>
                    </p>
                </div>
            </div>
            @endif
        @break
        @case('Distribución')
            <form action="{{ route('regEvidencia') }}" method="post" enctype="multipart/form-data" class="row g-3" >
            @csrf
            @method('POST')
            <div class="col-md-6 d-none">
                <label for="" class="form-label">Registro relacionado</label>
                <select name="id_bit" id="" class="form-select">
                <!-- <option value="" disabled selected>Seleccione un trabajo...</option> -->
                <?php
                echo '<option value="'.$id_bitacora.'"selected> Registro no.'.$id_bitacora.'</option>';
                ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Nombre de la evidencia</label>
                <input required type="text" name="nombre" class="form-control" placeholder="Escriba un nombre...">
            </div>
            <div class="col-md-6 d-none">
                <label for="" class="form-label">Tipo de trabajo</label>
                {{-- <select name="id_icon" id="" class="form-select">
                    @foreach ($icon_des as $i )
                    <option disabled selected value={{$i->id}}>{{$i->nombre}}</option>
                    @endforeach
                </select> --}}
                <input type="hidden" name="id_icon" value={{$icon_dis}} class="form-select">
            
            </div>
            <div class="col-12">
                <label for="" class="form-label">Agregar una descripcion</label>
                <textarea class="form-control" placeholder="Escriba aqui..." name="descr" id="" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="" class="form-label col-12">Agregar foto..</label>
                <div class="col-12">
                    <input required class="form-control" type="file" name="file" id="">
                </div>
                <!-- <button type="submit" name="submit" class="col-2 btn btn-outline-primary align-item-center">Enviar</button> -->
            </div>
            <h5 style="margin-bottom: -5px">Material utilizado</h5>
            <div class="container overflow-auto" style="height:120px;" >              
            <table class="table table-borderless">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
               
             @foreach ($matbit as $item)
                <tr>
                    {{-- <input required type="hidden" name="edit_id" id="edit_id"> --}}
                    <td>{{ $item->prodmatbit }} <input required type="hidden" value={{ $item->idmats }} class="form-control" name="prodmat[]"></td>
                    <td><input required class=" form-control w-85" type="number" name="cantmat[]" id="cant"></td>
                </tr>
                @endforeach
                </tbody>
        </table> 
            <div class="col-12 text-center mt-4">
                <button type="submit" name="" class="btn btn-outline-dark align-item-center" id="">Guardar Cambios</button>
            </div>

            </form>
            @if ($message = Session::get('success'))
            <br>
            <div class="text-center" style="justify-content:center">
                <div class="alert alert-success col-md-10 col-sm-12 mx-auto" role="alert">{{ $message }}
                </div>
                <div class="card col-md-6 col-sm-10 mx-auto">
                    <img class="card-img-top" src="{{ Session::get('image') }}" alt="Card image cap">
                    <?php
                    echo'
                    <div class="card-body">
                    <h5 class="card-title">'.Session::get('name').'</h5>';
                    ?>
                    <p class="card-text">
                        Latitud: {{ Session::get('latitud') }} <br>
                        Longitud: {{ Session::get('longitud') }} <br>
                        Altitud: {{ Session::get('altitud') }} <br>
                    </p>
                </div>
            </div>
            @endif
        @break
        @case('Enlace')
            <form action="{{ route('regEvidencia') }}" method="post" enctype="multipart/form-data" class="row g-3" >
                @csrf
                @method('POST')
                <div class="col-md-6">
                    <label for="" class="form-label">Registro relacionado</label>
                    <select name="id_bit" id="" class="form-select">
                    <!-- <option value="" disabled selected>Seleccione un trabajo...</option> -->
                    <?php
                    echo '<option value="'.$id_bitacora.'"selected> Registro no.'.$id_bitacora.'</option>';
                    ?>
                    </select>
                </div>
                <div class="col-6 col-md-6 col-sm-12">
                    <label for="" class="form-label">Nombre de la evidencia</label>
                    <input required type="text" name="nombre" class="form-control" placeholder="Escriba un nombre...">
                </div>
                <div class="col-md-6">
                    <label for="" class="form-label">Poste</label>
                    <select name="id_icon" id="" class="form-select">
                        <option value="" disabled selected>Seleccione un tipo de poste...</option>
                        <?php
                        foreach($iconos as $icon){
                        echo '<option value="'.$icon->id.'">'.$icon->nombre.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="col-12">
                    <label for="" class="form-label">Agregar una descripcion</label>
                    <textarea class="form-control" placeholder="Escriba aqui..." name="descr" id="" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label col-12">Agregar foto..</label>
                    <div class="col-12">
                        <input required class="form-control" type="file" name="file" id="">
                    </div>
                    <!-- <button type="submit" name="submit" class="col-2 btn btn-outline-primary align-item-center">Enviar</button> -->
                </div>

                <div class="col-12 text-center mt-4">
                    <button type="submit" name="" class="btn btn-outline-dark align-item-center" id="">Guardar Cambios</button>
                </div>

                </form>
                @if ($message = Session::get('success'))
                <br>
                <div class="text-center" style="justify-content:center">
                    <div class="alert alert-success col-md-10 col-sm-12 mx-auto" role="alert">{{ $message }}
                    </div>
                    <div class="card col-md-6 col-sm-10 mx-auto">
                        <img class="card-img-top" src="{{ Session::get('image') }}" alt="Card image cap">
                        <?php
                        echo'
                        <div class="card-body">
                        <h5 class="card-title">'.Session::get('name').'</h5>';
                        ?>
                        <!-- <img class="card-img-top" src="" alt="Card image cap"> -->
                        <!-- <div class="card-body">
                        <h5 class="card-title">Card title</h5> -->
                        <p class="card-text">
                            Latitud: {{ Session::get('latitud') }} <br>
                            Longitud: {{ Session::get('longitud') }} <br>
                            Altitud: {{ Session::get('altitud') }} <br>
                        </p>
                    </div>
                </div>
                </div>
                @endif
            @break
    @endswitch
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>



</body>
<script type="text/javascript">
    $(document).ready(function () {
        $("#mat").click(function mat(){
          $("#material").empty();
          var theResponse = null;
          var rama = document.getElementById("rama").value;
            $.ajax({
                type: "POST",
                url: "{{route('inventRama')}}",
                data:{
                    "_token": "{{ csrf_token() }}",
                    id: rama,
                },
                dataType: "json",
                error: function(error){
                    console.log(JSON.stringify(error));
                },
                success:function(data){
                       theResponse = data;
                       //console.log(JSON.stringify(theResponse));
                       if(theResponse == null || theResponse == '' || theResponse.length == 0){
                        $("#material").append($("<h4>").text("No existe ningún material registrado para esta rama"));
                      }else{
                        $("#material").append($("<h4>").text("Material disponible"));
                        data.forEach(item=>{
                          var input required = "<input required class='form-check-input required' type='checkbox' name='off'>";
                          $("#material").append(
                            input required).attr({value:item.id}).append($("<label>").addClass("form-check-label").text(item.nombre)).append($("<br />"));
                        });
                        var checked = 0;
                        $('input required:checkbox').change(
                        function(){
                            if ($(this).is(':checked')) {
                              var total = document.getElementById("input required").value;
                              var input requireds = document.getElementsByName("off");
                              $(input requireds).attr({name:"off"});
                              checked++;
                              ($(this).attr({name:"lc"}));
                            }
                            if(checked == total){
                              var input requireds = document.getElementsByName("off");
                              $(input requireds).attr({disabled:true});
                            }
                        });
                        $("#regbit").append(' <button type="submit" class="btn btn-outline-dark align-item-center" id="btn-reg">Registrar bitacora</button>');
                      }
                }

            });
        });
    });
</script>
</html>
