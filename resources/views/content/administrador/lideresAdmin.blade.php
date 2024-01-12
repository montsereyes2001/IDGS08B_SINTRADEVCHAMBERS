<?php 
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
    header('Location: '.env('URL').'login ');
                exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Administrador'){
    header('Location: '.env('URL').'login ');
            exit();
}
$tipoUs=$_SESSION['TipoUs'];
$gerente = $_SESSION['Correo'];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.sidebarDashboard')
  <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.4/css/fixedHeader.bootstrap.min.css">
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


</style>
<body>
    <div class="ms-3">
        <p class="fs-4 fw-bold">Lideres</p>
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

<!-- DELETE MODAL ##############################################################################-->
<div class="modal fade" id="deleteLid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning ">
                <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form action="{{route('deleteLiderAdmin')}}" method ="post">
            @csrf
            @method('put')
        <div class="modal-body"> 
            <input type="hidden" name="id_lid" id="id_lid">
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
                <h5 class="modal-title" id="exampleModalLabel">Agregar lider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="text-center mt-3">
                    <p>En este apartado se agrega el lider al respectivo supervisor</p>
                </div>
            <form action="{{route('supervisoresRegAdmin')}}" method ="post">
            <div class="modal-body">
                @csrf
                <div class="input-group mb-3">
            <label class="control-label input-group-text" for="user">Usuario</label>
                <select class="form-select" name="lider" id="lider">
                    @foreach ($lideres as $user )
                    <option value="{{$user->id}}" data-email="{{$user->correo}}">
                        {{$user->nombre}} {{$user->apellido_paterno}} {{$user->apellido_materno}}
                    </option>
                    @endforeach
                </select>
                </div>
                <div class="input-group mb-3">
                    <input type="text" disabled name="lider" class="form-control">
                </div>


                <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="sup">Supervisores</label>
                        <select class="form-select" name="sup" id="sup" aria-label="Default select example">
                            <option value="">Sin gerente</option>
                      @foreach ($supervisores as $user)
                    <option value="{{$user->id}}" data-email="{{$user->correo}}">
                        {{$user->nombre_usuario}}
                    </option>
                    @endforeach
                        </select>
                </div>
                <div class="input-group">
                    <input type="text" disabled name="sup" class="form-control">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="insert" class="btn btn-primary">Agregar</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div> 

<!-- EDIT MODAL ########################################################################### -->
<div class="modal fade" id="editLid" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('updateLiderAdmin')}}" method="post">
                    @csrf
                    @method('PUT')
                   <input type="hidden" id="id_lid" name="id_lid">
                    <input type="hidden" id="relacion" name="relacion">
                    <div class="form-group mb-3">
                        <label for="lider">Lider</label>
                        <input class="form-control" type="text" disabled name="lidersup" id="lidersup">
                    </div>
                    <div class="form-group">
                        <label for="sup">Asignado a supervisor</label>
                        <select class="form-select" name="sup" id="sup" aria-label="Default select example">
                            <option value="">Sin supervisor</option>
                            @foreach ($supervisores as $user)
                            <option value="{{$user->id}}">{{$user->nombre_usuario}}</option>
                            @endforeach
                        </select>
                       
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="edit" class="btn btn-primary">Aceptar</button>
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
    <tr >
      <th class='d-none'>id_lid</th>
      <th class='text-center'>Líder</th>
      <th class='d-none' >id_sup</th>
      <th class='text-center'> Asignado al Supervisor</th>
      <th class='d-none'>relacion</th>      
      <th></th>
      <th></th>
    </tr>
    </thead>
    @foreach($response as $row)
        <tr>
        <td class='d-none'>{{$row->id_lid}}</td>
        <td class='col-4 text-center'>{{$row->nombre_lid}}</td>
        <td class='d-none'>{{$row->id_sup}}</td>
        <td class='col-4 text-center'> @if($row->nombre_sup == '')<?php echo 'Sin supervisor a cargo'; ?> @else{{$row->nombre_sup}}@endif  
        </td>
        <td class='d-none'>{{$row->relacion}}</td>
        <td class="text-center">
        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editLid"
            data-id-lid="{{$row->id_lid}}" data-id-sup="{{$row->id_sup}}" data-relacion="{{$row->relacion}}">
            Editar
        </button>
        </td>
        <td class="text-center">
           <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteLid"
            data-id-lid="{{$row->id_lid}}">Eliminar</button>
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
        $('input[name="lider"]').val($('#lider option:first').data('email'));
        $('input[name="sup"]').val($('#sup option:first').data('email'));
        $('#lider').change(function() {
            $('input[name="lider"]').val($('#lider option:selected').data('email'));
        });
        $('#sup').change(function(){
            console.log($('#sup option:selected').data('email'));
            $('input[name="sup"]').val($('#sup option:selected').data('email'));
        })
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#table_user').DataTable({
            "pagingType": "simple_numbers",
            "responsive": true,
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
            // $('#editLid').modal('show'); 
    });
   
 $('#table_user').on('click', 'button[data-bs-target="#editLid"]', function() {
// Retrieve the lider value from the corresponding row
var lider = $(this).closest('tr').find('td:eq(1)').text().trim();
console.log(lider);
// Set the value in the #lider input field
$('#lidersup').val(lider);
console.log('Lider: ', lider);
// Retrieve the id_lid, id_sup, and relacion values from the data attributes of the button
var id_lid = $(this).data('id-lid');
var id_sup = $(this).data('id-sup');
var relacion = $(this).data('relacion');

// Set the values in the corresponding fields in the modal form
$('#id_lid').val(id_lid);
$('#id_sup').val(id_sup);
$('#relacion').val(relacion);

// Retrieve the id_sup value from the corresponding row
var id_sup = $(this).closest('tr').find('td:eq(2)').text().trim();

// Set the selected option in the #sup select element to match the id_sup value
$('#sup option[value="' + id_sup + '"]').prop('selected', true);
});
var id_lid = $(this).data('id-lid');

// Set the value in the #id_lid input field
$('#id_lid').val(id_lid);

// Retrieve the lider value from the corresponding row
var lider = $(this).closest('tr').find('td:eq(1)').text().trim();

// Set the value in the #lider input field
$('#lider').val(lider);
$('#table_user').on('click', 'button[data-bs-target="#deleteLid"]', function() {
// Retrieve the id_lid value from the data attribute of the button
var id_lid = $(this).data('id-lid');

// Set the value in the #id_lid input field
$('#id_lid').val(id_lid);

// Retrieve the lider value from the corresponding row
var lider = $(this).closest('tr').find('td:eq(1)').text().trim();

// Set the value in the #lider input field
$('#lider').val(lider);
});
</script>
</body>
</html>

