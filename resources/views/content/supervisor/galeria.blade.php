<?php
// dd($evidencias);
session_start();
if(empty($_SESSION['TipoUs']) || $_SESSION['dash']!='true'||empty($_SESSION)){
    header('Location: '.env('URL').'login ');
            exit();
}elseif($_SESSION['TipoUs']=='NA' || $_SESSION['TipoUs']!='Supervisor'){
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
    <!-- <link rel="stylesheet" href="../css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.css">
    <title>Galeria</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
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
    <a class="btn btn-outline-dark align-item-center" href='<?php echo env('URL').'sup/registros';?>'><span class="ms-1 d-sm-inline bi bi-arrow-bar-left fs-4"></span>&nbsp;Regresar</a>
    </div>
<div class="p-3 container">
    <h2 class="text-center mb-4">
        Galería de Evidencias
    <br><br>
    {{$bitacora->nomRama}}&nbsp;
    @if ($bitacora->trab == 'Troncal' || $bitacora->trab == 'Enlace' || $bitacora->trab == 'Distribución')
    Levantamiento {{$bitacora->trab}}<br>{{$bitacora->ciudad}},&nbsp;{{$bitacora->estado}}
    @else
    {{$bitacora->trab}}<br>{{$bitacora->ciudad}},&nbsp;{{$bitacora->estado}}
    @endif
    </h2>
</div>
<div class="ms-5 mt-3">
    <a class="btn btn-outline-dark align-item-center" href='<?php echo env('URL').'bit/view/'.$id_bit;?>'>Agregar Fotos</a>
    {{-- <div class="container">filtros</div> --}}
<div class='ms-3 mt-3 text-end me-2'>
        <div class="d-inline-flex">
            <form action='{{route("kml")}}' method="post">
                @csrf
                @method('post')
                <?php
                    echo '<input type="hidden" name="id" value='.$id_bit.'>';
                ?>
                <button type="submit" class="btn btn-outline-primary">Descargar kml*</button>
                <p class="text-muted">* el kml contiene todos los puntos listados</p>
            </form>
        </div>
        <div class="d-inline-flex">
            <form action='{{route("xls")}}' method="post">
                @csrf
                @method('post')
                <?php
                    echo '<input type="hidden" name="id" value='.$id_bit.'>';
                ?>
                <button type="submit" class="btn btn-outline-dark">xls</button>
                <!-- <p class="text-muted">* el kml contiene todos los puntos listados</p> -->
            </form>
        </div>
    </div>
</div>
</div>
<br> <br>

<div class="container row row-cols-3">
    <?php
    $i = 0;
    foreach($evidencias as $ev){
        echo'<div class="card col-12 col-sm-12 col-md-6 pt-3 ps-1 evidencia" id="'.$i.'">';
            echo'<div class="container row row-cols-2">';
                echo '<h6 class="card-title">'.$ev->nombre.'</h6>';
                echo'<input type="hidden" value="'.$ev->id.'" class="id_ev" id="id_ev">';
                echo '<p class="d-flex flex-row-reverse text-primary text-opacity-50">'.$ev->status.'</p>';
            echo '</div>';
            // echo '<div class="container row row-cols-2">
            //         <img src="'.asset($ev->foto).'" class="rounded col-7" alt="" title="">
            //         <p class="col-5">'.$ev->descripcion.'</p>
            //       </div>';
            echo '<div class="container row row-cols-2">
                    <img src="'.$ev->foto.'" class="rounded col-12 col-sm-7" alt="" title="">
                    <p class="col-12 col-sm-5">'.$ev->descripcion.'</p>
                  </div>';
            //echo'<img src="'.asset($ev->foto).'" alt="" title="">';
            echo'
                <div class="card-body">';
            echo'   <a class="btn btn-outline-warning see_more">Ver mas..</a>
                </div> ';
            // echo'
            //     <p class="some_txt">Some random text </p>
            //     <p class="product">Producto: </p>
            //     <p class="quantity">Cantidad: </p>
            // ';
            echo'
                  <table class=" table table_ins">
                      <thead>
                          <tr>
                              <th class="text-center">Producto</th>
                              <th class="text-center">Cantidad</th>
                          </tr>
                      </thead>
                      <tbody class="content">

                      </tbody>
                  </table>
            ';
            echo '</div>';
            $i++;
    }
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      //$("#table_ins").hide();
      $('p.some_txt').hide();
      $('p.product').hide();
      $('p.quantity').hide();
      $('table.table_ins').hide();
      //$('.data').empty();
      //
      // $("#show").click(function(){
      //var tableD = $("#product").parent().addClass("table");
      //$("#table").hide();
      //tableD.hide();
      //   $("table").show();
      // })
      $('a.see_more').click(function(event){
        var id_evidence = $(this).parents('.evidencia').find('.id_ev').val();
        // var prod = "hola";
        // var cant = "bye";
        console.log(id_evidence);
        //$('.data').empty();
        event.preventDefault();
        // $(this).parents('.evidencia').find('.some_txt').toggle();
        // $(this).parents('.evidencia').find('.product').toggle();
        // $(this).parents('.evidencia').find('.quantity').toggle();
        $(this).parents('.evidencia').find('.content').empty();
        var my_div = $(this).parents('.evidencia').find('.data');
        var my_tr = $(this).parents('.evidencia').find('.content');
        var my_prod = $(this).parents('.evidencia').find('.my_prod');
        var my_cant = $(this).parents('.evidencia').find('.my_cant');
        $(this).parents('.evidencia').find('.table_ins').toggle();
        //$('table.table_ins').toggle();
        //var button = $('a.see_more');
        //$("#table_ins").toggle();
        $.ajax({
          type: "POST",
          url: "{{ route('insum') }}",
          data: {
              "_token": "{{ csrf_token() }}",
              id: id_evidence
          },
          dataType: "json",
          error: function(error){
              console.log(JSON.stringify(error));
          },
          success: function(data){
            console.log(data);
            data.forEach(item => {
                //tableD.show();
                //$("#table").show();
                //$(this).parents('.evidencia').find('.some_txt').show();
                // $("#product").text(item.nombre);
                // $("#quantity").text(item.cantidad);

                prod = item.nombre;
                cant = item.cantidad;
                //$('a.see_more').parents('.evidencia').find('.product').text(prod)
                //$('a.see_more').parents('.evidencia').find('.quantity').text(cant)
                //$("<div>"+prod+": "+cant+"</div>").appendTo(my_div);
                $("<tr> <td class='text-center'>"+prod+"</td> <td class='text-center'>"+cant+"</td> </tr>").appendTo(my_tr);
                //$(my_prod).text(prod);
                //$(my_cant).text(cant);
                // button.parents('.evidencia').find('p.product').empty().append(prod);
                // $('.evidencia').find('.product').html("<b>'prod'</b>");
                // $('.evidencia').find('.quantity').text(cant);
            })
          }
        })

      })
    })
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.1/dist/bootstrap-table.min.js"></script>
</body>
</html>
