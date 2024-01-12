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
    <title>{{$title}}</title>
    
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

</style>
<body>
 <div class="ms-3 mt-3">
        <p class="fs-4 fw-bold text-start">Ramas</p>
    </div>
    <!-- DELETE MODAL -->
<div class="modal fade" id="deleteRama" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning ">
                <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form action="{{route('delRama')}}" method ="post">
            @csrf
            @method('delete')
        <div class="modal-body">
            <input type="hidden" name="del_id" id="del_id">
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
<div class="modal fade" id="createRama" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar rama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('registroRama')}}" method ="post">
            <div class="modal-body">
                @csrf
                <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="nombre">Nombre de la rama  </label>
                        <input type="text" name="nombre" id="" placeholder="" class="form-control"  required>
                        </div>
                <!-- <form action="#" method ="post"> -->
                <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="id_invitado">Invitado</label>
                        <select class="form-select" name="id_invitado" id="" aria-label="Default select example">
                        <?php
                        foreach ($invitados as $inv){
                            echo'<option value="'.$inv->id.'">'.$inv->nombre.'</option>';
                        }
                        ?>
                        </select>
                        
                    </div>
                    <div class="input-group mb-3">

                        <label class="control-label input-group-text" for="id_cliente">Cliente</label>
                        <select class="form-select" name="id_cliente" id="" aria-label="Default select example">
                        <?php
                        foreach ($clientes as $cliente){
                            echo'<option value="'.$cliente->id.'">'.$cliente->nombre_empresa.': '.$cliente->ciudad.', '.$cliente->estado.'</option>';
                        }
                        ?>
                        </select>
                        
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

<!-- EDIT MODAL ########################################################################### -->

<div class="modal fade" id="editRama" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Rama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('editarRama')}}" method ="post">
            <div class="modal-body">
                @csrf
                @method('put')
                <!-- <form action="#" method ="post"> -->
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="nombre">Nombre de la rama</label>
                        <input type="text" name="nombre" id="nombre" placeholder="" class="form-control">
                    </div>
                  <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="id_invitado">Invitado</label>
                        <select class="form-select" name="id_invitado" id="id_invitado" aria-label="Default select example">
                        <?php
                        foreach ($invitados as $inv){
                            echo'<option value="'.$inv->id.'">'.$inv->nombre.'</option>';
                        }
                        ?>
                        </select>
                        
                    </div>
                    <div class="input-group mb-3">

                        <label class="control-label input-group-text" for="id_cliente">Cliente</label>
                        <select class="form-select" name="id_cliente" id="id_cliente" aria-label="Default select example">
                        <?php
                        foreach ($clientes as $cliente){
                            echo'<option value="'.$cliente->id.'">'.$cliente->nombre_empresa.'</option>';
                        }
                        ?>
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

    <?php
          echo'<div class="ms-3 me-5">';
     echo '<table id="example" class="table responsive" width="100%">
    <thead class= "table-dark">
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createRama">
    Agregar
    </button>
    <br>
    <br>
     <tr>
        <th class="text-center">ID</th>
        <th class="text-center">Nombre</th>
        <th class="d-none"></th>  
        <th class="text-center">Empresa</th>
        <th class="d-none"></th> 
        <th class="text-center">Invitado</th>
               
        <th class="text-center"></th>  
        <th class="text-center"></th>         
    </tr>
    </thead>
     <tbody>
    ';
    foreach($response as $row)
    {
        echo"<tr>";
        echo"<td class='text-center'> $row->id</td>";
        echo"<td class='text-center'> $row->nombre</td>";
        echo"<td class ='d-none'> $row->id_empresa</td>";
        echo"<td class='text-center'> $row->empresa</td>";
        echo"<td class ='d-none'> $row->id_invitado</td>";
        echo"<td class='text-center'> $row->invitado</td>";
        
        echo '<td><button type="button" class ="btn btn-outline-warning editbtn">Editar </button></td>';
        echo '<td><button type="button" class ="btn btn-outline-danger deletebtn">Eliminar </button></td>';
        
        echo"</tr>";
    }
    echo "</div>";
    echo "</tbody>
     </table>";

    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.2.4/js/dataTables.fixedHeader.min.js"></script>
    <script type="text/javascript">


       $(document).ready(function() {
        var table = $('#example').DataTable({
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
            $('#nombre').val(data[1]);
            $('#id_cliente').val(data[2]);
            $('#id_invitado').val(data[4]);

            $('#editRama').modal('show');
        })
        
    });
   
    $(document).ready(function() {
        var table = $('#example').DataTable();

        table.on('click','.deletebtn',function (){
            $tr = $(this).closest('tr');

            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            $('#del_id').val(data[0]);

            $('#deleteRama').modal('show');
        })
});

    </script>

</body>
</html>
<script>
    $(document).ready(function() {
        $('.editbtn').on('click', function(){
            $('#editRama').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();

            console.log(data);

            $('#edit_id').val(data[0]);
            $('#nombre').val(data[1]);
            $('#id_invitado').val(data[4]);
            $('#id_cliente').val(data[2]);

        });
    });
    $(document).ready(function() {
        $('.deletebtn').on('click', function(){
            $('#deleteRama').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();

            console.log(data);

            $('#del_id').val(data[0]);

        });
    });

</script>



