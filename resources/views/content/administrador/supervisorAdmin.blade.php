<?php
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
    header('Location: '.env('URL').'login ');
            exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Administrador'){
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
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
    <title>Dashboard | Supervisores</title>
    </head>
<style>
.modal-backdrop
{
    opacity:0.025 !important;
}
.pagination>li>a:hover, .pagination>li>span:hover{
  background-color: white !important;
  color: black !important;
  height: 35px !important;
  margin-bottom: 30px !important;
   border: solid 1px #000000 !important;

}
ul.pagination .page-link{
  border: none;
}

.pagination>li>a, .pagination>li>span{
  background-color: rgb(33,37,41,1) !important;
  color: white !important; 
  margin-top:10px !important;
  border: solid 1px rgb(33,37,41,1)!important;

}

.paginate_button.active .page-link {
  background-color: grey !important;
  box-shadow: none;
}
.pagination {
    border: none !important;
}
.btn-outline-warning:hover{
    color: white !important;
}
.btn-outline-warning:focus{
color: white !important;
}
</style>
<body>
    <div class="ms-3 mt-3">
        <p class="fs-4 fw-bold">Supervisores</p>
    </div>

    <div class="ms-3 mt-3 me-3">
      @if (Session::get('message'))
    <div class="alert alert-success text-center" role="alert">
        {{Session::get('message')}}
    </div>
    @elseif(Session::get('messageDelete'))
    <div class="alert alert-danger text-center" role="alert">
        {{Session::get('messageDelete')}}
    </div>
    @endif
    </div>
    <!-- DELETE MODAL -->
<div class="modal fade" id="deleteSup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning ">
                <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form action="{{route('supervisoresDelete')}}" method ="post">
            @method('put')
            @csrf
        <div class="modal-body">
            <input type="hidden" name="id_sup" id="id_sup">
            ¿Estás seguro que deseas eliminar este registro? Otras tablas pueden verse afectadas.
            Recuerda que puedes editar los registros que desees. 
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="delete" class="btn btn-danger">Si, estoy seguro</button>
            </div>
            </form>
        </div>
    </div>
</div> 

<!-- INSERT MODAL ##############################################################################-->

<div class="modal fade" id="createSup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
           <div class="text-center mt-3"><p>En este apartado se agrega el supervisor al respectivo gerente</p></div>
            <form action="{{route('supervisoresRegAdmin')}}" method="post">
                <div class="modal-body">
                    @csrf
                  <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="user">Usuario</label>
                    <select class="form-select" name="supervisor" id="supervisor">
                        @foreach ($supervisores as $user )
                        <option value="{{$user->id}}" data-email="{{$user->correo}}">
                            {{$user->nombre}} {{$user->apellido_paterno}} {{$user->apellido_materno}}
                        </option>
                        @endforeach
                    </select>
                </div>
               <div class="input-group mb-3">
                <input type="text" disabled name="sup" class="form-control">
            </div>

            
            <div class="input-group mb-3">
                <label class="control-label input-group-text" for="user">Gerente</label>
                <select class="form-select" name="gerente" id="gerente">
                    <option value="">Sin gerente</option>
                    @foreach ($gerentes as $user )
                    <option value="{{$user->id}}" data-email="{{$user->correo}}">
                        {{$user->nombre_usuario}}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="input-group">
                <input type="text" disabled name="ger" class="form-control">
            </div>
        </div>
                 <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="insert" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- UPDATE MODAL ##############################################################################-->
<div class="modal fade" id="editSup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar gerente de supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('supervisoresUpdateAdmin')}}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="id_sup" name="id_sup">
                    <div class="form-group">
                        <label for="nombre_sup">Supervisor</label>
                        <input disabled type="text" class="form-control" id="nombre_sup" name="nombre_sup">
                    </div>
                    <div class="form-group">
                        <label for="nombre_ger">Asignado a Gerente</label>
                        <select class="form-select" name="id_ger" id="gerente">
                            <option value="">Sin gerente</option>
                            @foreach ($gerentes as $user )
                            <option value="{{$user->id}}" data-email="{{$user->correo}}">
                                {{$user->nombre_usuario}}
                            </option>
                            @endforeach
                        </select>
                    <input type="hidden" id="relacion" name="relacion">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
    

    <div class="ms-3 me-5">
    <table id='table_user' class='table responsive' width='100%'>
    <thead class='table-dark'>
    <button type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#createSup'>
        Agregar
    </button>
    <br>
    <br>
    <tr>
        <th class='d-none'>ID</th>
        <th class='text-center'>Supervisor</th>
        <th class='d-none'></th>
        <th class='text-center'>Asignado a Gerente</th>
        <th class='d-none'></th>
        <th></th>
        <th></th>
       
    </tr>
    </thead>
    
    @foreach($response as $row)
        <tr>
        <td class='d-none'> {{$row->id_sup}}</td>
        <td class='text-center'> {{$row->nombre_sup}}</td>
        <td class='d-none'> {{$row->id_ger}}</td>
        <td class='text-center'> 
        @if($row->nombre_ger == '')
        <?php echo 'Sin gerente a cargo'; ?>
        @else
            <?php echo $row->nombre_ger ?>
        @endif
        </td>
        <td class='d-none'>{{$row->relacion}}</td>
     <td class="text-center">
        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editSup"
            data-id="{{$row->id_sup}}">Editar</button>
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteSup"
            data-id="{{$row->id_sup}}">Eliminar</button>
    </td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
 
<script>
    $(document).ready(function() {
        $('input[name="sup"]').val($('#supervisor option:first').data('email'));
        $('input[name="ger"]').val($('#gerente option:first').data('email'));
        $('#supervisor').change(function() {
            $('input[name="sup"]').val($('#supervisor option:selected').data('email'));
        });
        $('#gerente').change(function(){
            $('input[name="ger"]').val($('#gerente option:selected').data('email'));
        })
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#table_user').DataTable({
            "pagingType": "simple_numbers",
            "responsive": true,
             "columnDefs": [
    { "targets": [ 0 ],
      "className": "hide_column"
    }
  ],
           "language": {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});
        
    });
   
    $(document).ready(function() {
        var table = $('#table_user').DataTable();

        table.on('click','.deletebtn',function (){
            $tr = $(this).closest('tr');

            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#del_id').val(data[0]);

            $('#deleteUser').modal('show');
        })
        
    });
</script>
<script>
//     $(document).ready(function(){
// $('#table_user').on('click', '.btn-outline-warning', function() {
// let tr = $(this).closest('tr');
// let data = tr.children("td").map(function() {
// return $(this).text();
// }).get();

// $('#editSup #id_sup').val(data[0].trim());
// $('#editSup #nombre_sup').val(data[1].trim());
// $('#editSup #id_ger').val(data[2].trim());
// $('#editSup #relacion').val(data[4].trim());

// let gerente = data[3].trim();
// if (gerente === "Sin gerente a cargo") {
// gerente = "";
// }

// $('#editSup #gerente option').filter(function() {
//     return $(this).text().trim() === gerente;
// }).prop('selected', true);
// });
// });
$('#editSup').on('show.bs.modal', function (event) {
let button = $(event.relatedTarget)
let id_sup = button.data('id')
let nombre_sup = button.closest("tr").find("td:eq(1)").text()
let id_ger = button.closest("tr").find("td:eq(2)").text()
let nombre_ger = button.closest("tr").find("td:eq(3)").text()
let relacion = button.closest("tr").find("td:eq(4)").text()

let modal = $(this)
modal.find('.modal-body #id_sup').val(id_sup)
modal.find('.modal-body #nombre_sup').val(nombre_sup)
modal.find('.modal-body #id_ger').val(id_ger)
modal.find('.modal-body #relacion').val(relacion)

let gerente = nombre_ger.trim();
if (gerente === "Sin gerente a cargo") {
gerente = null;
}

$('#editSup #gerente option').prop('selected', false);

if (gerente !== null) {
$('#editSup #gerente option').filter(function() {
let optionText = $(this).text().trim();
return optionText === gerente;
}).prop('selected', true);
}
});

$('#deleteSup').on('show.bs.modal', function (event) {
let button = $(event.relatedTarget)
let id_sup = button.data('id')

let modal = $(this)
modal.find('.modal-body #id_sup').val(id_sup)
});
</script>
</body>
</html>

