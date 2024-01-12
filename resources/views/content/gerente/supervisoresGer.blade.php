<?php 
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
        header('Location: '.env('URL').'login ');
                exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Gerente'){
    header('Location: '.env('URL').'login ');
            exit();
}
$tipoUs=$_SESSION['TipoUs'];
$gerente = $_SESSION['Correo'];
$lista = $_SESSION['listado'];
?>
@include('layouts.sidebarDashboard')
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
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
    </head>

<body>
    <div class="ms-3">
        <p class="fs-4 fw-bold">{{$title}}</p>
    </div>
<!-- DELETE MODAL ##############################################################################-->
<div class="modal fade" id="deleteSup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning ">
                <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form action="{{route('delGerSup')}}" method ="post">
            @csrf
            @method('delete')
        <div class="modal-body"> 
        <?php echo '<input type="hidden" name="del_ger" id="" value='.$gerente.'>';?>
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
<div class="modal fade" id="createSup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Relacionar Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('regGerSup')}}" method ="post">
            <div class="modal-body">
                @csrf
                
                <div class="mb-3">
                    <p>Supervisores Disponibles</p>
                </div>
                
                <?php
                    echo '<input type="hidden" name="correo_gerente" id="" value='.$gerente.'>';
                ?>
                <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="sup">Supervisor</label>
                        <select class="form-select" name="sup" id="" aria-label="Default select example">
                        <?php
                        foreach ($supervisores as $sup){
                                echo'<option value="'.$sup->id.'">'.$sup->nombre_usuario.'</option>';
                        }
                        ?>
                        </select>
                </div>
                <!-- <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="edo">Estatus</label>
                        <select class="form-select" name="edo" id="" aria-label="Default select example">
                                <option value="Activo">Activo</option>
                                <option value="Inactivo" selected>Inactivo</option>
                        </select>
                </div> -->
    
                    
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

<div class="modal fade" id="editSup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('editGerSup')}}" method ="post">
            <div class="modal-body">
                @csrf
                @method('PUT')
                <input type="hidden" name="edit_id" id="edit_id">
                <?php echo '<input type="hidden" name="edit_ger" id="" value='.$gerente.'>';?>
                <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="id_sup">Supervisor</label>
                        <select class="form-select" name="id_sup" id="id_sup" aria-label="Default select example">
                        <?php
                        foreach ($supervisores as $sup){
                                echo'<option value="'.$sup->id.'">'.$sup->nombre_usuario.'</option>';
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
    echo "<table id='table_user' class='table responsive' width='100%'>
    <thead class='table-dark'>
       <button type='button' class='btn btn-outline-success mb-3' data-bs-toggle='modal' data-bs-target='#createSup'>
    Agregar
    </button>
    <br>
    <br>
        <th>ID</th>
        <th class='d-none'></th>
        <th class='text-center'>Gerente</th>
        <th class='d-none'>Id_supervisor</th>
        <th class='text-center'>Supervisor</th> 
        <th></th>  
        <th></th>        
    </tr>
    </thead>
    ";
    foreach($lista as $row)
    {
        echo"<tr>";
        echo"<td class='text-center'> $row->id</td>";
        echo"<td class='d-none'> $row->id_gerente</td>";
        echo"<td class='text-center'> $row->gerente</td>";
        echo"<td class='d-none'> $row->id_supervisor</td>";
        echo"<td class='text-center'> $row->supervisor</td>";
                        
        echo '<td class="text-center"><button type="button" class ="btn btn-outline-warning editbtn">Editar </button></td>';
        echo '<td class="text-center"><button type="button" class ="btn btn-outline-danger deletebtn ">Eliminar </button></td>';
        
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
              table.on('click','.editbtn',function (){
            $tr = $(this).closest('tr');

            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);

            
            $('#edit_id').val(data[0]);
            $('#id_sup').val(data[3]);
            $('#editSup').modal('show');
        })
        
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

            $('#deleteSup').modal('show');
        })
        
    });
</script>
{{-- <script>
    $(document).ready(function() {
        $('.editbtn').on('click', function(){
            $('#editSup').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();

            console.log(data);

            $('#edit_id').val(data[0]);
            $('#id_sup').val(data[3]);
            
            
            

        });
    });
    $(document).ready(function() {
        $('.deletebtn').on('click', function(){
            $('#deleteSup').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();

            console.log(data);

            $('#del_id').val(data[0]);

        });
    });

</script> --}}
</body>
</html>