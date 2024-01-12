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
</head>
<body>
     <div class="ms-3 mt-3">
        <p class="fs-4 fw-bold">Inventario</p>
    </div>
    <div class="modal fade" id="deleteInvent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning ">
                <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <form action="{{route('destroyInventario')}}" method ="post">
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
<div class="modal fade" id="createInvent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar inventario</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('addInventario')}}" method="post">
            <div class="modal-body">
                @csrf
                <!-- <form action="#" method ="post"> -->

                <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="user">Ramas</label>
                    <select class="form-select ramas-select" name="id_rama" id="" aria-label="Default select example">
                        <option disabled selected>Selecciona una rama</option>
                        <?php
                        foreach ($ramas as $r){
                            echo'<option value="'.$r->id.'">'.$r->nombre.'</option>';
                        }
                        ?>
                    </select>

                </div>
                <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="user">Productos</label>
                    <select class="form-select productos-select" name="id_producto" id=""
                        aria-label="Default select example">
                        <option disabled selected>Selecciona un producto</option>
                        <?php
                        foreach ($productos as $p){
                            echo'<option value="'.$p->id.'">'.$p->nombre.'</option>';
                        }
                        ?>
                    </select>

                </div>
                <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="nombre">Cantidad de producto </label>
                    <input type="number" name="cantidad" id="" placeholder="" class="form-control" required>
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

<div class="modal fade" id="editInvent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Inventario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('updateInventario')}}" method ="post">
            <div class="modal-body">
                @csrf
                @method('put')
                <!-- <form action="#" method ="post"> -->
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="user">Ramas</label>
                        <select class="form-select ramas-select" name="id_rama" id="" aria-label="Default select example">
                            <option disabled selected>Selecciona una rama</option>
                            <?php
                                            foreach ($ramas as $r){
                                                echo'<option value="'.$r->id.'">'.$r->nombre.'</option>';
                                            }
                                            ?>
                        </select>
                    
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="user">Productos</label>
                        <select class="form-select productos-select" name="id_producto" id="" aria-label="Default select example">
                            <option disabled selected>Selecciona un producto</option>
                            <?php
                                            foreach ($productos as $p){
                                                echo'<option value="'.$p->id.'">'.$p->nombre.'</option>';
                                            }
                                            ?>
                        </select>
                        
                    </div>
                    <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="nombre">Cantidad de producto  </label>
                        <input type="number" name="cantidad" id="cantidad" placeholder="" class="form-control"  required>
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
       <button type='button' class='btn btn-outline-success' data-bs-toggle='modal' data-bs-target='#createInvent'>
    Agregar
    </button>
    <br>
    <br>
    <tr>
        <th class='text-center'>ID</th>
        <th class='d-none'></th>
        <th class='text-center'>Nombre de rama</th>
        <th class='text-center'>Producto</th>
        <th class='d-none'></th>
        <th class='text-center'>Cantidad</th>
        <th class='text-center'>Creado el</th>
        <th class='text-center'>Modificado el</th>
        <th></th>  
     
    </tr>
    </thead>
    ";
    foreach($response as $row)
    {
        echo"<tr>";
        echo"<td class='text-center' > $row->id</td>";
        echo"<td class='d-none'> $row->id_rama</td>";
        echo"<td class='text-center'> $row->Rama</td>";
        echo"<td class='text-center'> $row->Producto</td>";
        echo"<td class='d-none'> $row->id_producto</td>";
        echo"<td class='text-center'> $row->Cantidad</td>";
        echo"<td class='text-center'> $row->created_at</td>";
        echo"<td class='text-center'> $row->updated_at</td>";
        
        echo '<td><button type="button" class ="btn btn-outline-warning editbtn">Editar </button></td>';
       /* echo '<td><button type="button" class ="btn btn-outline-danger deletebtn">Eliminar </button></td>';*/
        
        echo"</tr>";
    }
    echo "</div>";
    echo "</tbody> </table>";

    ?>
    <script  script src="https://code.jquery.com/jquery-3.5.1.js"></script>
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
            $('#id_rama').val(data[1]);
            $('#id_producto').val(data[4]);
            $('#cantidad').val(data[5]);

            $('#editInvent').modal('show');
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

            $('#deleteInvent').modal('show');
        })
        
    });
</script>
<script>
    $(document).ready(function() {
        $('.ramas-select').on('change', function() {
            let selectedRamaId = $(this).val();
           $.ajax({
        url: '{{route('filtroInvProd')}}',
        type: 'POST',
        data: {
        _token: '{{ csrf_token() }}',
        selectedRamaId: selectedRamaId
        },
        success: function(data) {
            let select = $('.productos-select');
            select.empty();
            data.forEach(function(producto) {
            select.append($('<option>', {
                value: producto.id,
                text: producto.nombre
                }));
                });
                }
            });
        });
    });
</script>
</body>
</html>