<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
  
    <title>{{$title}}</title>
</head>
<body>
    <div class="ms-5 mt-3">
        <p class="fs-4 fw-bold">Usuarios</p>
    </div>
    <!-- DELETE MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Advertencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
            ¿Estás seguro que deseas eliminar este registro?
        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="submit" name="delete" class="btn btn-primary">Si!</button>
            </div>
        </div>
    </div>
</div> 

<!-- INSERT MODAL ##############################################################################-->

<div class="modal fade" id="createUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method ="post">
            <div class="modal-body">
                <!-- <form action="#" method ="post"> -->
                    <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="nombre">Nombre/s </label>
                        <input type="text" name="nombre" id="" placeholder="" class="form-control"  required>
                        </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="apat">Apellido Paterno</label>
                        <input type="text" name="apat" id="" placeholder="" class="form-control"  required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="amat">Apellido Materno</label>
                        <input type="text" name="amat" id="" placeholder="" class="form-control"  required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="tel">Telefono</label>
                        <input type="text" name="tel" id="" placeholder="" class="form-control"  required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="email">Correo</label>
                        <input type="text" name="email" id="" placeholder="" class="form-control"  required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="pass">Contraseña</label>
                        <input type="text" name="pass" id="" placeholder="" class="form-control"  required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="edo">Estatus del usuario</label>
                        <input type="text" name="edo" id="" placeholder="" class="form-control"  required>
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

<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method ="post">
            <div class="modal-body">
                <!-- <form action="#" method ="post"> -->
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="input-group mb-3">
                    <label class="control-label input-group-text" for="nombre">Nombre/s</label>
                        <input type="text" name="nombre" id="nombre" placeholder="" class="form-control"  required>
                        </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="apat">Apellido Paterno</label>
                        <input type="text" name="apat" id="apat" placeholder="" class="form-control"  required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="amat">Apellido Materno</label>
                        <input type="text" name="amat" id="amat" placeholder="" class="form-control"  required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="tel">Telefono</label>
                        <input type="text" name="tel" id="tel" placeholder="" class="form-control"  required>
                    </div>
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="email">Correo</label>
                        <input type="text" name="email" id="email" placeholder="" class="form-control" disabled>
                    </div>
                    <!-- <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="pass">Password</label>
                        <input type="text" name="pass" id="pass" placeholder="" class="form-control"  required>
                    </div> -->
                    <div class="input-group mb-3">
                        <label class="control-label input-group-text" for="edo">Estatus del usuario</label>
                        <input type="text" name="edo" id="edo" placeholder="" class="form-control"  required>
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
    echo'<div class="ms-4 me-4">';
    echo "<table class='table table-hover text-center'
    data-toggle='table'
    data-pagination='true'
    data-search='true'
    data-search-align = 'left'
    data-show-columns='true'
    data-show-toggle = 'true'
    data-show-refresh= 'true'
    data-show-pagination-switch='true'
    data-pagination-pre-text='Previous'
    data-pagination-next-text='Next'
    data-pagination-h-align='left'
    data-pagination-detail-h-align='right'
    sortable = 'true'
    pagination = 'true'
    data-page-list = '[10, 20, 30, 40, 50, All]'>
    <thead class='table-dark'>
    <tr>
        <th data-field='id' data-sortable='true'>id</th>
        <th data-field='name' data-sortable='true'>Nombre</th>
        <th data-field='apat' data-sortable='true'>Ap_paterno</th>
        <th data-field='amat' data-sortable='true'>Ap_materno</th>
        <th data-field='email' data-sortable='true'>Correo</th>
        <th data-field='tel' data-sortable='true'>Telefono</th>
        <th data-field='stat' data-sortable='true'>Estatus</th>
        <th data-sortable='true'>Created_at</th>   
        <th data-sortable='true'>Updated_at</th>
        <th>Editar</th>  
        <th>Eliminar</th>        
    </tr>
    </thead>
    ";
    foreach($response as $row)
    {
        echo"<tr>";
        echo"<td> $row->id</td>";
        echo"<td> $row->nombre</td>";
        echo"<td> $row->apellido_paterno</td>";
        echo"<td> $row->apellido_materno</td>";
        echo"<td> $row->correo</td>";
        echo"<td> $row->telefono</td>";
        echo"<td> $row->estado</td>";
        echo"<td> $row->created_at</td>";
        echo"<td> $row->updated_at</td>";
        
        echo '<td><button type="button" class ="btn btn-outline-warning editbtn">Editar </button></td>';
        echo '<td><button type="button" class ="btn btn-outline-danger">Eliminar </button></td>';
        
        echo"</tr>";
    }
    echo "</div>";
    echo "</tbody> </table>";
    
    if(isset($_POST['insert'])){
        $nombre = $_POST['nombre'];
        $apat = $_POST['apat'];
        $amat = $_POST['amat'];
        $correo = $_POST['email'];
        $tel = $_POST['tel'];
        $stat = $_POST['edo'];
        $pass = $_POST['pass'];

        $add= "CALL createUsuario('$nombre','$apat','$amat','$correo','$tel','$stat','$pass')";
        $results=$db->Insert($add);
        echo "<div class='alert alert-success'>Usuario Registrado</div>";
    }
    if(isset($_POST['edit'])){
        $id = $_POST['edit_id'];
        $nombre = $_POST['nombre'];
        $apat = $_POST['apat'];
        $amat = $_POST['amat'];
        $correo = $_POST['email'];
        $tel = $_POST['tel'];
        $stat = $_POST['edo'];

    }
    ?>
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createUser">
    Agregar
    </button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>

<script>
    $(document).ready(function() {
        $('.editbtn').on('click', function(){
            $('#editUser').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children('td').map(function(){
                return $(this).text();
            }).get();

            console.log(data);

            $('#edit_id').val(data[0]);
            $('#nombre').val(data[1]);
            $('#apat').val(data[2]);
            $('#amat').val(data[3]);
            $('#email').val(data[4]);
            $('#tel').val(data[5]);
            $('#edo').val(data[6]);

        });
    });

</script>
</body>
</html>