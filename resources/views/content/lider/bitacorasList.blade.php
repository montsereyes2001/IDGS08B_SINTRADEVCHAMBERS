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
$lider = $_SESSION['Correo'];
$lista = $_SESSION['listado'];
?>

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

    <title>{{$title}}</title>
</head>
<style>
.modal-backdrop
{
    opacity:0.025 !important;
}
.pagination>li>a, .pagination>li>span{
  background-color: white !important;
  height: 35px !important;
  margin-bottom: 30px !important;

}
.pagination>li>a:hover, .pagination>li>span:hover{
  background-color: rgb(33,37,41,1) !important;
  color: white !important; 

}
.pagination {
    border: none !important;
}

</style>
<body>
    <div class="ms-3 mt-5">
        <p class="fs-4 fw-bold">Listado de Registros</p>
    </div>
<!-- DELETE MODAL -->

<!-- INSERT MODAL ##############################################################################-->

<!-- EDIT MODAL ########################################################################### -->

<div class="modal fade" id="editBitacora" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method ="post">
            <div class="modal-body">
                @csrf
                <!-- <form action="#" method ="post"> -->
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="tipo">Tipo de Trabajo</label>
                        <input type="text" name="tipo" id="tipo" placeholder="" class="form-control"  disabled>
                        </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="rama">Rama</label>
                        <input type="text" name="rama" id="rama" placeholder="" class="form-control"  disabled>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="lider">Lider</label>
                        <input type="text" name="lider" id="lider" placeholder="" class="form-control"  disabled>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="ciudad">Ciudad</label>
                        <input type="text" name="ciudad" id="ciudad" placeholder="" class="form-control"  disabled>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="estado">Estado</label>
                        <input type="text" name="estado" id="estado" placeholder="" class="form-control" disabled>
                    </div>
                    
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="edo">Estatus</label>
                        <select class="form-select" name="edo" id="edo" aria-label="Default select example">
                            <option value="En progreso">En progreso</option>
                            <option value="Terminada">Terminada</option>
                            <option value="Inactivo">Inactiva</option>
                        </select>
                    </div>
                    </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" name="edit" class="btn btn-primary">Aceptar</button>
            </div>
            </form>
        </div>
    </div>
</div> 
    <?php
     echo'<div class="ms-4 me-4">';
    echo "<table id='table_user' class='table responsive' width='100%'>
    <thead class='table-dark'>
    <br>
    <tr>
        <th class='text-center'>ID</th>
        <th class='text-center'>Tipo de tarbajo</th>
        <th class='text-center'>Rama</th>
        <th class='text-center'>Lider a cargo</th>
        <th class='text-center'>Ciudad</th>
        <th class='text-center'>Estado</th>
        <th class='text-center'>Estatus</th>
        <th class='text-center'>Creado el</th>   
        <th class='text-center'>Modificado el</th>
        <th class='text-center'>Editar estatus</th>        
    </tr>
    </thead>
    ";
    foreach($lista as $row)
    {
        echo"<tr>";
        echo"<td class='text-center'> $row->id</td>";
        echo"<td class='text-center'> $row->trabajo</td>";
        echo"<td class='text-center'> $row->rama</td>";
        echo"<td class='text-center'> $row->nombre_lider</td>";
        echo"<td class='text-center'> $row->ciudad</td>";
        echo"<td class='text-center'> $row->estado</td>";
        echo"<td class='text-center'> $row->estatus</td>";
        echo"<td class='text-center'> $row->created_at</td>";
        echo"<td class='text-center'> $row->updated_at</td>";
        
        echo '<td class="text-center"><button type="button" class ="btn btn-outline-warning text-center editbtn">Editar</button></td>';
        //echo '<td><button type="button" class ="btn btn-outline-danger deletebtn">Eliminar </button></td>';
        
        echo"</tr>";
    }
      echo "</div>";
    echo "</tbody> </table>";
    
    
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>

<script>
    // $(document).ready(function () {
    //     $('#table_user').dataTable();  
    // });
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
    },
});

              table.on('click','.editbtn',function (){
            $tr = $(this).closest('tr');

            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#edit_id').val(data[0]);
            $('#tipo').val(data[1]);
            $('#rama').val(data[2]);
            $('#lider').val(data[3]);
            $('#ciudad').val(data[4]);
            $('#estado').val(data[5]);
            $('#edo').val(data[6]);

            $('#editBitacora').modal('show');
        })
        
    });

</script>
</body>
</html>